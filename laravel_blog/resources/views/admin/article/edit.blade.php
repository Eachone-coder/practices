@extends('layouts.admin')
<style>
    .edui-default{line-height: 28px;}
    div.edui-combox-body,div.edui-button-body,div.edui-splitbutton-body
    {overflow: hidden; height:20px;}
    div.edui-box{overflow: hidden; height:22px;}
</style>
@section('content')
    <!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>添加文章</h3>
            @if(count($errors)>0)
                <div class="mark">
                    @if(is_object($errors))
                        @foreach($errors->all() as $error)
                            <p>{{$error}}</p>
                        @endforeach
                    @else
                        <p>{{$errors}}</p>
                    @endif
                </div>
            @endif
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/article/create')}}"><i class="fa fa-plus"></i>添加文章</a>
                <a href="{{url('admin/article')}}"><i class="fa fa-recycle"></i>全部文章</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    <div class="result_wrap">
        <form action="{{url('admin/article/'.$field->art_id)}}" method="post">
            <input type="hidden" name="_method" value="put">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                <tr>
                    <th width="120"><i class="require">*</i>分类：</th>
                    <td>
                        <select name="cate_id">
                            @foreach($data as $d)
                                <option value="{{$d->cate_id}}" {{$d->cate_id==$field->cate_id?'selected':''}}>{{$d->cate_name}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>文章标题：</th>
                    <td>
                        <input type="text" class="lg" name="art_title" value="{{$field->art_title}}">
                    </td>
                </tr>
                <tr>
                    <th>描述：</th>
                    <td>
                        <textarea name="art_description">{{$field->art_description}}</textarea>
                    </td>
                </tr>
                <tr>
                    <th>文章内容：</th>
                    <td>
                        <!--<script type="text/javascript" charset="utf-8" src="{{asset('ueditor/ueditor.config.js')}}"></script>
                        <script type="text/javascript" charset="utf-8" src="{{asset('ueditor/ueditor.all.min.js')}}"> </script>
                        <script type="text/javascript" charset="utf-8" src="{{asset('ueditor/lang/zh-cn/zh-cn.js')}}"></script>
						<script id="editor" name="art_content" type="text/plain" style="width:860px;height:500px;">{!! $field->art_content !!}</script>
                        <script>UE.getEditor('editor');</script>-->
						<link rel="stylesheet" href="{{asset('editor.md/css/editormd.css')}}" />   
						<script src="{{asset('editor.md/editormd.js')}}"></script>
						<div id="editormd">
							<textarea style="display:none;" name="art_content"></textarea>
						</div>
						<script type="text/javascript">
						val=$('input[name="art_title"]').val();
						var Editor;
						$(function() {
							$.get('/markdown/'+val+'.md', function(md){
								Editor = editormd("editormd", {
									width: "100%",
									height: 740,
									path : '/editor.md/lib/',
									markdown : md,
									//theme : "dark",
									//previewTheme : "dark",
									//editorTheme : "pastel-on-dark",
									codeFold : true,
									//syncScrolling : false,
									saveHTMLToTextarea : true,    // 保存 HTML 到 Textarea
									searchReplace : true,
									//watch : false,                // 关闭实时预览
									htmlDecode : "style,script,iframe|on*",            // 开启 HTML 标签解析，为了安全性，默认不开启    
									//toolbar  : false,             //关闭工具栏
									//previewCodeHighlight : false, // 关闭预览 HTML 的代码块高亮，默认开启
									emoji : true,
									taskList : true,
									tocm            : true,         // Using [TOCM]
									tex : false,                   // 开启科学公式TeX语言支持，默认关闭
									flowChart : true,             // 开启流程图支持，默认关闭
									sequenceDiagram : true,       // 开启时序/序列图支持，默认关闭,
									//dialogLockScreen : false,   // 设置弹出层对话框不锁屏，全局通用，默认为true
									//dialogShowMask : false,     // 设置弹出层对话框显示透明遮罩层，全局通用，默认为true
									//dialogDraggable : false,    // 设置弹出层对话框不可拖动，全局通用，默认为true
									//dialogMaskOpacity : 0.4,    // 设置透明遮罩层的透明度，全局通用，默认值为0.1
									//dialogMaskBgColor : "#000", // 设置透明遮罩层的背景颜色，全局通用，默认为#fff
									imageUpload : true,
									imageFormats : ["jpg", "jpeg", "gif", "png", "bmp", "webp"],
									imageUploadURL : "/editor.md/php/upload.php",
									onload : function() {
										console.log('onload', this);
										//this.fullscreen();
										//this.unwatch();
										//this.watch().fullscreen();

										//this.setMarkdown("#PHP");
										//this.width("100%");
										//this.height(480);
										//this.resize("100%", 640);
									}
								});
							});
						});
					</script>
                    </td>
                </tr>
                <tr>
                    <th></th>
                    <td>
                        <input type="submit" value="提交">
                        <input type="button" class="back" onclick="history.go(-1)" value="返回">
                    </td>
                </tr>
                </tbody>
            </table>
        </form>
    </div>

@stop
