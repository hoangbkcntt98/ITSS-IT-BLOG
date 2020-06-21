<body>
	<header id="header"><!--header-->
		<div class="header_top"><!--header_top-->
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<div class="contactinfo">
							<ul class="nav nav-pills">
								<li><a href="#"><i class="fa fa-phone"></i> +84 853 025 821</a></li>
								<li><a href="#"><i class="fa fa-envelope"></i> info@hust.com</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="social-icons pull-right">
							<ul class="nav navbar-nav">
								<li><a href="#"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
								<li><a href="#"><i class="fa fa-dribbble"></i></a></li>
								<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header_top-->

		<div class="header-middle"><!--header-middle-->
			<div class="container">
				<div class="row">
					<div class="col-sm-4">
						<div class="pull-left">
							<a href="{{route('/')}}"><img src="{{asset('layouts/images')}}/home/logo.png" alt="" height="60px" /></a>
						</div>

					</div>
					<div class="col-sm-8">
						<div class="shop-menu pull-right">
							<ul class="nav navbar-nav">
							@guest
                            	<li><a href="{{ route('login') }}"><i class="fa fa-lock"></i>Login</a></li>
                            		@if (Route::has('register'))
                                		<li><a href="{{ route('register') }}"><i class="fa fa-lock"></i>Register</a></li>
                            		@endif
								@else
								<li class="dropdown">
                                	<a href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    	{{ Auth::user()->name }}
                                    	<span class="caret"></span>
                                	</a>

                                	<ul role = "menu" class="sub-menu">
                                    	<li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Logout
                                    	</a></li>
                                    	<li><a href="{{route('user.index')}}">
                                        	View profile
                                    	</a></li>

                                    	<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        	@csrf
                                    	</form>
                                	</ul>
                            	</li>
                        	@endguest
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-middle-->

		<div class="header-bottom"><!--header-bottom-->
			<div class="container">
				<div class="row">
					<div class="col-sm-9">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						<div class="mainmenu pull-left">
							<ul class="nav navbar-nav collapse navbar-collapse">
								<li><a href="/" class="active">Home</a></li>
								<li><a href="#">News</a></li>
								<li class="dropdown"><a href="/list">Products<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        <li><a href="/list">Products</a></li>
{{--										<li><a href="/product-details">Product Details</a></li>--}}
                                    </ul>
                                </li>
{{--								<li class="dropdown"><a href="#">Reviews<i class="fa fa-angle-down"></i></a>--}}
{{--                                    <ul role="menu" class="sub-menu">--}}
{{--                                        <li><a href="blog.html">Top </a></li>--}}
{{--										<li><a href="blog-single.html">Blog Single</a></li>--}}
{{--                                    </ul>--}}
{{--                                </li>--}}
								<li><a href="#">Contact</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="search_box pull-right">
							<form action="{{route('search')}}" method="GET" class="search-form">
								<input type="text" name="query" id="query" class="search-box" placeholder="Search"/>
								<div id="suggestion-box"></div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-bottom-->
	</header><!--/header-->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
 $(document).ready(function () {
	$('#query').keyup(function(){
		var query = $(this).val();
		if(query != '')
		{
			$.ajax({
			url:"{{ route('autocomplete')}}",
			method:"GET",
			data:{'query':query},
			success:function(data){
				$('#suggestion-box').html(data);
				}
			});
		}
	});

	$(document).on('click', 'li', function(){
		var value = $(this).text();
		// assign the value to the search box
		$('#query').val(value);
		// after click is done, search results segment is made empty
		$('#suggestion-box').html("");
	});

 });
</script>
