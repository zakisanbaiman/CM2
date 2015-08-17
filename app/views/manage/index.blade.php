
<h1></h1>
@extends('layout')
@section('content')
<body ng-controller="ManageController">
	<main>
		<section class="container">
			<ul>
				<li class="box" ng-repeat="manage in manages">
					<p><img src="" alt="" class="box-img"></p>
					<p class="box-p"><span>型番:</span>@{{ manage.model_name }}</p>
					<p class="box-p"><span>メーカー:</span>@{{ manage.maker }}</p>
					<p class="box-p"><span>サイズ:</span>@{{ manage.size }}</p>
					<p class="box-p"><span>色:</span>@{{ manage.color }}</p>
					<p class="box-p"><span>購入日:</span>@{{ manage.buy_date }}</p>
					<p class="box-p"><span>その他:</span>@{{ manage.etc }}</p>
					<p class="box-p">
						<a class="btn btn-default" ng-click="openUpdateManageDialog(manage.id)">更新</a>
						<a class="btn btn-default" ng-click="openDeleteManageDialog(manage.id)">削除</a>
					</p>
				</li>
			</ul>
		</section>
		<div>
		</div>
	</main>

	<!-- 更新ダイアログ -->
	<div ng-controller="UpdateManageModalController">
		<script type="text/ng-template" id="updateManageModal.html">
			<div class="manageModalBox">
				<li><span>型番:</span><input type="text" ng-model="manage.model_name"></li>
				<li><span>メーカー:</span><input type="text" ng-model="manage.maker"></li>
				<li><span>サイズ:</span><input type="text" ng-model="manage.size"></li>
				<li><span>色:</span><input type="text" ng-model="manage.color"></li>
				<li><span>購入日:</span><input type="text" ng-model="manage.buy_date"></li>
				<li><span>その他:</span><input type="text" ng-model="manage.etc"></li>
				<li><a class="btn btn-default">画像アップロード</a></li>
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
<script>
//	$.datepicker.setDefaults($.datepicker.regional['ja']);
//	$('#buy_date').datepicker();
//    angular.module('myApp', ['ngAnimate', 'ui.bootstrap']);
	angular.module('myApp', ['ui.bootstrap'])
		.config(function() {
			//...
		});

//	angular.module('myApp', [])
//		.controller('ManageController', ['$scope','$http',
//				function($scope,$http,$modal) {
	angular.module('myApp').
			controller('ManageController',
			['$scope','$modal','$http', function($scope,$modal,$http) {

			getManageObj = function() {
				$http({
					method : 'get',
					url : '/manage/getManageObj',
				}).success(function(data, status, headers, config) {
					$scope.manages = data;
				}).error(function(data, status, headers, config) {
				});
			}

			getManageObj();

			$scope.updateManageObj = function($index) {
				$http({
					method : 'post',
					url : '/manage/updateManageObj',
					params : $scope.manages[$index]
				}).success(function(data, status, headers, config) {
				}).error(function(data, status, headers, config) {
				});
			}

			$scope.deleteManageObj = function($index) {
				$http({
					method : 'post',
					url : '/manage/deleteManageObj',
					params : $scope.manages[$index]
				}).success(function(data, status, headers, config) {
					getManageObj();
				}).error(function(data, status, headers, config) {
				});
			}

			$scope.insertManageObj = function() {
				$http({
					method: 'post',
					url: '/manage/insertManageObj',
				}).success(function (data, status, headers, config) {
					getManageObj();
				}).error(function (data, status, headers, config) {
				});
			}

			$scope.animationsEnabled = true;

			// dialog更新
			$scope.openUpdateManageDialog = function (manage_id) {
				var dataObj = {};
				dataObj.id = manage_id;
				$http({
					method : 'get',
					url : '/manage/getManageOneObj',
					params : dataObj
				}).success(function(data, status, headers, config) {
					var modalInstance = $modal.open({
						animation: $scope.animationsEnabled,
						templateUrl: 'updateManageModal.html',
						controller: 'UpdateManageModalController',
//					size: size,
						resolve: {
							manage: function () {
//								return $scope.manages;
								return data[0];
							}
						}
					});
				}).error(function(data, status, headers, config) {
				});
			};

			$scope.openDeleteManageDialog = function (manage_id) {
				var dataObj = {};
				dataObj.id = manage_id;
//				$http({
//					method : 'get',
//					url : '/manage/getManageOneObj',
//					params : dataObj
//				}).success(function(data, status, headers, config) {
					var modalInstance = $modal.open({
						animation: $scope.animationsEnabled,
						templateUrl: 'deleteManageModal.html',
						controller: 'DeleteManageModalController',
//					size: size,
						resolve: {
							manage: function () {
//								return $scope.manages;
								return dataObj;
							}
						}
					});
//				}).error(function(data, status, headers, config) {
//				});
			}

		}]);

		angular.module('myApp').
			controller('UpdateManageModalController', function ($scope, $modalInstance, $http, manage) {
			$scope.manage = manage;

			$scope.updateManageModalOk = function () {
				$http({
					method : 'post',
					url : '/manage/updateManageObj',
					params : $scope.manage
				}).success(function(data, status, headers, config) {
					getManageObj();
				});
				$modalInstance.close();
			};

			$scope.updateManageModalCancel = function () {
				$modalInstance.dismiss('cancel');
			};
		});

		angular.module('myApp').
				controller('DeleteManageModalController', function ($scope, $modalInstance, $http, manage) {

			$scope.manage = manage;

			$scope.deleteManageModalOk = function () {
				$http({
					method : 'post',
					url : '/manage/deleteManageObj',
					params : $scope.manage
				}).success(function(data, status, headers, config) {
					getManageObj();
				});
				$modalInstance.close();
			};

			$scope.deleteManageModalCancel = function () {
				$modalInstance.dismiss('cancel');
			};
		});

</script>
@stop