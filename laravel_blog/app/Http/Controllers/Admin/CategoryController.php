<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class CategoryController extends CommonController{
    //get
    public function index(){
        $categorys = Category::All();
        return view('admin/category/index',['data'=>$categorys]);
    }
    //get 添加分类
    public function create(){
        return view('admin/category/add');
    }
    //post 添加分类提交
    public function store(){
        $input=Input::except('_token');
        $rules=[
            'cate_name'=>'required',
        ];
        $message=[
            'cate_name.required'=>'分类名称不能为空',
        ];
        $validator=Validator::make($input,$rules,$message);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }
        $category=new Category();
        $category->cate_name=$input['cate_name'];
        $category->cate_order=$input['cate_order'];
        if($category->save($input)){
            return back()->with('errors','添加成功！');
        }else{
            return back()->with('errors','添加失败！');
        }
    }
    //get 显示单个分类
    public function show(){

    }
    //delete 删除单个分类
    public function destroy($cate_id){
        $re=Category::where('cate_id',$cate_id)->delete();
        if($re){
            $data=[
                'status'=>0,
                'msg'=>'删除成功'
            ];
        }else{
            $data=[
                'status'=>0,
                'msg'=>'删除失败'
            ];
        }
        return $data;
    }
    //get 编辑分类
    public function edit($cate_id){
        $field=Category::find($cate_id);
        return view('admin/category/edit',[
            'field'=>$field,
        ]);
    }
    //put/patch 更新分类
    public function update($cate_id){
        $input=Input::except('_method','_token');
        $re=Category::where('cate_id',$cate_id)->update($input);
        if($re){
            return back()->with('errors','修改成功！');
        }else{
            return back()->with('errors','修改失败！');
        }
    }
    public function changeOrder(){
        $input=Input::all();
        $cate=Category::find($input['cate_id']);
        $cate->cate_order=$input['cate_order'];
        if($cate->update()){
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
