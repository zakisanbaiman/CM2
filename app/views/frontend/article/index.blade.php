<h1></h1>
@extends('frontend/layouts/default')
@section('content')
<body ng-controller="ArticleController">
	<nav class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">Menu</div>
			<ul class="nav nav-pills nav-stacked">
				<li class="active"><a><i class="glyphicon glyphicon-list-alt"></i>
						タイムライン</a></li>
				<li><a href="/search-friends/"><i class="glyphicon glyphicon-user"></i>
						フレンド検索</a></li>
				<li><a href=""><i class="glyphicon glyphicon-question-sign"></i> ヘルプ</a></li>
			</ul>
		</div>
	</nav>

	<main>

	<article id="fixed" when-scrolled="loadMore()">
        <!-- 記事投稿フォーム -->
		<form id="submit-form" method="post" class="submit-box"
			onsubmit="return setArticleObj()">
			<table>
				<tr>
					<td>
    					<textarea id="submit_text" placeholder='今なにしてる？' class="form-control"
    							rows="2" cols="50" onkeydown="textareaResize(event)" class="display:inline;"/></textarea>
    	        	</td>
    	        	<td valign="bottom" class="button">
    	        		<button class="btn btn-primary" type="submit" class="display:inline;">投稿</button>
    	        	</td>
    	        </tr>
			</table>
		</form>
        <!-- 記事一覧 -->
			<!-- 投稿者プロフィール -->
			<li id="list" class="timeline-box"
					ng-repeat="article in articles track by $index">
				<div class="parent">
					<p>
						<img src="/images/users/@{{ article.user_image }}" alt=""
							class="user-img" ng-class="(isDuplicated($first,$index,article))">
					</p>
					<p class="box-p">@{{ article.id }}</p>
					<p class="box-p">@{{ article.nickname }}</p>
				</div>
				<!-- 記事内容 -->
				<article class="article-box">
					<table>
        				<tr>
        					<td>
        						<article id="article_label@{{ article.id }}">@{{ article.article }}</article>
    							<textarea id="submit-update@{{ article.id }}" name="submit-update" class="form-control"
                        				rows="2" cols="50">@{{ article.article }}</textarea>
                        	</td>
                        	<td valign="bottom" class="button">
                                <button name="btn_update" id="btn_update@{{ article.id }}" class="btn btn-primary" type="submit"
                                        ng-click="updateArticle(article.id)"
                                        >更新</button>
                            </td>
            	        </tr>
        			</table>
        		</article>
				<p class="box-p">
					<button id="btn_like" class="btn btn-default"
						ng-click="setLike(article.id)" ng-class="(isLiked(article))">いいね！(@{{ article.like }})</button>
					<button class="btn btn-default"
						ng-click="changeEditMode(article.id)"
						ng-show="article.my_article">更新
					</button>
					<button class="btn btn-default"
						ng-click="openDeleteArticleDialog(article.id)"
						ng-show="article.my_article">削除</button>
				</p>
				<!--コメント入力フォーム-->
    		    <form id="comment-form" method="post" class="input-group comment">
                    <input type="text" id="submit-comment@{{ article.id }}" name="submit-comment@{{ article.id }}"
                    		class="form-control" placeholder='コメントを入力してください。' />
                    <span class="input-group-btn">
                        <button class="btn btn-default submit_button" type="submit"
                                ng-click="addComment(article.id)">
                            <i class='glyphicon glyphicon-pencil'></i>
                        </button>
                    </span>
                </form>
				
				<!--コメント出力用ボックス-->
				<div id="comment_list" ng-repeat="comment in article.commentArray">
					<div id="comment_box" class="comment-box">
						<div class="parent">
							<p class="box-p">
								<img src="/images/users/@{{ comment.user_image }}" alt=""
									class="commenter-img">
							</p>
							<p class="box-p">@{{ comment.nickname }}</p>
						</div>
						<p class="comment-text">@{{ comment.comment }}</p>
					</div>
				</div>
			</li>
		<div id="loading">
			<img src="/images/gif/gif-load.gif">
		</div>
		<div id="container"></div>
	</article>
	</main>
	
	    <!-- 削除ダイアログ -->
    <div ng-controller="DeleteArticleModalController">
        <script type="text/ng-template" id="deleteArticleModal.html">
            <div class="manageModalBox">
                <p>本当に削除しますか？</p>
                <div class="articleModalBoxFooter">
                    <a class="btn btn-default" ng-click="deleteArticleModalOk()">Ok</a>
                    <a class="btn btn-default" ng-click="deleteArticleModalCancel()">Cancel</a>
                </div>
            </div>
        </script>
    </div>
</body>

