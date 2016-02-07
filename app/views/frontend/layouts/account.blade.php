@extends('frontend/layouts/default')

{{-- Page content --}}
@section('content')
<div class="row">
	<div class="col-lg-3">
		<ul class="nav">
			<li><h3>アカウント管理</h3></li>

			<li{{ Request::is('account/profile') ? ' class="active"' : '' }}>
				<a href="{{ URL::route('profile') }}">プロフィール</a>
			</li>

			<li{{ Request::is('account/change-password') ? ' class="active"' : '' }}>
				<a href="{{ URL::route('change-password') }}">パスワード</a>
			</li>

			<li{{ Request::is('account/change-email') ? ' class="active"' : '' }}>
				<a href="{{ URL::route('change-email') }}">メールアドレス</a>
			</li>
		</ul>
	</div>
	<div class="col-lg-9">
		@yield('account-content')
	</div>
</div>
@stop
