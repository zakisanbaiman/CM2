@extends('emails/layouts/default')

@section('content')
<p>Hello {{ $user->email }},</p>

<p>Welcome to SiteNameHere! Please click on the following link to confirm your SiteNameHere account:</p>
<p>ようこそ 構成管理アプリケーションへ！。以下のリンクをクリックしてユーザ登録を完了してください。:</p>

<p><a href="{{ $activationUrl }}">{{ $activationUrl }}</a></p>

<p>このメールに心当たりがない場合は破棄してください。</p>

<p>View PJ. チーム</p>
@stop
