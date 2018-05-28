<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Comment;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class CommentController extends CommonController{
    /**
     * 评论
     */
    public function comment(Request $request){
        $input=Input::except('_token');
        $rules=[
            'art_id'=>'required',
            'comm_content'=>'required|between:10,255',
        ];
        $message=[
            'art_id.required'=>'文章ID不能为空',
            'comm_content.required'=>'评论内容不能为空',
            'comm_content.between'=>'评论内容为10-255个汉字',
        ];
        $validator=Validator::make($input,$rules,$message);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }
        $comment=new Comment();
        $comment->comm_ip=ip2long($request->ip());
        $comment->comm_content=$input['comm_content'];
        $comment->art_id=$input['art_id'];
        if($comment->save()){
            return back()->with('errors','评论成功');
        }else{
            return back()->with('errors','评论失败');
        }
    }
}