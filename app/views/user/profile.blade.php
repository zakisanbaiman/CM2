
<h1></h1>
@extends('layout')
@section('content')
<body ng-controller="UserController">
	<main>
		<section class="container">
			<div class="box-detail">
				<p><img src="/upload/profile/@{{ profile.profile_image }}" alt="" class="box-img"></p>
				<p class="box-p"><span>ニックネーム:</span>@{{ profile.nickname }}</p>
				<p class="box-p"><span>メールアドレス:</span>@{{ profile.mail_adress }}</p>
				<p class="box-p"><span>twitter:</span>@{{ profile.twitter }}</p>
				<p class="box-p"><span>facebook:</span>@{{ profile.facebook }}</p>
				<p class="box-p"><span>住所:</span>@{{ profile.adress }}</p>
				<p class="box-p"><span>電話番号:</span>@{{ profile.tel }}</p>
				<p class="box-p"><span>一言:</span>@{{ profile.etc }}</p>
				<p class="box-p">
					<a class="btn btn-default" ng-click="openUpdateProfileDialog(profile.id)">更新</a>
					{{--<a class="btn btn-default" ng-click="openDeleteProfileDialog(profile.id)">削除</a>--}}
				</p>
			</div>
		</section>
		<div>
		</div>
	</main>

	<!-- 更新ダイアログ -->
	<div ng-controller="UpdateProfileModalController">
		<script type="text/ng-template" id="updateProfileModal.html">
			<div class="manageModalBox">
				<li><span>ニックネーム:</span><input type="text" ng-model="profile.nickname"></li>
				<li><span>メールアドレス:</span><input type="text" ng-model="profile.mail_adress"></li>
				<li><span>twitter:</span><input type="text" ng-model="profile.twitter"></li>
				<li><span>facebook:</span><input type="text" ng-model="profile.facebook"></li>
				<li><span>住所:</span><input type="text" ng-model="profile.adress"></li>
				<li><span>電話番号:</span><input type="text" ng-model="profile.tel"></li>
				<li><span>一言:</span><textarea cols="60" rows="25" ng-model="profile.etc"></textarea></li>

				<div class="manageModalBoxFooter">
					<a class="btn btn-default" ng-click="updateProfileModalOk()">Ok</a>
					<a class="btn btn-default" ng-click="updateProfileModalCancel()">Cancel</a>
				</div>
			</div>
		</script>
	</div>

	<!-- 削除ダイアログ -->
	<div ng-controller="DeleteProfileModalController">
		<script type="text/ng-template" id="deleteProfileModal.html">
			<div class="manageModalBox">
				<p>本当に削除しますか？</p>
				<div class="manageModalBoxFooter">
					<a class="btn btn-default" ng-click="deleteProfileModalOk()">Ok</a>
					<a class="btn btn-default" ng-click="deleteProfileModalCancel()">Cancel</a>
				</div>
			</div>
		</script>
	</div>
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

			getURL = function() {
				var arg = {};
				var pair=location.search.substring(1).split('&');
				for(var i=0;pair[i];i++) {
					var kv = pair[i].split('=');
					arg[kv[0]]=kv[1];
				}
				return arg;
			}

//			$scope.openProfileObj = function($index) {
//				var $url = "/user/profile?id=" + $index;
//				location.href=$url;
//			}

			getProfileObj = function() {
				var url = getURL();
				$http({
					method : 'get',
					url : '/user/getProfileObj',
					params : url
				}).success(function(data, status, headers, config) {
					$scope.profile = data[0];
				}).error(function(data, status, headers, config) {
				});
			}

			getProfileObj();


			$scope.animationsEnabled = true;

			// dialog更新
			$scope.openUpdateProfileDialog = function (id) {
				var dataObj = {};
				dataObj.id = id;
				$http({
					method : 'get',
					url : '/user/getProfileObj',
					params : dataObj
				}).success(function(data, status, headers, config) {
					var modalInstance = $modal.open({
						animation: $scope.animationsEnabled,
						templateUrl: 'updateProfileModal.html',
						controller: 'UpdateProfileModalController',
//					size: size,
						resolve: {
							profile: function () {
								return data[0];
							}
						}
					});
				}).error(function(data, status, headers, config) {
				});
			};

		}]);

		angular.module('myApp').
			controller('UpdateProfileModalController', function ($scope, $modalInstance, $http, profile) {
			$scope.profile = profile;

			$scope.updateProfileModalOk = function () {
				$http({
					method : 'post',
					url : '/user/updateProfileObj',
					params : $scope.profile
				}).success(function(data, status, headers, config) {
					getProfileObj();
				});
				$modalInstance.close();
			};

			$scope.updateProfileModalCancel = function () {
				$modalInstance.dismiss('cancel');
			};
		});


</script>
@stop