@extends('layouts.admin')
@section('content')
<!--搜索结果页面 列表 开始-->
<form action="#" method="post">
    <div class="result_wrap">
        <!--快捷导航 开始-->
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/article/create')}}"><i class="fa fa-plus"></i>添加文章</a>
                <a href="{{url('admin/article')}}"><i class="fa fa-recycle"></i>全部文章</a>
            </div>
        </div>
        <!--快捷导航 结束-->
    </div>

    <div class="result_wrap">
        <div class="result_content">
            <table class="list_tab">
                <tr>
                    <th class="tc" width="5%"><input type="checkbox" name=""></th>
                    <th class="tc">ID</th>
                    <th>标题</th>
                    <th>点击</th>
                    <th>更新时间</th>
                    <th>操作</th>
                </tr>
                @foreach($articles as $article)
                <tr>
                    <td class="tc"><input type="checkbox" name="id[]" value="{{$article->art_id}}"></td>
                    <td class="tc">{{$article->art_id}}</td>
                    <td>
                        <a href="{{url('a/'.$article->art_id)}}" target="_blank">{{$article->art_title}}</a>
                    </td>
                    <td>{{$article->art_view}}</td>
                    <td>{{date('Y-m-d H:i:s',$article->created_at)}}</td>
                    <td>
                        <a href="{{url('admin/article/'.$article->art_id.'/edit')}}">修改</a>
                        <a href="javascript:void(0)" onclick="delArticle({{$article->art_id}})">删除</a>
                    </td>
                </tr>
                @endforeach
            </table>
            <div class="page_list">
                {{$articles->render()}}
            </div>
        </div>
    </div>
</form>
<script>
    function delArticle(art_id){
        layer.confirm('您确定要删除这篇文章吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            $.post("{{url('admin/article/')}}/"+art_id,{'_method':'delete','_token':"{{csrf_token()}}"},function (data) {
                if(data.status==0){
                    location.href = location.href;
                    layer.msg(data.msg, {icon: 6});
                }else{
                    layer.msg(data.msg, {icon: 5});
                }
            });
        }, function(){

        });
    }
</script>
<style>
    .result_content ul li span {
        font-size: 15px;
        padding: 6px 12px;
    }
</style>
@stop