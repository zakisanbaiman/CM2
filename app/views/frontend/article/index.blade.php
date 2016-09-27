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
			
				<div id="fixed" when-scrolled="loadMore()">
					<li id="list" class="timeline-box" ng-repeat="article in articles">
						<p class="box-p">@{{ article.user_id }}</p>
						<p class="article-box">@{{ article.article }}</p>
						<p class="article-box">いいね！@{{ article.like }}人</p>
						<p class="box-p">
						<a class="btn btn-default" ng-click="openArticleDetail(article.id)">いいね！</a>
						<a class="btn btn-default" ng-click="openUpdateArticleDialog(article.id)">コメントする</a>
						<a class="btn btn-default" ng-click="openDeleteArticleDialog(article.id)">シェアする</a>
	                </p>
	            </li>       
	            </div>
            
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

    
    angular.module('myApp')
            .controller('ArticleController',
            ['$scope','$modal','$http','$timeout', function($scope,$modal,$http,$timeout) {

    		var alldata = [];
            $scope.articles = [];
        	    
            getArticleObj = function() {
            	$http({
                   	method : 'get',
                   	url : '/article/getArticleObj',
                }).success(function(data, status, headers, config) {
                	
					var i = 0;
			        for(i = 0; i < 2; i++) {
			        	$scope.articles.push(data[i]);
			        }
			        alldata = data;
	                //もともとあったやつ $scope.articles = data;
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
                          getArticleObj();
				  },
                  error: function(XMLHttpRequest, textStatus, errorThrown) {
                          alert("NG");
                  }
                });
            });

	        $scope.loadMore = function() {
	        	//var len = $scope.articles.length;
	        	/*for(i = $scope.articles.length; i < i + 2; i++) {
	        		$scope.articles.push(alldata[i]);
	        	}*/
    	  	};
	}]);

    angular.module('myApp')
    .directive('whenScrolled', function() {
        return function(scope, elm, attr) {
            var raw = elm[0];
            
            elm.bind('scroll', function() {
                if (raw.scrollTop + raw.offsetHeight >= raw.scrollHeight) {
                    scope.$apply(attr.whenScrolled);
                }
            });
        };
    });
</script>

@stop


