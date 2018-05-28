<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Navs;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class NavsController extends CommonController{

    public function index(){
        $data=Navs::orderBy('nav_order','asc')->get();
        return view('admin/navs/index',compact('data'));
    }

    public function create(){
        return view('admin/navs/add');
    }

    public function store(Request $request){
        $input=$request->except('_token');
        $rules=[
            'nav_name'=>'required',
            'nav_url'=>'required',
        ];
        $message=[
            'nav_name.required'=>'链接名称不能为空',
            'nav_url.required'=>'链接不能为空',
        ];
        $validator=Validator::make($input,$rules,$message);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }
        $navs=new Navs();
        $navs->nav_name=$input['nav_name'];
        $navs->nav_url=$input['nav_url'];
        $navs->nav_order=$input['nav_order'];
        if($navs->save()){
            return back()->with('errors','添加成功！');
        }else{
            return back()->with('errors','添加失败！');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($nav_id){
        $field=Navs::find($nav_id);
        return view('admin/navs/edit',compact('field'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $nav_id){
            $input=$request->except('_token','_method');
            $rules=[
                'nav_name'=>'required',
                'nav_url'=>'required',
            ];
            $message=[
                'nav_name.required'=>'链接名称不能为空',
                'nav_url.required'=>'链接不能为空',
            ];
            $validator=Validator::make($input,$rules,$message);
            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }
            if(Navs::where('nav_id',$nav_id)->update($input)){
                return back()->with('errors','修改成功！');
            }else{
                return back()->with('errors','修改失败！');
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($nav_id){
        $re=Navs::where('nav_id',$nav_id)->delete();
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
    public function changeOrder(){
        $input=Input::all();
        $nav=Navs::find($input['nav_id']);
        $nav->nav_order=$input['nav_order'];
        if($nav->update()){
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
