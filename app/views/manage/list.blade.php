
<h1></h1>
@extends('layout')
@section('content')
	<body ng-controller="ManageController">
	<main>
		<section class="container">
			<table class="table table-bordered">
				<thead>
				<th class="info">画像
					<div class="btn-group-vertical">
					<span class="glyphicon glyphicon-triangle-top btn" ng-click="orderChange('desc', 'model_name')"></span>
					<span class="glyphicon glyphicon-triangle-bottom btn"></span>
					</div>
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
					<div class="btn-group-vertical">
						<span class="glyphicon glyphicon-triangle-top btn"></span>
						<span class="glyphicon glyphicon-triangle-bottom btn"></span>
					</div>
				</th>
				<th class="info">削除
					<div class="btn-group-vertical">
						<span class="glyphicon glyphicon-triangle-top btn"></span>
						<span class="glyphicon glyphicon-triangle-bottom btn"></span>
					</div>
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
					<td><a class="btn btn-default" ng-click="updateManageObj($index)">更新</a></td>
					<td><a class="btn btn-default" ng-click="deleteManageObj($index)">削除</a></td>
				</tr>
				</tbody>
			</table>
			<a class="btn btn-default" ng-click="insertManageObj()">挿入</a>
		</section>
		<div>
		</div>

	</main>
	</body>
	<script>

		angular.module('myApp', [])
				.controller('ManageController', ['$scope','$http', function($scope,$http) {

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

					$scope.orderChange = function($order, $val) {
						var obj = {};
						obj.order = $order;
						obj.val = $val;
						$http({
							method : 'get',
							url : '/manage/getManageOrderObj',
							params: obj
						}).success(function(data, status, headers, config) {
							$scope.manages = data;
						}).error(function(data, status, headers, config) {
						});
					}

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

					$scope.updateModelImage = function() {
						$form = $('#model_image');
						fd = new FormData($form[0]);

						$http({
							method: 'post',
							url: '/manage/updateModelImage',
							data: fd
						}).success(function (data, status, headers, config) {
							getManageObj();
						});
					}

				}]);

	</script>
@stop