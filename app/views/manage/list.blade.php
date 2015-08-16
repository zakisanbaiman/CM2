
<h1></h1>
@extends('layout')
@section('content')
	<body ng-controller="ManageController">
	<main>
		<section class="container">
			<table class="table table-bordered">
				<thead>
				<th class="info">型番</th>
				<th class="info">メーカー</th>
				<th class="info">サイズ</th>
				<th class="info">色</th>
				<th class="info">購入日</th>
				<th class="info">備考</th>
				<th class="info">画像</th>
				<th class="info">更新</th>
				<th class="info">削除</th>
				</thead>
				<tbody>
				<tr class="active" ng-repeat="manage in manages">
					{{--<span>{{manage.model_name}}</span>--}}
					<td><input type="text" class="form-control" ng-model="manage.model_name"></td>
					<td><input type="text" class="form-control" ng-model="manage.maker"></td>
					<td><input type="text" class="form-control" ng-model="manage.size"></td>
					<td><input type="text" class="form-control" ng-model="manage.color"></td>
					<td><input type="text" class="form-control" ng-model="manage.buy_date" class="buy_date"></td>
					<td><input type="text" class="form-control" ng-model="manage.etc"></td>
					<td>
						{{Form::open(array('url' => '/manage/updateModelImage', 'files' => true, 'id'=>'model_image'))}}
						<input type="file" name="model_image">
						<input type="submit">
						{{Form::close()}}

					</td>
					<td><a class="btn btn-default" ng-click="updateManageObj($index)">更新</a></td>
					<td><a class="btn btn-default" ng-click="deleteManageObj($index)">削除</a></td>
				</tr>
				{{--<input type="text" class="form-control" datepicker-popup="{{format}}" ng-model="fromDate" is-open="fromDateOpened" min-date="minDate" max-date="'2015-06-22'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" ng-required="true" show-weeks="false" close-text="Close" />--}}
				</tbody>
			</table>
			<a class="btn btn-default" ng-click="insertManageObj()">挿入</a>
		</section>
		<div>
		</div>

	</main>
	</body>
	<script>
		//	$.datepicker.setDefaults($.datepicker.regional['ja']);
		//	$('#buy_date').datepicker();

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

//						$http.post('/manage/updateModelImage',fd,
//								{
//									headers:{"Content-type":undefined}
//									,transformRequest: null
//								})
//								.success(function(data) {
//									getManageObj();
//								});

						$http({
							method: 'post',
							url: '/manage/updateModelImage',
							data: fd
						}).success(function (data, status, headers, config) {
							getManageObj();
//							preventDefault();
//							return false;
//						}).error(function (data, status, headers, config) {
						});
					}



				}]);

		//$(function() {
		//	$(".buy_date").datepicker();
		//	$("#buy_date").datepicker();
		//});

	</script>
@stop