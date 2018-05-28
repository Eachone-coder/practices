@extends('layouts.admin')
@section('content')
<!--搜索结果页面 列表 开始-->
<form action="#" method="post">
    <div class="result_wrap">
        <div class="result_content">
            <table class="list_tab">
                <tr>
                    <th class="tc">ID</th>
                    <th>IP</th>
					<th>地址</th>
                    <th>访问文章</th>
					<th>访问设备信息</th>
                    <th>访问时间</th>
                </tr>
                @foreach($visis as $visi)
                <tr>
                    <td class="tc">{{$visi->visi_id}}</td>
                    <td>
                        <a href="#">{{long2ip($visi->visi_ip)}}</a>
                    </td>
					<td>{{$visi->visi_addr=='0'?'暂无':$visi->visi_addr}}</td>
                    <td>{{$visi->art_title}}</td>
					<td>{{$visi->visi_deviceinfo=='0'?'暂无':$visi->visi_deviceinfo}}</td>
                    <td>{{date('Y-m-d H:i:s',$visi->created_at)}}</td>
                </tr>
                @endforeach
            </table>
            <div class="page_list">
                {{$visis->render()}}
            </div>
        </div>
    </div>
</form>
<script>

</script>
<style>
    .result_content ul li span {
        font-size: 15px;
        padding: 6px 12px;
    }
</style>
@stop