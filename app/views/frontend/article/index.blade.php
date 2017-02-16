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
    					<textarea id="submitText" placeholder='今なにしてる？' class="form-control"
    							rows="2" cols="50" onkeydown="textareaResize(event)" class="display:inline;"/></textarea>
    	        	</td>
    	        	<td valign="top" class="td_button">
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
        						<article id="articleLabel@{{ article.id }}">@{{ article.article }}</article>
    							<textarea id="articleText@{{ article.id }}" name="articleText" class="form-control"
                        				rows="2" cols="50">@{{ article.article }}</textarea>
                        	</td>
                        	<td valign="top" class="td_button">
                                <button name="btnUpdateArticle" id="btnUpdateArticle@{{ article.id }}" class="btn btn-primary" type="submit"
                                        ng-click="updateArticle(article.id)"
                                        >投稿</button>
                            </td>
            	        </tr>
        			</table>
        		</article>
				<p class="box-p">
					<button id="btn_like" class="btn btn-default"
						ng-click="setLike(article.id)" ng-class="(isLiked(article))">いいね！(@{{ article.like }})</button>
					<button class="btn btn-default"
						ng-click="changeEditMode(article.id, '0')"
						ng-show="article.my_article">更新
					</button>
					<button class="btn btn-default"
						ng-click="openDeleteDialog(article.id, '0')"
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
							<p class="comment-text">@{{ comment.nickname }}</p>
						</div>
						<table>
            				<tr>
            					<td>
            						<article id="commentLabel@{{ comment.id }}">@{{ comment.comment }}</article>
        							<textarea id="commentText@{{ comment.id }}" name="commentText" class="form-control"
                            				rows="1" cols="45">@{{ comment.comment }}</textarea>
                            	</td>
                            	<td valign="top" class="td_button">
                                    <button name="btnUpdateComment" id="btnUpdateComment@{{ comment.id }}" class="btn btn-primary" type="submit"
                                            ng-click="updateComment(comment.id)"
                                            >投稿</button>
                                </td>
                	        </tr>
            			</table>
            			<p class="box-p">
                            <button class="btn btn-default"
        						ng-click="changeEditMode(comment.id, '1')"
        						ng-show="comment.my_comment">更新</button>
        					<button class="btn btn-default"
        						ng-click="openDeleteDialog(comment.id, '1')"
        						ng-show="comment.my_comment">削除</button>
        				</p>
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
    <div ng-controller="DeleteModalController">
        <script type="text/ng-template" id="deleteModal.html">
            <div class="manageModalBox">
                <p>本当に削除しますか？</p>
                <div class="manageModalBoxFooter">
                    <a class="btn btn-default" ng-click="deleteModalOk()">Ok</a>
                    <a class="btn btn-default" ng-click="deleteModalCancel()">Cancel</a>
                </div>
            </div>
        </script>
    </div>
</body>

