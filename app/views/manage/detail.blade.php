
<h1></h1>
@extends('layout')
@section('content')
<body ng-controller="ManageController">
	<main>
		<section class="container">
			<div class="box-detail">
				<p><img src="/upload/@{{ manage.model_image }}" alt="" class="box-img-big"></p>
				<p class="box-p"><span class="box-label">型番</span>@{{ manage.model_name }}</p>
				<p class="box-p"><span class="box-label">メーカー</span>@{{ manage.maker }}</p>
				<p class="box-p"><span class="box-label">サイズ</span>@{{ manage.size }}</p>
				<p class="box-p"><span class="box-label">色</span>@{{ manage.color }}</p>
				<p class="box-p"><span class="box-label">購入日</span>@{{ manage.buy_date }}</p>
				<p class="box-p"><span class="box-label">その他</span>@{{ manage.etc }}</p>
				<p class="box-p">
					<a class="btn btn-default" ng-click="openUpdateManageDialog(manage.id)">更新</a>
					<a class="btn btn-default" ng-click="openDeleteManageDialog(manage.id)">削除</a>
				</p>
				<p><a class="btn btn-default" ng-click="openProfileObj(manage.create_user_id)">プロフィール</a></p>
			</div>
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
				<li><span class="box-label">その他</span><input type="text" ng-model="manage.etc"></li>

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
<script src="/js/angular/manage/manage_detail_controller.js"></script>
@stop