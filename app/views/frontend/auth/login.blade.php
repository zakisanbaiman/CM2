@extends('layout')

{{-- Page title --}}
@section('title')
Account Log in ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div id="login-wrap">
	<h1>ログイン</h1>

	<form method="post" action="{{ route('login') }}" class="form-group login-form">
		<!-- CSRF Token -->
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />

		<!-- Email -->
		<div class="control-group{{ $errors->first('email', ' error') }}">
			<label>メールアドレス</label>
			<input type="email" name="email" id="email" value="{{ Input::old('email') }}" class="form-control form-input" />
			{{ $errors->first('email', '<span class="help-block">:message</span>') }}
		</div>

		<!-- Password -->
		<div class="control-group{{ $errors->first('password', ' error') }}">
			<label>パスワード</label>
			<input type="password" name="password" id="password" value="" class="form-control form-input" />
			{{ $errors->first('password', '<span class="help-block">:message</span>') }}
		</div>

		<!-- Remember me -->
		<div class="control-group">
			<label class="checkbox">
				<input type="checkbox" name="remember-me" id="remember-me" value="1" /> リメンバー
			</label>
		</div>

		<!-- Form actions -->
		<div class="control-group">
			<div class="controls">
				<button type="submit" class="btn btn-default">ログイン</button>
				<a href="/home" class="btn btn-default" data-ajax="false">キャンセル</a>
				<a href="{{ route('forgot-password') }}" class="btn btn-link">パスワードをお忘れですか？</a>
			</div>
		</div>
	</form>

	{{-- OAuthでログイン --}}
	<p class="text-center">
		<a class="btn btn-lg btn-primary" href="{{url('login/fb')}}">
			<i class="icon-facebook"></i>Facebookでログイン</a>
		<br><br>
		<a class="btn btn-lg btn-danger" href="{{url('login/gp')}}">
			<i class="icon-google-plus"></i>Googleでログイン</a>
		<br><br>
		<a class="btn btn-lg btn-success" href="{{url('login/tw')}}">
			<i class="icon-twitter"></i>Twitterでログイン</a>
	</p>
</div>
@stop
