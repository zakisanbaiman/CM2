<h1></h1>
@extends('frontend/layouts/default') @section('content')
<body>
	<main>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">Menu</div>
			<ul class="nav nav-pills nav-stacked">
				<li><a href="/timeline/"><i class="glyphicon glyphicon-list-alt"></i>
						タイムライン</a></li>
				<li class="active"><a><i class="glyphicon glyphicon-user"></i>
						フレンド検索</a></li>
				<li><a href=""><i class="glyphicon glyphicon-question-sign"></i> ヘルプ</a></li>
			</ul>
		</div>
	</div>

	<!-- 検索フォーム -->
	<form id="submit-form" method="post" class="input-group"
		style="width: 50%; height: 34px;">
		<input id="submit_text" type="text" class="form-control"
			placeholder='フレンドを検索'> <span class="input-group-btn">
			<button class="btn btn-default" type="submit" style="height: 34px;">
				<i class='glyphicon glyphicon-search'></i>
			</button>
		</span>
	</form>

	<div style="float: left;" ng-controller="ArticleController">
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th class="span1">アイコン</th>
					<th class="span2">ニックネーム</th>
					<th class="span3">名前</th>
					<th class="span4">ステータス</th>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat="friend in friends">
					<td><img src="/images/users/@{{ friend.user_image }}"
						style="width: 50px; height: 50px;"></td>
					<td>@{{ friend.nickname }}</td>
					<td>@{{ friend.first_name }} @{{ friend.last_name }}</td>
					<!--     				<td>@{{ friend.approval_1 }}</td> -->
					<!--     				<td>@{{ friend.approval_2 }}</td> -->
					<td ng-if="friend.approval_1 == '1' && friend.approval_2 == '1'">
						<button type="button" class="btn btn-success">
							<i class="glyphicon glyphicon-ok"></i> フレンド
						</button>
						<button id="button" type="button" class="btn btn-default"
							ng-click="cancelFriend(friend.id)">削除</button>
					</td>
					<td ng-if="friend.approval_1 == '1' && friend.approval_2 != '1'">
						<button type="button" class="btn btn-default"
							ng-click="cancelRequest(friend.id)">
							<i class="glyphicon glyphicon-remove"></i> リクエストを取消
						</button>
					</td>
					<td ng-if="friend.approval_1 != '1' && friend.approval_2 == '1'">
						<button type="button" class="btn btn-primary"
							ng-click="approvalRequest(friend.id)">
							<i class="glyphicon glyphicon-plus"></i> リクエストを承認
						</button>
					</td>
					<td ng-if="friend.approval_1 != '1' && friend.approval_2 != '1'">
						<button type="button" class="btn btn-primary"
							ng-click="request(friend.id)">
							<i class="glyphicon glyphicon-plus"></i> フレンド申請
						</button>
					</td>
			
			</tbody>
		</table>
	</div>
	</main>
</body>

<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
<script
	src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>

<script>
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
            	alert("NG");
            });
        }
        getFriendObj();

        // 検索処理
        submit_text = '';
        getSearchFriendObj = function() {
            // Ajax処理
            $.ajax({
              url: '/friend/getSearchFriendObj',
              type:'POST',
              data : {
                  submit_text : submit_text
                  },
              success: function(data) {
                      $scope.friends = data;
                      $scope.$apply();
			  },
              error: function(XMLHttpRequest, textStatus, errorThrown) {
              }
            });
        }

     	// friendテーブルに追加
     	addFriend = function(friend_id) {
            $.ajax({
              url: '/friend/setFriendRequestObj',
              type:'POST',
              data : {
            	  friend_id : friend_id
                  },
              success: function(data) {
            	  getSearchFriendObj();
    		  },
              error: function(XMLHttpRequest, textStatus, errorThrown) {
              }
        	});
     	}

     	// friendsテーブルから削除
     	deleteFriend = function(friend_id) {
            $.ajax({
              url: '/friend/cancelRequest',
              type:'POST',
              data : {
            	  friend_id : friend_id
                  },
              success: function(data) {
            	  getSearchFriendObj();
    		  },
              error: function(XMLHttpRequest, textStatus, errorThrown) {
              }
        	});
     	}

		// 検索ボタン押下時
        $('#submit-form').submit(function(event) {
            // ここでsubmitをキャンセルします。
            event.preventDefault();

            submit_text = $('#submit_text').val();

            getSearchFriendObj();
        });
        
        // 「フレンド申請」押下時
        $scope.request = function(friend_id){
        	addFriend(friend_id);
        };

        // 「リクエストを取消」押下時
        $scope.cancelRequest = function(friend_id){
        	deleteFriend(friend_id);
        };

        // 「リクエストを承認」押下時
        $scope.approvalRequest = function(friend_id){
        	addFriend(friend_id);
        };

        // 「フレンドを解消」押下時
        $scope.cancelFriend = function(friend_id){
        	deleteFriend(friend_id);
        };
	}]);

</script>

@stop


