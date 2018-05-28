@extends('layouts.home')
@section('content')
    <!-- Page Header -->
    <!-- Set your background image for this header on the line below. -->
    <header class="intro-header" style="background-image: url('{{asset('home/img/bg.jpg')}}')">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="site-heading">
                        <h1>{{Config::get('web.web_title')}}</h1>
                        <hr class="small">
                        <span class="subheading">{{Config::get('web.web_description')}}</span>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                @foreach($data as $vo)
                <div class="post-preview">
                    <a href="{{url('a/'.$vo->art_id)}}">
                        <h2 class="post-title">
                            {{$vo->art_title}}
                        </h2>
                        <h3 class="post-subtitle">
                            {{$vo->art_description}}
                        </h3>
                    </a>
                    <p class="post-meta">{{date('Y-m-d',$vo->created_at)}}</p>
                </div>
                <hr>
                @endforeach
                    {{-- 分页 --}}
                <ul class="pager">
                    @if ($data->currentPage() > 1)
                        <li class="previous">
                            <a href="{!! $data->url($data->currentPage() - 1) !!}">
                                <i class="fa fa-long-arrow-left fa-lg"></i>
                                Newer
                            </a>
                        </li>
                    @endif
                    @if ($data->hasMorePages())
                        <li class="next">
                            <a href="{!! $data->nextPageUrl() !!}">
                                Older
                                <i class="fa fa-long-arrow-right"></i>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <hr>
@stop
