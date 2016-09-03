<h1></h1>
@extends('layout')
@section('content')
<body ng-controller="ArticleController">
    <main>
        <section class="container">
        	<form id="submit-form" method="post" class="submit-box" onsubmit="return setArticleObj()">
				<textarea type="text" class="submit-textbox" id="submit_text" placeholder='今なにしてる？'/></textarea>
				<button id="submit" type="submit" class="btn btn-primary submit-btn">投稿する</button>
        	</form>

			<li id="list" class="timeline-box" ng-repeat="article in articles | filter : search | orderBy: 'created_at': true">
				<p class="box-p">@{{ article.user_id }}</p>
				<p class="article-box">@{{ article.article }}</p>
				<p class="article-box">いいね！@{{ article.like }}人</p>
				<p class="box-p">
				<a class="btn btn-default" ng-click="openArticleDetail(article.id)">いいね！</a>
				<a class="btn btn-default" ng-click="openUpdateArticleDialog(article.id)">コメントする</a>
				<a class="btn btn-default" ng-click="openDeleteArticleDialog(article.id)">シェアする</a>
                </p>
            </li>
            <button id="more" class="btn btn-primary">more</button>
        </section>
    </main>
</body>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<script>
    angular.module('myApp', ['ui.bootstrap','ngFileUpload'])
        .config(function() {
            //...
        });
    angular.module('myApp').
            controller('ArticleController',
            ['$scope','$modal','$http','$timeout', function($scope,$modal,$http,$timeout) {
            getArticleObj = function() {
                $http({
                    method : 'get',
                    url : '/article/getArticleObj',
                }).success(function(data, status, headers, config) {
                    $scope.articles = data;
                }).error(function(data, status, headers, config) {
                });
            }
            getArticleObj();

            $('#submit-form').submit(function(event) {
                // ここでsubmitをキャンセルします。
                event.preventDefault();

                //var submit_text = {string  : $('#submit_text').val()};
                var submit_text = $('#submit_text').val();

                // Ajax処理
                $.ajax({
                  url: '/article/setArticleObj',
                  type:'POST',
                  data : {
                      submit_text : submit_text
                      },
                  success: function(data) {
                          alert("OK");
                          document.getElementById("submit_text").value="";
				  },
                  error: function(XMLHttpRequest, textStatus, errorThrown) {
                          alert("NG");
                  }
                });
            });

            //$scope.search = function(value, index) {
            //    return value.id >= 120;
            //  };
	}]);

    $(function(){
    	    $('#more').click(function(){

    	    	var i = 0;

    		    $.ajax({

    	            url: "./article/loadmore",
    	            type: 'POST',
    	            data: {
    	            index: i,
    	        },
    			    success: function(data){
    	                if(data){
    	                    $("#list").append(data);
    	                    i++;
    	                }else{
    	                    $("#list").append('No more posts to show.');
    	                }
    	            }
    	        });
    	    });
    	});


</script>

@stop


