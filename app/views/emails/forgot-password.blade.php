@extends('emails/layouts/default')

@section('content')
<p>こんにちは {{ $user->email }},</p>

<p>Please click on the following link to updated your password:</p>

<p>以下のリンクをクリックしてパスワードを更新してください。:</p>

<p><a href="{{ $forgotPasswordUrl }}">{{ $forgotPasswordUrl }}</a></p>

<p>Best regards,</p>

<p>View PJ. Team</p>
@stop
