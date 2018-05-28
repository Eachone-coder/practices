<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;
use App\Http\Model\Category;
use App\Http\Model\Comment;
use App\Http\Model\Visitor;
use Illuminate\Http\Request;
use App\Services\RssFeed;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class IndexController extends CommonController{
    public function index(){
		$data=Article::orderBy('updated_at','desc')->select('art_id','art_title','art_description','created_at')
                                                   ->paginate(10);
        return view('home.index',compact('data'));
    }
    public function cate($cate_id){
        $field=Category::find($cate_id);
        $data=Article::where('cate_id',$cate_id)->orderBy('created_at','desc')
                                                 ->select('art_id','art_title','art_description','created_at')
                                                 ->paginate(10);
        return view('home.index',compact('field','data'));
    }
    public function article(Request $request,$art_id){
        $comments=Comment::orderBy('created_at','desc')->where('art_id',$art_id)
                                                         ->where('comm_status',1)
                                                         ->get();
        $field = Article::Join('category','article.cate_id','=','category.cate_id')->where('art_id',$art_id)->first();
        //查看次数自增
        Article::where('art_id',$art_id)->increment('art_view');
		//访客
		$visitor=new Visitor();
		$visitor->visi_ip=ip2long($request->ip());
		$visitor->visi_addr=ip2address($request->ip());
		$visitor->visi_deviceinfo=getDeviceInfo();
		$visitor->art_id=$art_id;
		$visitor->save();
        return view('home.new',compact('field','comments'));
    }
	public function rss(RssFeed $feed){
		$rss = $feed->getRSS();
		return response($rss)
		->header('Content-type', 'application/rss+xml');
	}
	public function achieve(){
		$data=Article::orderBy('created_at','desc')->select('art_id','art_title','created_at')
                                                   ->get();
		$count=Article::count();
        return view('home.achieve',compact('data','count'));
	}
}
