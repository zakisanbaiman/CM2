<h1></h1>
@extends('layout')
@section('content')
<body ng-controller="ArticleController">
	<main>
    	<div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Menu
                </div>
                <!-- <div class="panel-body"> -->
                <ul class="nav nav-pills nav-stacked">
                    <li class="active"><a href=""><i class="glyphicon glyphicon-pencil"></i> メッセージ</a></li>
                    <li><a href=""><i class="glyphicon glyphicon-cog"></i> プロフィール設定</a></li>
                    <li><a href=""><i class="glyphicon glyphicon-user"></i> フレンド検索</a></li>
                    <li><a href=""><i class="glyphicon glyphicon-question-sign"></i> ヘルプ</a></li>
                </ul> 
                <!-- </div> -->
            </div>
        </div>
    			
      	<div id="fixed" when-scrolled="loadMore()">
        <section class="container">
        	<form id="submit-form" method="post" class="submit-box" onsubmit="return setArticleObj()" style="display:inline-flex">
				<textarea type="text" class="submit-textbox" id="submit_text" placeholder='今なにしてる？'/></textarea>
				<button id="submit" type="submit" class="glyphicon glyphicon-open submit-btn"></button>
        	</form>
			<li id="list" class="timeline-box" ng-repeat="article in articles">
				<p><img src="@{{ article.user_image }}" alt="" class="user-img"></p>
				<p class="box-p">@{{ article.ID }}</p>
				<p class="article-box">@{{ article.article }}</p>
				<p class="article-box">いいね！@{{ article.like }}人</p>
				<p class="box-p">
				<a id="btn_like" class="btn btn-default" ng-click="setLike(article.ID)" ng-class="(isLiked(article))">いいね！</a>
				<a class="btn btn-default" ng-click="openUpdateArticleDialog(article.id)">コメントする</a>
				<a class="btn btn-default" ng-click="openDeleteArticleDialog(article.id)">シェアする</a>

                <!--コメント出力用ボックス-->
                <p class="comment-box" ng-class="(isAri(comments))">コメント
      				<li ng-repeat="comment in comments")">
    					<a>@{{ comment.comment }}</a>
  					</li>
                </p>
            </li>
            <div id="loading"><img src="http://loadergenerator.com/gif-load"></div>
            <div id="container"></div>     
        </section>
        </div>
	</main>
</body>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<script>
	$("#loading").hide();

    angular.module('myApp', ['ui.bootstrap','ngFileUpload'])
        .config(function() {
            //...
        });

    angular.module('myApp')
            .controller('ArticleController',
            ['$scope','$modal','$http','$timeout', function($scope,$modal,$http,$timeout) {

            //初期表示分を取得
            $scope.articles = [];
            getArticleObj = function() {
            	var dataObj = {};
	            dataObj.user_id = '7010';
            	$http({
                   	method : 'post',
                   	url : '/article/getArticleObj',
                   	params : dataObj
                }).success(function(data, status, headers, config) {
	                $scope.articles = data;
// 	                getCommentObj();
	            }).error(function(data, status, headers, config) {
	            });
            }
            getArticleObj();

			//投稿ボタン押下時
            $('#submit-form').submit(function(event) {
                // ここでsubmitをキャンセルします。
                event.preventDefault();

                var submit_text = $('#submit_text').val();

                // Ajax処理
                $.ajax({
                  url: '/article/setArticleObj',
                  type:'POST',
                  data : {
                      submit_text : submit_text,
                      user_id : '7010'
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

			//画面最下位までスクロール時
	        $scope.loadMore = function() {
    			// Ajax処理
      			$.ajax({
          			url: '/article/getArticleAppendObj',
                    type:'POST',
                    data : {
                        user_id : '7010',
                        skip : $scope.articles.length,
                        take : 10
                    },
                    success: function(data) {
                		var len = data.length;
                		for(i = 0; i < len; i++) {
        					$scope.articles.push(data[i]);
        				}
                		sending = 0;
                		$scope.$apply();
                		$("#loading").fadeOut();
                		$("#container").fadeIn();
    	  			},
          			error: function(XMLHttpRequest, textStatus, errorThrown) {
          			}
    			});
			};

			//いいねボタン押下時
            $scope.setLike = function(article_id){
                //一旦固定値でユーザIDを持たせてます
                var user_id = '7010';
                
             	// Ajax処理
                $.ajax({
                  url: '/article/setLikeObj',
                  type:'POST',
                  data : {
                      user_id : user_id,
                	  article_id : article_id,
                	  skip : 0,
                      take : $scope.articles.length
                      },
                  success: function(data) {
                	  $scope.articles = data;
                	  $scope.$apply();
				  },
                  error: function(XMLHttpRequest, textStatus, errorThrown) {
                  }
            	});
            };
            
            //ユーザが対象記事にいいねを押しているか判断
            $scope.isLiked = function(article){
                if(article.likesID != null){
					return "btn-primary";            
                }
            }

            $scope.isAri = function(){
                if($scope.comments.length != 0){
					return "btn-primary";            
                }
            }

			//投稿フォームの縦幅自動調整
            $("#submit_text").height(30);//init
            $("#submit_text").css("lineHeight","20px");//init
            $("#submit_text").on("input",function(evt){
                if(evt.target.scrollHeight > evt.target.offsetHeight){   
                    $(evt.target).height(evt.target.scrollHeight);
                }else{          
                    var lineHeight = Number($(evt.target).css("lineHeight").split("px")[0]);
                    while (true){
                        $(evt.target).height($(evt.target).height() - lineHeight); 
                        if(evt.target.scrollHeight > evt.target.offsetHeight){
                            $(evt.target).height(evt.target.scrollHeight);
                            break;
                        }
                    }
                }
            });

			
//             $(document).ready(function () {
//             	  hsize = $(window).height();
//             	  $("submit-form").css("height", hsize + "px");
//             	});
//             	$(window).resize(function () {
//             	  hsize = $(window).height();
//             	  $("submit-form").css("height", hsize + "px");
//         	});    
	}]);
	
    var sending = 0;

	//無限スクロール用ディレクティブ
    angular.module('myApp')
    .directive('whenScrolled', function() {
        return function(scope, elm, attr) {
            var raw = elm[0];
            
            elm.bind('scroll', function() {
                if (raw.scrollTop + raw.offsetHeight >= raw.scrollHeight & sending == 0) {
                    scope.$apply(attr.whenScrolled);

                    //多重送信防止
                    sending = 1;

                    //ローディングアニメーション
                    $("#loading").fadeIn();
            		$("#container").fadeOut();
                }
            });
        };
    });
</script>

@stop


