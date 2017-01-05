/**
 * 
 */
angular.module('myApp', ['ui.bootstrap','ngFileUpload'])
        .config(function() {
            //...
	    });

    angular.module('myApp')
    	.controller('ArticleController',
    	['$scope','$modal','$http','$timeout', function($scope,$modal,$http,$timeout) {

	    // 初期表示分のフレンドを取得
        $scope.friends = [];
        getFriendObj = function() {
        	var dataObj = {};
            dataObj.user_id = '12';
        	$http({
               	method : 'post',
               	url : '/friend/getFriendObj',
               	params : dataObj
            }).success(function(data, status, headers, config) {
                $scope.friends = data;
            }).error(function(data, status, headers, config) {
            });
        }
        getFriendObj();

		// 検索ボタン押下時
        $('#submit-form').submit(function(event) {
            // ここでsubmitをキャンセルします。
            event.preventDefault();

            var submit_text = $('#submit_text').val();

            // Ajax処理
            $.ajax({
              url: '/friend/getSearchFriendObj',
              type:'POST',
              data : {
                  submit_text : submit_text
                  },
              success: function(data) {
                      document.getElementById("submit_text").value="";
                      $scope.friends = data;
                      $scope.$apply();
			  },
              error: function(XMLHttpRequest, textStatus, errorThrown) {
              }
            });
        });
        
	}]);
