@extends('layout')
@section('content')
<!doctype html>
<html lang="ja-JP">
<head>
    <meta charset="UTF-8">
    <title>登録</title>
</head>
<body>

<div id="login-wrap">
    <h1>登録</h1>
    <form action="<?= URL::route('signup'); ?>" method="post" class="form-group login-form">
        {{$errors->has('all') ? $errors->first('all', '<p><span class="label label-danger">:message</span></p>') : ''}}
        <label>メールアドレス</label><input type="email" name="email" value="" class="form-control form-input">
        {{$errors->has('email') ? $errors->first('email', '<p><span class="label label-danger">:message</span></p>') : ''}}
        <label>パスワード</label><input type="password" name="password" value="" class="form-control form-input">
        {{$errors->has('password') ? $errors->first('password','<p><span class="label label-danger">:message</span></p>') : ''}}
        <input type="submit" value="登録" class="btn btn-default" data-ajax="false" /><br><br>
        <a href="/user/login" class="btn btn-default" data-ajax="false">ログイン画面へ</a>
        <a href="/" class="btn btn-default" data-ajax="false">トップページへ戻る</a>
    </form>
</div>
</body>
</html>
@stop