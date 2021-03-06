app.controller('ManageController',
    ['$scope','$modal','$http','$timeout',
        function($scope,$modal,$http,$timeout) {

        $scope.num = 3;
        $scope.begin = 0;

        getManageObj = function() {
            $http({
                method : 'get',
                url : '/manage/getManageObj',
            }).success(function(data, status, headers, config) {
                $scope.manages = data;

            }).error(function(data, status, headers, config) {
            });

        }

        $scope.onpaging = function(page){
            $scope.begin = $scope.num * page;

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
//					size: size,
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

app.controller('UpdateManageModalController', function ($scope, $modalInstance, $http, manage) {
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

app.controller('DeleteManageModalController', function ($scope, $modalInstance, $http, manage) {

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

