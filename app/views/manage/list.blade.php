
<h1></h1>
@extends('layout')
@section('content')
	<body ng-controller="ManageController">
	<main>
		<section class="container">
			<table class="table table-bordered">
				<thead>
				<th class="info">画像
				</th>
				<th class="info">型番
					<div class="btn-group-vertical aa">
						<span class="glyphicon glyphicon-triangle-top btn"></span>
						<span class="glyphicon glyphicon-triangle-bottom btn"></span>
					</div>
				</th>
				<th class="info">メーカー
					<div class="btn-group-vertical">
						<span class="glyphicon glyphicon-triangle-top btn"></span>
						<span class="glyphicon glyphicon-triangle-bottom btn"></span>
					</div>
				</th>
				<th class="info">サイズ
					<div class="btn-group-vertical">
						<span class="glyphicon glyphicon-triangle-top btn"></span>
						<span class="glyphicon glyphicon-triangle-bottom btn"></span>
					</div>
				</th>
				<th class="info">色
					<div class="btn-group-vertical">
						<span class="glyphicon glyphicon-triangle-top btn"></span>
						<span class="glyphicon glyphicon-triangle-bottom btn"></span>
					</div>
				</th>
				<th class="info">購入日
					<div class="btn-group-vertical">
						<span class="glyphicon glyphicon-triangle-top btn"></span>
						<span class="glyphicon glyphicon-triangle-bottom btn"></span>
					</div>
				</th>
				<th class="info">備考
					<div class="btn-group-vertical">
						<span class="glyphicon glyphicon-triangle-top btn"></span>
						<span class="glyphicon glyphicon-triangle-bottom btn"></span>
					</div>
				</th>
				<th class="info">更新
				</th>
				<th class="info">削除
				</th>
				</thead>
				<tbody>
				<tr class="active" ng-repeat="manage in manages | filter : search">
					<td><img src="/upload/@{{ manage.model_image }}" alt="" class="box-list-img" width="193" height="130"></td>
					<td>@{{ manage.model_name }}</td>
					<td>@{{ manage.maker }}</td>
					<td>@{{ manage.size }}</td>
					<td>@{{ manage.color }}</td>
					<td>@{{ manage.buy_date }}</td>
					<td>@{{ manage.etc }}</td>
					<td><a class="btn btn-default" ng-click="openUpdateManageDialog(manage.id)">更新</a></td>
					<td><a class="btn btn-default" ng-click="openDeleteManageDialog(manage.id)">削除</a></td>
				</tr>
				</tbody>
			</table>
			<a class="btn btn-default" ng-click="insertManageObj()">挿入</a>
		</section>
		<div>
		</div>

	</main>

	<!-- 更新ダイアログ -->
	<div ng-controller="UpdateManageModalController">
		<script type="text/ng-template" id="updateManageModal.html">
			<div class="manageModalBox">
				<li><span class="box-label">型番</span><input type="text" ng-model="manage.model_name"></li>
				<li><span class="box-label">メーカー</span><input type="text" ng-model="manage.maker"></li>
				<li><span class="box-label">サイズ</span><input type="text" ng-model="manage.size"></li>
				<li><span class="box-label">色</span><input type="text" ng-model="manage.color"></li>
				<li><span class="box-label">購入日</span><input type="text" ng-model="manage.buy_date"></li>
				<li><span class="box-label">その他</span><textarea cols="60" rows="25" ng-model="manage.etc"></textarea></li>

				<form id="upload-form" ng-submit="uploadModelImage(manage.id)" method="post" enctype="multipart/form-data">
					{{Form::file('modelImage')}}
					<input type="submit" id="update" value="送信" />
					{{Form::close()}}

					<div class="manageModalBoxFooter">
						<a class="btn btn-default" ng-click="updateManageModalOk()">Ok</a>
						<a class="btn btn-default" ng-click="updateManageModalCancel()">Cancel</a>
					</div>
			</div>
		</script>
	</div>

	<!-- 削除ダイアログ -->
	<div ng-controller="DeleteManageModalController">
		<script type="text/ng-template" id="deleteManageModal.html">
			<div class="manageModalBox">
				<p>本当に削除しますか？</p>
				<div class="manageModalBoxFooter">
					<a class="btn btn-default" ng-click="deleteManageModalOk()">Ok</a>
					<a class="btn btn-default" ng-click="deleteManageModalCancel()">Cancel</a>
				</div>
			</div>
		</script>
	</div>

	</body>
	<script src="/js/angular/manage/manage.js"></script>
	<script src="/js/angular/manage/manage_list_controller.js"></script>
@stop