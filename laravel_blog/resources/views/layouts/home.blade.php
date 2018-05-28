<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{asset('zjx.ico')}}" type="image/x-icon">
    <link rel="shortcut icon" href="{{asset('zjx.ico')}}" type="image/x-icon">
    @section('info')
    <meta name="description" content="">
    <meta name="author" content="">
    <title>{{Config::get('web.web_title')}}</title>
    @show
    <!-- Bootstrap Core CSS -->
    <link href="{{asset('bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Theme CSS -->
    <link href="{{asset('home/css/clean-blog.min.css')}}" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="{{asset('font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	@section('js')
		<!-- jQuery -->
		<script src="{{asset('jquery/jquery.min.js')}}"></script>
		<!-- Bootstrap Core JavaScript -->
		<script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
		<!-- Contact Form JavaScript -->
		<script src="{{asset('home/js/jqBootstrapValidation.js')}}"></script>
		<script src="{{asset('home/js/contact_me.js')}}"></script>
		<!-- Theme JavaScript -->
		<script src="{{asset('home/js/clean-blog.min.js')}}"></script>
		<!-- GoUp JavaScript -->
		<script src="{{asset('home/js/jquery.goup.min.js')}}"></script>
	@show
</head>
<body>

<!-- Navigation -->
<nav class="navbar navbar-default navbar-custom navbar-fixed-top">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header page-scroll">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                Menu <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand" href="{{url('/')}}">{{Config::get('web.web_title')}}</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                @foreach($navs as $nav)
                <li>
                    <a href="{{$nav->nav_url}}">{{$nav->nav_name}}</a>
                </li>
                @endforeach
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>
@yield('content')
<!-- Footer -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <ul class="list-inline text-center">
                    <li>
                        <a href="https://github.com/git-zjx" data-toggle="tooltip" title="github">
							<span class="fa-stack fa-lg">
								<i class="fa fa-circle fa-stack-2x"></i>
								<i class="fa fa-github fa-stack-1x fa-inverse"></i>
							</span>
                        </a>
                    </li>
					<li>
						<a href="{{ url('/rss') }}" data-toggle="tooltip" title="RSS feed">
							<span class="fa-stack fa-lg">
								<i class="fa fa-circle fa-stack-2x"></i>
								<i class="fa fa-rss fa-stack-1x fa-inverse"></i>
							</span>
						</a>
					</li>
					<li>
						<a href="{{ url('/achieve') }}" data-toggle="tooltip" title="归档">
							<span class="fa-stack fa-lg">
								<i class="fa fa-circle fa-stack-2x"></i>
								<i class="fa fa-calendar fa-stack-1x fa-inverse"></i>
							</span>
						</a>
					</li>
                </ul>
                <p class="copyright text-muted">Copyright &copy; 冀ICP备17002048号 ZJX BLOG 2016-{{date('Y')}}</p>
            </div>
        </div>
    </div>
</footer>
<script>
$(function(){
	$.goup({
		trigger: 100,
		bottomOffset: 150,
		locationOffset: 100,
		title: '返回顶部',
		titleAsText: false
    });
});
</script>
</body>
</html>