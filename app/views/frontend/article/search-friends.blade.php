<h1></h1>
@extends('layout') @section('content')
<body ng-controller="ArticleController">
	<main>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">Menu</div>
			<ul class="nav nav-pills nav-stacked">
				<li><a href="/timeline/"><i class="glyphicon glyphicon-pencil"></i>タイムライン</a></li>
				<li class="active"><a href="/searchfriends/"><i class="glyphicon glyphicon-user"></i> フレンド検索</a></li>
				<li><a href=""><i class="glyphicon glyphicon-question-sign"></i> ヘルプ</a></li>
			</ul>
		</div>
	</div>

	<div style="float:left;">
	<a id="btn_like" class="btn btn-default"
						ng-click="test()">いいね！</a>
   	<table class="table table-bordered table-striped table-hover">
    	<thead>
    		<tr>
    			<th class="span1">アイコン</th>
    			<th class="span2">名前</th>
    		</tr>
    	</thead>
    	<tbody>

    	</tbody>
    </table>
	</div>
	
	</main>
</body>

<script
	src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

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
            });
        }
        getFriendObj();

	}]);
</script>

@stop


