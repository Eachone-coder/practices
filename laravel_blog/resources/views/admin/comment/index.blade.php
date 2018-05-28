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
                    <th>IP</th>
                    <th>内容</th>
                    <th>评论时间</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>
                @foreach($comms as $comm)
                <tr>
                    <td class="tc"><input type="checkbox" name="id[]" value="{{$comm->comm_id}}"></td>
                    <td class="tc">{{$comm->comm_id}}</td>
                    <td>
                        <a href="#">{{long2ip($comm->comm_ip)}}</a>
                    </td>
                    <td>{{$comm->comm_content}}</td>
                    <td>{{date('Y-m-d H:i:s',$comm->created_at)}}</td>
                    <td>{{$comm->comm_status==0?'未通过':'通过'}}</td>
                    <td>
                        <a href="javascript:void(0)" onclick="allowComm({{$comm->comm_id}})">通过</a>
                    </td>
                </tr>
                @endforeach
            </table>
            <div class="page_list">
                {{$comms->render()}}
            </div>
        </div>
    </div>
</form>
<script>
    function allowComm(comm_id){
        layer.confirm('您确定要通过这个评论吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            $.post("{{url('admin/comment/allowComment')}}",{'_token':"{{csrf_token()}}",'comm_id':comm_id},function (data) {
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
    function changeOrder(obj,cate_id){
        var cate_order = $(obj).val();
        $.post("{{url('admin/cate/changeorder')}}",{'_token':'{{csrf_token()}}','cate_id':cate_id,'cate_order':cate_order},function(data){
            if(data.status == 0){
                layer.msg(data.msg, {icon: 6});
            }else{
                layer.msg(data.msg, {icon: 5});
            }
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