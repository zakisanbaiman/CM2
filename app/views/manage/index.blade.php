
<h1></h1>
@extends('layout')
@section('content')
<body ng-controller="ManageController">
	<main>
		<section class="container">
			<ul>
				<li class="box" ng-repeat="manage in manages | filter : search | limitTo: num: begin">
					<p><img src="/upload/@{{ manage.model_image }}" alt="" class="box-img"></p>
					<p class="box-p">@{{ manage.model_name }}</p>
					<p class="box-p">@{{ manage.etc }}</p>
					<p class="box-p">
						<a class="btn btn-default" ng-click="openManageDetail(manage.id)">詳細</a>
						<a class="btn btn-default" ng-click="openUpdateManageDialog(manage.id)">更新</a>
						<a class="btn btn-default" ng-click="openDeleteManageDialog(manage.id)">削除</a>
					</p>
				</li>
			</ul>
			<a class="btn btn-default" ng-click="insertManageObj()">挿入</a>
		</section>
		<div>
		</div>

		<input type="button" value="1" ng-click="onpaging(0)">
		<input type="button" value="2" ng-click="onpaging(1)">
		<input type="button" value="3" ng-click="onpaging(2)">
		<input type="button" value="4" ng-click="onpaging(3)">

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
<script src="/js/angular/manage/manage_controller.js"></script>
@stop