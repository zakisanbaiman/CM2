app.controller('ManageController',
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

        $scope.openProfileObj = function($index) {
            var $url = "/user/profile?id=" + $index;
            location.href=$url;
        }

        getManageDetailObj = function() {
            var url = getURL();
            $http({
                method : 'get',
                url : '/manage/getManageDetailObj',
                params : url
            }).success(function(data, status, headers, config) {
                $scope.manage = data[0];
            }).error(function(data, status, headers, config) {
            });
        }

        getManageDetailObj();

        $scope.updateManageObj = function($index) {
            $http({
                method : 'post',
                url : '/manage/updateManageObj',
                params : $scope.manage[$index]
            }).success(function(data, status, headers, config) {
            }).error(function(data, status, headers, config) {
            });
        }

        $scope.deleteManageObj = function($index) {
            $http({
                method : 'post',
                url : '/manage/deleteManageObj',
                params : $scope.manage[$index]
            }).success(function(data, status, headers, config) {
                getManageDetailObj();
            }).error(function(data, status, headers, config) {
            });
        }

        $scope.insertManageObj = function() {
            $http({
                method: 'post',
                url: '/manage/insertManageObj',
            }).success(function (data, status, headers, config) {
                getManageDetailObj();
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
            var modalInstance = $modal.open({
                animation: $scope.animationsEnabled,
                templateUrl: 'deleteManageModal.html',
                controller: 'DeleteManageModalController',
                resolve: {
                    manage: function () {
//								return $scope.manages;
                        return dataObj;
                    }
                }
            });
        }

    }]);

app.controller('UpdateManageModalController', function ($scope, $modalInstance, $http, manage) {
        $scope.manage = manage;

        $scope.updateManageModalOk = function () {
            $http({
                method : 'post',
                url : '/manage/updateManageObj',
                params : $scope.manage
            }).success(function(data, status, headers, config) {
                getManageDetailObj();
            });
            $modalInstance.close();
        };

        $scope.updateManageModalCancel = function () {
            $modalInstance.dismiss('cancel');
        };
    });

app.controller('DeleteManageModalController', function ($scope, $modalInstance, $http, manage) {

        $scope.manage = manage;

        $scope.deleteManageModalOk = function () {
            $http({
                method : 'post',
                url : '/manage/deleteManageObj',
                params : $scope.manage
            }).success(function(data, status, headers, config) {
                getManageDetailObj();
            });
            $modalInstance.close();
        };

        $scope.deleteManageModalCancel = function () {
            $modalInstance.dismiss('cancel');
        };
    });

