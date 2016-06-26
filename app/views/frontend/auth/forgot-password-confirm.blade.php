@extends('frontend/layouts/default')

{{-- Page title --}}
@section('title')
パスワード変更 ::
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="page-header">
	<h3>パスワードの更新</h3>
</div>
<form method="post" action="" class="form-horizontal">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />

	<!-- New Password -->
	<div class="control-group{{ $errors->first('password', ' error') }}">
		<label class="control-label" for="password">新しいパスワード</label>
		<div class="controls">
			<input type="password" name="password" id="password" value="{{ Input::old('password') }}" />
			{{ $errors->first('password', '<span class="help-block">:message</span>') }}
		</div>
	</div>

	<!-- Password Confirm -->
	<div class="control-group{{ $errors->first('password_confirm', ' error') }}">
		<label class="control-label" for="password_confirm">新しいパスワードの確認</label>
		<div class="controls">
			<input type="password" name="password_confirm" id="password_confirm" value="{{ Input::old('password_confirm') }}" />
			{{ $errors->first('password_confirm', '<span class="help-block">:message</span>') }}
		</div>
	</div>

	<!-- Form actions -->
	<div class="control-group">
		<div class="controls">
			<a class="btn" href="{{ route('home') }}">キャンセル</a>

			<button type="submit" class="btn btn-info">送信</button>
		</div>
	</div>
</form>
@stop
