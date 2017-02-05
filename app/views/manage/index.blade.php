<h1></h1>
@extends('frontend/layouts/default')
@section('content')
<body ng-controller="ManageController">
    <main>
        <section class="container">
            <ul>
                <li class="box" ng-repeat="manage in manages | filter : search | limitTo: paging.num: paging.begin: paging.currentPage">
                    <p><img src="/upload/@{{ manage.model_image }}" alt="" class="box-img"></p>
                    <p class="box-p"><span class="box-label">型番</span>@{{ manage.model_name }}</p>
                    <p class="box-p"><span class="box-label">メーカー</span>@{{ manage.maker }}</p>
                    <p class="box-p"><span class="box-label">サイズ</span>@{{ manage.size }}</p>
                    <p class="box-p"><span class="box-label">色</span>@{{ manage.color }}</p>
                    <p class="box-p"><span class="box-label">購入日</span>@{{ manage.buy_date }}</p>
                    <p class="box-p"><span class="box-label">その他</span>@{{ manage.etc }}</p>
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

		<center>
	      <ul class="pagination">
            <li>
		      <a href="#" ng-click="prevPage()">≪ 前へ</a>
		    </li>
		    <li ng-repeat="n in range()" ng-class="{active: n == paging.currentPage}" ng-click="setPage(n)">
		      <a href="#">@{{n}}</a>
		    </li>
		    <li>
		      <a href="#" ng-click="nextPage()">次へ ≫</a>
		    </li>
		  </ul>
		</center>
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
<script>

    angular.module('myApp', ['ui.bootstrap','ngFileUpload'])
        .config(function() {
            //...
        });

    angular.module('myApp').
            controller('ManageController',
            ['$scope','$modal','$http','$timeout', function($scope,$modal,$http,$timeout) {

            $scope.paging = {
                                 num: 5,
                                 begin: 0,
                                 currentPage: 1
                            }

            getManageObj = function() {
                $http({
                    method : 'get',
                    url : '/manage/getManageObj',
                }).success(function(data, status, headers, config) {
                    $scope.manages = data;

                }).error(function(data, status, headers, config) {
                });

            }

            $scope.setPage = function(page){
                $scope.paging.begin = $scope.paging.num * page - $scope.paging.num;
                $scope.paging.currentPage = page;
            };

        	$scope.prevPage = function() {
        		if ($scope.paging.begin > 0) {
            		$scope.paging.begin = $scope.paging.begin - $scope.paging.num;
            		$scope.paging.currentPage --;
        		}
            };

      		$scope.nextPage = function() {
      			if ($scope.paging.begin < $scope.manages.length - 1) {
            		$scope.paging.begin = $scope.paging.begin + $scope.paging.num;
            		$scope.paging.currentPage ++;
        		}
          	};

          	$scope.range = function() {
                $scope.limitTo = Math.ceil($scope.manages.length/$scope.paging.num);
                var ret = [];
                for (var i=1; i<=$scope.limitTo; i++) {
                ret.push(i)
                };
                return ret;
            };

            getManageObj();

            $scope.openManageDetail = function($index) {
                var $url = "/manage/detail?id=" + $index;
                location.href=$url;
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
                        resolve: {
                            manage: function () {
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
                    var modalInstance = $modal.open({
                        animation: $scope.animationsEnabled,
                        templateUrl: 'deleteManageModal.html',
                        controller: 'DeleteManageModalController',
                        resolve: {
                            manage: function () {
                                return dataObj;
                            }
                        }
                    });
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

            // image upload
            $scope.uploadModelImage = function(id) {

                var fd = new FormData($('#upload-form').get(0));
                fd.append('id', id);

                $http.post('/manage/updateModelImage',fd,{
                        headers:{"Content-type":undefined}
                        ,transformRequest: null
                    })
                    .success(function(res){
                        getManageObj();
                    });

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
