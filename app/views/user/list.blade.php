
<h1></h1>
@extends('layout')
@section('content')
<body ng-controller="UserController">
	<main>
		<section class="container">
			<ul>
				<li class="box" ng-repeat="userList in userLists | filter : search">
					<p><img src="/upload/@{{ userList.profile_image }}" alt="" class="box-img"></p>
					<p class="box-p"><span>ニックネーム:</span>@{{ userList.nickname }}</p>
					<p class="box-p"><span>一言:</span>@{{ userList.etc }}</p>
					<p class="box-p">
						<a class="btn btn-default" ng-click="openUserProfile(userList.id)">詳細</a>
						{{--<a class="btn btn-default" ng-click="openUpdateProfileDialog(userDetail.id)">更新</a>--}}
						{{--<a class="btn btn-default" ng-click="openDeleteProfileDialog(userDetail.id)">削除</a>--}}
					</p>
				</li>
			</ul>
			{{--<a class="btn btn-default" ng-click="insertManageObj()">挿入</a>--}}
		</section>
		<div>
		</div>
	</main>

</body>
<script>


//	$.datepicker.setDefaults($.datepicker.regional['ja']);
//	$('#buy_date').datepicker();
//    angular.module('myApp', ['ngAnimate', 'ui.bootstrap']);
	angular.module('myApp', ['ui.bootstrap','ngFileUpload'])
		.config(function() {
			//...
		});


//	angular.module('myApp', [])
//		.controller('ManageController', ['$scope','$http',
//				function($scope,$http,$modal) {
	angular.module('myApp').
			controller('UserController',
			['$scope','$modal','$http','Upload', '$timeout', function($scope,$modal,$http,Upload, $timeout) {

			getUserListObj = function() {
				$http({
					method : 'get',
					url : '/user/getUserListObj',
				}).success(function(data, status, headers, config) {
					$scope.userLists = data;
				}).error(function(data, status, headers, config) {
				});
			}

			getUserListObj();

			$scope.openUserProfile = function($index) {
				var $url = "/user/profile?id=" + $index;
				location.href=$url;
			}

		}]);


</script>
@stop