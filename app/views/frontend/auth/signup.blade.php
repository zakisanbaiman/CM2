@extends('frontend/layouts/default')

{{-- Page title --}}
@section('title')
会員登録です ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div id="login-wrap">
    <h1>会員登録</h1>

    <form method="post" action="{{ route('signup') }}" class="form-group login-form">

        <!-- CSRF Token -->
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

{{--
        {{$errors->has('all') ? $errors->first('all', '<p><span class="label label-danger">:message</span></p>') : ''}}
--}}
        <!-- Email -->
        <label>メールアドレス</label><input type="email" name="email" value="" class="form-control form-input">
        {{$errors->has('email') ? $errors->first('email', '<p><span class="label label-danger">:message</span></p>') : ''}}

        <!-- Email Confirm -->
        <label>メールアドレス確認</label><input type="email" name="email_confirm" value="" class="form-control form-input">
        {{$errors->has('email_confirm') ? $errors->first('email', '<p><span class="label label-danger">:message</span></p>') : ''}}

        <!-- Password -->
        <label>パスワード</label><input type="password" name="password" value="" class="form-control form-input">
        {{$errors->has('password') ? $errors->first('password','<p><span class="label label-danger">:message</span></p>') : ''}}

        <!-- Password Confirm -->
        <label>パスワード確認</label><input type="password" name="password_confirm" value="" class="form-control form-input">
        {{$errors->has('password_confirm') ? $errors->first('password','<p><span class="label label-danger">:message</span></p>') : ''}}


        <!-- Form actions -->
        <input type="submit" value="登録" class="btn btn-default" data-ajax="false" />
        <a href="/home" class="btn btn-default" data-ajax="false">キャンセル</a>
    </form>

        {{-- OAuthで新規会員登録 --}}
        <p class="text-center">
            <a class="btn btn-lg btn-primary" href="{{url('register/fb')}}">
                <i class="icon-facebook"></i>Facebookで会員登録</a>
            <br><br>
            <a class="btn btn-lg btn-danger" href="{{url('register/gp')}}">
                <i class="icon-google-plus"></i>Googleで会員登録</a>
            <br><br>
            <a class="btn btn-lg btn-success" href="{{url('register/tw')}}">
                <i class="icon-twitter"></i>Twitterで会員登録</a>
        </p>

</div>
</body>
</html>
@stop