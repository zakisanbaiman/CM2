
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
					<th class="info">更新</th>
				</thead>
				<tbody>
					<tr ng-repeat="manage in manages">
						<td><input type="text" ng-model="manage.model_name"></td>
						<td><input type="text" ng-model="manage.maker"></td>
						<td><input type="text" ng-model="manage.size"></td>
						<td><input type="text" ng-model="manage.color"></td>
						<td><input type="text" ng-model="manage.buy_date"></td>
						<td><input type="text" ng-model="manage.etc"></td>
						<td><button class="btn btn-default" ng-click="updateManageObj($index)">更新</button></td>
					</tr>
				</tbody>
			</table>
		</section>
	</main>
</body>
<script>
	angular.module('myApp', [])
		.controller('ManageController', ['$scope','$http', function($scope,$http) {
			$http({
				method : 'get',
				url : '/manage/getManageObj',
			}).success(function(data, status, headers, config) {
				$scope.manages = data;
			}).error(function(data, status, headers, config) {
			});

			$scope.updateManageObj = function($index) {
				$http({
					method : 'post',
					url : '/manage/updateManageObj',
					params : $scope.manages[$index]
				}).success(function(data, status, headers, config) {
				}).error(function(data, status, headers, config) {
				});
			}

		}]);

</script>
@stop