<script	src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<script>
	// 初期化
	$("#loading").hide();
	$("textarea[name=submit-update]").hide();
	$("button[name=btn_update]").hide();

    angular.module('myApp', ['ui.bootstrap','ngFileUpload'])
        .config(function() {
            //...
        });

    angular.module('myApp')
            .controller('ArticleController',
            ['$scope','$modal','$http','$timeout', function($scope,$modal,$http,$timeout) {

            // 初期表示分の記事を取得
            $scope.articles = [];
            getArticleObj = function() {
            	var dataObj = {};
            	$http({
                   	method : 'post',
                   	url : '/article/getArticleObj',
                   	params : dataObj
                }).success(function(data, status, headers, config) {
	                $scope.articles = data;
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
                      submit_text : submit_text
                      },
                  success: function(data) {
                      if (data['status'] != '1') {
                          document.getElementById("submit_text").value="";
                          getArticleObj();
                      }else{
                    	  alert(data['message']);
                      }
				  },
                  error: function(data) {
                          alert(data);
                  }
                })
            });

			// コメント追加
            $scope.addComment = function(article_id){

				var controlId = "#submit-comment" + article_id;
            	var submit_text = $(controlId).val();
				
                $.ajax({
                    url: '/article/setCommentObj',
                    type:'POST',
                    data : {
                      submit_text : submit_text,
                      article_id : article_id
                      },
                    success: function(data) {
                        if (data['status'] != '1') {
                            $(controlId).val("");
                            getArticleObj();
                        }else{
                    	    alert(data['message']);
                        }
                    },
                    error: function(data) {
                        alert(data);
                    }
                });
            };

			//画面最下位までスクロール時
	        $scope.loadMore = function() {
    			// Ajax処理
      			$.ajax({
          			url: '/article/getArticleAppendObj',
                    type:'POST',
                    data : {
                        skip : $scope.articles.length,
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

             	// Ajax処理
                $.ajax({
                  url: '/article/setLikeObj',
                  type:'POST',
                  data : {
                	  article_id : article_id,
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

            // ユーザが対象記事にいいねを押しているか判断
            $scope.isLiked = function(article){
                if(article.likesID != null){
					return "btn-primary";
                }
            }

			// 記事を更新
            $scope.updateArticle = function(article_id){

            	var article_label = "#article_label" + article_id;
            	var submit_update = "#submit-update" + article_id;
            	var btn_update = "#btn_update" + article_id;
            	var submit_text = $(submit_update).val();
				
                $.ajax({
                	url: '/article/updateArticle',
                    type:'POST',
                    data : {
                        submit_text : submit_text,
                        article_id : article_id
                        },
				    success: function(data) {
                        if (data['status'] != '1') {
                            getArticleObj();
                            $(article_label).toggle();
                        	$(submit_update).toggle();
                        	$(btn_update).toggle();
                        }else{
                  	        alert(data['message']);
                  	      	$(submit_update).val() = "";
                        }
                    },
                    error: function(data) {
                        alert(data);
                    }
                });
            };
            
            // 記事を削除
            $scope.deleteArticle = function(article_id){
            	
                $.ajax({
                  url: '/article/deleteArticle',
                  type:'POST',
                  data : {
                	  article_id : article_id,
                      },
                  success: function(data) {
                	  getArticleObj();
				  },
                  error: function(XMLHttpRequest, textStatus, errorThrown) {
                  }
            	});
            }

            // 編集モード切り替え
            $scope.changeEditMode = function(article_id){
            	var article_label = "#article_label" + article_id;
            	var submit_update = "#submit-update" + article_id;
            	var btn_update = "#btn_update" + article_id;
            	
            	$(article_label).toggle();
            	$(submit_update).toggle();
            	$(btn_update).toggle();
            }

            $scope.animationsEnabled = true;
            
            // 削除ダイアログ表示
            $scope.openDeleteArticleDialog = function (article_id) {
                var dataObj = {};
                dataObj.id = article_id;
                    var modalInstance = $modal.open({
                        animation: $scope.animationsEnabled,
                        templateUrl: 'deleteArticleModal.html',
                        controller: 'DeleteArticleModalController',
                        resolve: {
                            article: function () {
                                return dataObj;
                            }
                        }
                    });
            }
	}]);

    var sending = 0;

	// 無限スクロール用ディレクティブ
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

	// 削除用ディレクティブ
    angular.module('myApp').
		    controller('DeleteArticleModalController', function ($scope, $modalInstance, $http, article) {

        $scope.article = article;
    
        // OKボタン押下時
        $scope.deleteArticleModalOk = function () {
        	var testlogic = '36';
            $.ajax({
                url: '/article/deleteArticle',
                type:'POST',
                data : {
              	  article_id : article.id,
                    },
                success: function(data) {
              	  getArticleObj();
    			  },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                }
          	});
            $modalInstance.close();
        };
    
        // Cancelボタン押下時
        $scope.deleteArticleModalCancel = function () {
            $modalInstance.dismiss('cancel');
        };
    });
    
</script>

@stop


