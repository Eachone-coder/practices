@extends('layouts.home')
@section('info')
    <title>{{$field->cate_name}}-{{$field->art_title}}</title>
    <meta name="keywords" content={{$field->cate_description}} />
    <meta name="description" content={{$field->cate_description}}/>
@stop
@section('content')
	<style>
		p {
			line-height: 1.5;
			margin: 10px 0;
		}
	</style>
	<!--<link rel="stylesheet" href="{{asset('highlight/src/styles/default.css')}}">
    <script type="text/javascript" src="{{asset('highlight/src/highlight.js')}}"></script>
	<script >hljs.initHighlightingOnLoad();</script>  -->
	<link href="https://cdn.bootcss.com/highlight.js/8.5/styles/default.min.css" rel="stylesheet"> 
	<script src="https://cdn.bootcss.com/highlight.js/8.5/highlight.min.js"></script> 
	<script>hljs.initHighlightingOnLoad();</script> 
    <!-- Page Header -->
    <!-- Set your background image for this header on the line below. -->
    <header class="intro-header" style="background-image: url('{{asset('home/img/bg.jpg')}}')">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="post-heading">
                        <h1>{{$field->art_title}}</h1>
                        <h2 class="subheading">{{$field->art_description}}</h2>
                        <span class="meta">{{date('Y-m-d',$field->created_at)}}</span>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Post Content -->
    <article>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                   {!! $field->art_content !!}
                </div>
            </div>
            <hr>
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                @foreach($comments as $comment)
                    <p>{{long2ip($comment->comm_ip)}}（{{date('Y-m-d H:i',$comment->created_at)}}）：</p>
                    <p>{{$comment->comm_content}}</p>
                @endforeach
            </div>
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                @if(count($errors))
                    @if(is_object($errors))
                        <div class="mark">
                            @foreach($errors->all() as $error)
                                <p>{{$error}}</p>
                            @endforeach
                        </div>
                    @else
                        <div class="mark">
                            <p>{{$errors}}</p>
                        </div>
                    @endif
                @endif
                <form role="form" action="{{url('comment/create')}}" method="post">
                    {{csrf_field()}}
                    <div class="form-group">
                        <textarea name="comm_content" class="form-control" rows="3" placeholder="评论·····"></textarea>
                    </div>
                    <input type="hidden" name="art_id" value="{{$field->art_id}}">
                    <button type="submit" class="btn btn-default">提交</button>
                </form>
            </div>
        </div>
    </article>
    <hr>
@stop