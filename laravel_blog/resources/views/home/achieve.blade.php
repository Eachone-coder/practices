<!DOCTYPE html>
<html lang="Zh_cn" xmlns:v-on="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{asset('home/css/fishboneDiagram.css')}}" rel="stylesheet">
    </head>
<body id="body">
<div id="content-wrap">
    <div class="container">
        <div class="posts-count">共{{$count}}篇文章</div>
        <div id="cd-timeline" class="cd-container" style="margin: 0 0">
		@foreach($data as $vo)
			<div class="cd-timeline-block">
				<div class="cd-timeline-img cd-picture">
				</div>
				<div class="cd-timeline-content">
					<a href="{{url('a/'.$vo->art_id)}}">
						<div class="title">{{$vo->art_title}}</div>
					</a>
					<span class="cd-date">{{date('Y-m-d',$vo->created_at)}}</span>
				</div>
			</div>
        @endforeach        
        </div>
        <div class="dot"></div>
	</div>
</div>
</body>
</html>