<script	src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<script>
	const IS_ARTICLE = '0';
	const IS_COMMENT = '1';

	// 初期化
	$("#loading").hide();
	$("button[name=btnUpdateArticle]").hide();
	$("button[name=btnUpdateComment]").hide();
	$("textarea[name=articleText]").hide();
	$("textarea[name=commentText]").hide();
	
    angular.module('myApp', ['ui.bootstrap','ngFileUpload'])
        .config(function() {
            //...
        });

    angular.module('myApp')
            .controller('ArticleController',
            ['$scope','$modal','$http','$timeout', function($scope,$modal,$http,$timeout) {

            const SUCCESS_CODE = '0';
            const FAILD_CODE = '1';
            	
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

                var submitText = $('#submitText').val();

                // Ajax処理
                $.ajax({
                  url: '/article/setArticleObj',
                  type:'POST',
                  data : {
                      submitText : submitText
                      },
                  success: function(data) {
                      if (data['status'] == SUCCESS_CODE) {
                          document.getElementById("submitText").value="";
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
            $scope.addComment = function(articleId){

				var controlId = "#submit-comment" + articleId;
            	var submitText = $(controlId).val();
				
                $.ajax({
                    url: '/article/setCommentObj',
                    type:'POST',
                    data : {
                      submitText : submitText,
                      articleId : articleId
                      },
                    success: function(data) {
                    	if (data['status'] == SUCCESS_CODE) {
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
            $scope.setLike = function(articleId){

             	// Ajax処理
                $.ajax({
                  url: '/article/setLikeObj',
                  type:'POST',
                  data : {
                	  articleId : articleId,
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
            $scope.updateArticle = function(articleId){

            	var articleLabel = "#articleLabel" + articleId;
            	var submitUpdate = "#articleText" + articleId;
            	var btnUpdate = "#btnUpdateArticle" + articleId;
            	var submitText = $(submitUpdate).val();
				
                $.ajax({
                	url: '/article/updateArticle',
                    type:'POST',
                    data : {
                        submitText : submitText,
                        articleId : articleId
                        },
				    success: function(data) {
				    	if (data['status'] == SUCCESS_CODE) {
                            getArticleObj();
                            $(articleLabel).toggle();
                        	$(submitUpdate).toggle();
                        	$(btnUpdate).toggle();
                        }else{
                  	        alert(data['message']);
                  	      	$(submitUpdate).val() = "";
                        }
                    },
                    error: function(data) {
                        alert(data);
                    }
                });
            };

			// コメントを更新
            $scope.updateComment = function(commentId){

            	var label = "#commentLabel" + commentId;
            	var text = "#commentText" + commentId;
            	var btnUpdate = "#btnUpdateComment" + commentId;
            	var submitText = $(text).val();
				
                $.ajax({
                	url: '/article/updateComment',
                    type:'POST',
                    data : {
                        submitText : submitText,
                        commentId : commentId
                        },
				    success: function(data) {
				    	if (data['status'] == SUCCESS_CODE) {
                            getArticleObj();
                            $(label).toggle();
                        	$(text).toggle();
                        	$(btnUpdate).toggle();
                        }else{
                  	        alert(data['message']);
                  	      	$(text).val() = "";
                        }
                    },
                    error: function(data) {
                        alert(data);
                    }
                });
            };
            
            // 編集モード切り替え
            $scope.changeEditMode = function(id, type){

            	if (type == IS_ARTICLE) {
                	// 記事の更新ボタン押下時
                	var label = "#articleLabel" + id;
                	var text = "#articleText" + id;
                	var btnUpdate = "#btnUpdateArticle" + id;
            	}else{
                	// コメントの更新ボタン押下時
            		var label = "#commentLabel" + id;
                	var text = "#commentText" + id;
                	var btnUpdate = "#btnUpdateComment" + id;
            	}
            	
            	$(label).toggle();
            	$(text).toggle();
            	$(btnUpdate).toggle();
            }

            $scope.animationsEnabled = true;
            
            // 削除ダイアログ表示
            $scope.openDeleteDialog = function (id, type) {
                var dataObj = {};
                dataObj.id = id;
                dataObj.type = type;
                    var modalInstance = $modal.open({
                        animation: $scope.animationsEnabled,
                        templateUrl: 'deleteModal.html',
                        controller: 'DeleteModalController',
                        resolve: {
                        	rec: function () {
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
		    controller('DeleteModalController', function ($scope, $modalInstance, $http, rec) {

        $scope.rec = rec;
    
        // OKボタン押下時
        $scope.deleteModalOk = function () {

        	wUrl = '';
			if (rec.type == IS_ARTICLE) {
				wUrl = '/article/deleteArticle';
        	}else{
        		wUrl = '/article/deleteComment';
        	}
        	
            $.ajax({
                url: wUrl,
                type:'POST',
                data : {
              	  id : rec.id,
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
        $scope.deleteModalCancel = function () {
            $modalInstance.dismiss('cancel');
        };
    });
    
</script>

@stop


