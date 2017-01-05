<h1></h1>
@extends('frontend/layouts/header')
@section('content')
<body>
	<main>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">Menu</div>
			<ul class="nav nav-pills nav-stacked">
				<li><a href="/timeline/"><i class="glyphicon glyphicon-pencil"></i>タイムライン</a></li>
				<li class="active"><a href="/searchfriends/"><i
						class="glyphicon glyphicon-user"></i> フレンド検索</a></li>
				<li><a href=""><i class="glyphicon glyphicon-question-sign"></i> ヘルプ</a></li>
			</ul>
		</div>
	</div>
    
    <!-- 検索フォーム -->
	<form id="submit-form" method="post" class="input-group" style="width:50%; height:34px;">
		<input id="submit_text" type="text" class="form-control">
		<span class="input-group-btn">
			<button class="btn btn-default" type="submit" style="height:34px;">
				<i class='glyphicon glyphicon-search'></i>
			</button>
		</span>
	</form>

	<div style="float: left;" ng-controller="ArticleController">

		<form id="search-form" method="post" onsubmit="return setArticleObj()"
			style="display: inline-flex">
			<input type="text" placeholder='フレンドを検索' />
			<button id="submit" type="submit"
				class="glyphicon glyphicon-open submit-btn"></button>
		</form>
		<table class="table table-bordered table-striped table-hover">
			<tr ng-repeat="friend in friends">
				<td><img src="/images/users/@{{ friend.user_image }}"
					style="width: 50px; height: 50px;"></td>
				<td>@{{ friend.nickname }}</td>
			</tr>
		</table>
	</div>
	</main>
</body>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="/js/search-friends.js"></script>
@stop


