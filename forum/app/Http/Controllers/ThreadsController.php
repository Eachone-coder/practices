<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Filters\ThreadsFilters;
use App\Inspections\Spam;
use App\Rules\Recaptcha;
use App\Thread;
use App\Trending;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Zttp\Zttp;

class ThreadsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index','show']);
    }

    public function index(Channel $channel,ThreadsFilters $filters,Trending $trending)
    {
        $threads = $this->getThreads($channel, $filters);

        if(request()->wantsJson()){
            return $threads;
        }

        return view('threads.index',[
            'threads' => $threads,
            'trending' => $trending->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('threads.create');
    }

    public function store(Recaptcha $recaptcha)
    {
        request()->validate([
            'title' => 'required|spamfree',
            'body' => 'required|spamfree',
            'channel_id' => 'required|exists:channels,id',
            'g-recaptcha-response' => ['required',$recaptcha]
        ]);

        $thread = Thread::create([
            'user_id' => auth()->id(),
            'channel_id' => request('channel_id'),
            'title' => request('title'),
            'body' => request('body')
        ]);

        if (request()->wantsJson()) {
            return response($thread,201);
        }

        return redirect($thread->path())
            ->with('flash','Your thread has been published!');
    }

    public function show($channel,Thread $thread,Trending $trending)
    {
        if(auth()->check()){
            auth()->user()->read($thread);
        }

        $trending->push($thread);

        $thread->increment('visits');

        return view('threads.show',compact('thread'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    public function update($channelId,Thread $thread)
    {
        // 应用授权策略
        $this->authorize('update',$thread);
        // 验证规则
        $thread->update(request()->validate([
            'title' => 'required|spamfree',
            'body' => 'required|spamfree'
        ]));

        return $thread;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy($channel,Thread $thread)
    {
        $this->authorize('update',$thread);

        $thread->delete();

        if(request()->wantsJson()){
            return response([],204);
        }

        return redirect('/threads');
    }

    protected function getThreads(Channel $channel, ThreadsFilters $filters)
    {
        $threads = Thread::with('channel')->latest()->filter($filters);

        if ($channel->exists) {
            $threads->where('channel_id', $channel->id);
        }

        $threads = $threads->paginate(20);

        return $threads;
    }
}
