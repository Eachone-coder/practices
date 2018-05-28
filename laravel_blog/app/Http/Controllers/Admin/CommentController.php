<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Comment;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class CommentController extends CommonController{

    public function index(){
        $comms=Comment::orderBy('comm_status','asc')->paginate(15);
        return view('admin/comment/index',compact('comms'));
    }
    public function allowComment(){
        $input=Input::all();
        $comm=Comment::find($input['comm_id']);
        $comm->comm_status=1;
        if($comm->update()){
            $data=[
                'status'=>0,
                'msg'=>'成功'
            ];
        }else{
            $data=[
                'status'=>0,
                'msg'=>'失败'
            ];
        }
        return $data;
    }
}
