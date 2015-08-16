
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
					<a class="btn btn-default" ng-click="openUpdateManageDialog(manage.id)">更新</a>
				</li>
			</ul>
		</section>
		<div>
		</div>
	</main>
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


			var getManageObj = function() {
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
			$scope.openUpdateManageDialog = function (size) {

				var modalInstance = $modal.open({
					animation: $scope.animationsEnabled,
					templateUrl: 'manageModal.html',
					controller: 'ManageModalController',
					size: size,
					resolve: {
//						items: function () {
//							return $scope.items;
//						}
					}
				});

				modalInstance.result.then(function (selectedItem) {
					$scope.selected = selectedItem;
				}, function () {
//					$log.info('Modal dismissed at: ' + new Date());
				});
			};

		}]);

		angular.module('myApp').controller('ManageModalController', function ($scope, $modalInstance, items) {

			$scope.items = items;
			$scope.selected = {
				item: $scope.items[0]
			};

			$scope.ok = function () {
				$modalInstance.close($scope.selected.item);
			};

			$scope.cancel = function () {
				$modalInstance.dismiss('cancel');
			};
		});

//$(function() {
//	$(".buy_date").datepicker();
//	$("#buy_date").datepicker();
//});

</script>
@stop