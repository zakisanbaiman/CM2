@extends('frontend/layouts/account')

{{-- Page title --}}
@section('title')
Change your Email
@stop

{{-- Account page content --}}
@section('account-content')
<h3>メールアドレス変更</h3>

<form method="post" action="" role="form" autocomplete="off">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />

	<!-- Form type -->
	<input type="hidden" name="formType" value="change-email" />

	<!-- New Email -->
	<div class="form-group{{ $errors->first('email', ' error') }}">
		<label for="email">新しいメールアドレス</label>
		<input type="text" name="email" id="email" value="" class="form-control" />
		{{ $errors->first('email', '<span class="help-block">:message</span>') }}
	</div>

	<!-- Confirm New Email -->
	<div class="form-group{{ $errors->first('email_confirm', ' error') }}">
		<label for="email_confirm">新しいメールアドレスの確認</label>
		<input type="text" name="email_confirm" id="email_confirm" value="" class="form-control" />
		{{ $errors->first('email_confirm', '<span class="help-block">:message</span>') }}
	</div>

	<!-- Current Password -->
	<div class="form-group{{ $errors->first('current_password', ' error') }}">
		<label for="current_password">現在のパスワード</label>
		<input type="password" name="current_password" id="current_password" value="" class="form-control" />
		{{ $errors->first('current_password', '<span class="help-block">:message</span>') }}
	</div>

	<!-- Form actions -->
	<div class="form-group">
		<button type="submit" class="btn btn-primary">メールアドレス変更</button>
		<a href="{{ route('forgot-password') }}" class="btn btn-link">パスワードをお忘れですか？</a>
	</div>
</form>
@stop
