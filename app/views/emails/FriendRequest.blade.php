@extends('emails/layouts/default')

@section('content')

<p>{{ $userFrom[0]->nickname }}さんからフレンドリクエストが届いています。</p>

<p><a href="{{ $urlSearchFriends }}">{{ $urlSearchFriends }}</a></p>

<p>このメールに心当たりがない場合は破棄してください。</p>

<p>View PJ. チーム</p>
@stop
