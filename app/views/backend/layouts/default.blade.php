<body>
	<!-- Container -->
	<div class="container">

	<!-- Navigation -->
		<nav class="navbar navbar-default" role="navigation">
		  <div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			  <a class="navbar-brand" href="{{ URL::to('admin') }}">Admin</a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li{{ (Request::is('admin') ? ' class="active"' : '') }}>
						<a href="{{ URL::to('admin') }}">
							<i class="icon-home icon-white"></i>
							Home</a>
					</li>
					<li class="dropdown{{ (Request::is('admin/users*')||Request::is('admin/groups*')) ? ' active' : '' }}">
						<a class="dropdown-toggle" data-toggle="dropdown" href="{{ URL::to('admin/users') }}">
							<i class="icon-user icon-white"></i>サイトアカウント管理<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li{{ (Request::is('admin/users*') ? ' class="active"' : '') }}>
								<a href="{{ URL::to('admin/users') }}">
									<i class="icon-user"></i>ユーザー</a></li>
							<li{{ (Request::is('admin/groups*') ? ' class="active"' : '') }}>
								<a href="{{ URL::to('admin/groups') }}">
									<i class="icon-user"></i>グループ</a></li>
						</ul>
					</li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					{{--
					<li><a href="{{ URL::to('/') }}" target="_blank">View Homepage</a></li>
					--}}
					<li class="divider-vertical"></li>
					<li><a href="{{ route('logout') }}">ログアウト</a></li>
				</ul>
			</div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>
	<!-- Navigation End -->

		<!-- Notifications -->
		@include('frontend/notifications')

		<!-- Content -->
	{{--
		@yield('content')
	--}}
	</div>
</body>
