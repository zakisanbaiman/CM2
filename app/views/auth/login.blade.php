@extends('layout')
@section('content')
<!doctype html>
<html lang="ja-JP">
<head>
    <meta charset="UTF-8">
    <title>ログイン</title>
</head>
<body>
<div id="login-wrap">
    <h1>ログイン</h1>
        <form action="<?= URL::route('login'); ?>" method="post" class="form-group login-form">
            {{$errors->has('all') ? $errors->first('all', '<p><span class="label label-danger">:message</span></p>') : ''}}
            <label>メールアドレス</label><input type="email" name="email" class="form-control form-input">
            {{$errors->has('email') ? $errors->first('email', '<p><span class="label label-danger">:message</span></p>') : ''}}
            <label>パスワード</label><input type="password" name="password" class="form-control form-input">
            {{$errors->has('password') ? $errors->first('password','<p><span class="label label-danger">:message</span></p>') : ''}}
            <input type="submit" class="btn btn-default" value="ログイン" data-ajax="false">
            <a href="/user/signup" class="btn btn-default" data-ajax="false">会員登録</a>
        </form>
</div>
</body>
</html>
@stop