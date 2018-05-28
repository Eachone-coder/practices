<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Article;
use App\Http\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ArticleController extends CommonController{
    //全部文章列表
    public function index(){
        $articles=Article::orderBy('art_id','desc')->paginate(15);
        return view('admin.article.index',compact('articles'));
    }

    //添加文章
    public function create(){
        $data=Category::All();
        return view('admin/article/add',compact('data'));
    }

    //添加文章提交
    public function store(Request $request){
        $input=Input::except('_token','fileselect');
		saveFile($input['art_title'],'md',$input['art_content'],public_path('markdown'));
		$input['art_content']=$input['editormd-html-code'];
        $rules=[
            'art_title'=>'required',
            'art_content'=>'required',
            'art_description'=>'required',
        ];
        $message=[
            'art_title'=>'文章标题不能为空',
            'art_content'=>'文章内容不能为空',
            'art_content'=>'文章描述不能为空',
        ];
        $validator=Validator::make($input,$rules,$message);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }
		unset($input['editormd-html-code']);
        $article=new Article();
        $article->art_title=$input['art_title'];
        $article->art_description=$input['art_description'];
        $article->art_content=$input['art_content'];
        $article->cate_id=$input['cate_id'];
        $article->art_view=0;
        if($article->save()){
            return back()->with('errors','添加成功');
        }else{
            return back()->with('errors','添加失败');
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

    //编辑文章
    public function edit($art_id){
        $data=Category::All();
        $field=Article::find($art_id);
        return view('admin/article/edit',compact('data','field'));
    }

    //更新文章
    public function update(Request $request, $art_id){
        $input=Input::except('_token','fileselect','_method');
		saveFile($input['art_title'],'md',$input['art_content'],public_path('markdown'));
		$input['art_content']=$input['editormd-html-code'];
        $rules=[
            'art_title'=>'required',
            'art_content'=>'required',
        ];
        $message=[
            'art_title'=>'文章标题不能为空',
            'art_content'=>'文章内容不能为空',
        ];
        $validator=Validator::make($input,$rules,$message);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }
		unset($input['editormd-html-code']);
        $re=Article::where('art_id',$art_id)->update($input);
        if($re){
            return back()->with('errors','修改成功');
        }else{
            return back()->with('errors','修改失败');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($art_id){
        $re=Article::where('art_id',$art_id)->delete();
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
}
