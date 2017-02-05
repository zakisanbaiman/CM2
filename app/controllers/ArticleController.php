<?php
class ArticleController extends BaseController {
    
    function getArticle() {
        return View::make ( 'frontend.article.index' );
    }
    public function getTimeLine() {
        return View::make ( 'frontend.article.index' );
    }
    public function getSettingProfile() {
        return View::make ( 'frontend.article.setting-profile' );
    }
    public function getSearchFriends() {
        return View::make ( 'frontend.article.search-friends' );
    }

    // 初期表示分の記事を取得
    public function getArticleObj() {
        $user_id = Sentry::getUser()->id;

        $skip = 0; // 取得開始行
        $take = 10; // 取得行数

        // articlesを取得
        $articles = ArticleController::getArticles ( $user_id, $skip, $take );

        return Response::json ( $articles );
    }

    // いいね件数取得
    public function getCountLikes($article_id) {
        $like_count = DB::table ( 'like' )->select ( DB::raw ( 'count(*) as like_count' ) )->where ( 'article_id', '=', $article_id )->groupBy ( 'like_count' )->get ();

        return Response::json ( $like_count );
    }

    // 無限スクロール　リスト追加用
    public function getArticleAppendObj() {
        $skip = $_POST ["skip"];
        $take = $_POST ["take"];
        $user_id = Sentry::getUser()->id;

        // ページに追加するarticlesを取得
        $articles = ArticleController::getArticles ( $user_id, $skip, $take );
            
        return Response::json ( $articles );
    }

    // 記事投稿機能
    public function setArticleObj() {
        $submit_text = $_POST ["submit_text"];
       
        // NGワードチェック
        $response = BaseController::checkNgWords($submit_text);
        if ($response[0] == '1') {
            return $response;
        }
        
        $user_id = Sentry::getUser()->id;

        DB::beginTransaction ();
        $article = new article ();
        $article->article = $submit_text;
        $article->user_id = $user_id;
        $article->save ();
        DB::commit ();

        $this->getArticle ();
    }

    // いいねボタン押下時
    public function setLikeObj() {
        $article_id = $_POST ["article_id"];
        $user_id = Sentry::getUser()->id;
        $skip = $_POST ["skip"];
        $take = $_POST ["take"];

        // すでに同じ記事およびコメントに対していいねを押していないか検索
        $count_like = DB::table ( 'likes' )->select ( DB::raw ( 'count(*) as like_count' ) )->where ( 'user_id', '=', $user_id )->where ( 'article_id', '=', $article_id )->get ();

        DB::beginTransaction ();

        if ($count_like [0]->like_count == 0) {
            // いいね未実行の場合、likesテーブルに登録
            DB::table ( 'likes' )->insert ( array (
                    'user_id' => $user_id,
                    'article_id' => $article_id
            ) );

            // articlesテーブルのlike（いいね件数）をインクリメント
            DB::table ( 'articles' )->where ( 'id', '=', $article_id )->increment ( 'like', 1 );
        } else {
            // いいね済みの場合、likesテーブルから削除
            DB::table ( 'likes' )->where ( 'user_id', '=', $user_id )->where ( 'article_id', '=', $article_id )->delete ();

            // articlesテーブルのlike（いいね件数）をデクリメント
            DB::table ( 'articles' )->where ( 'id', '=', $article_id )->decrement ( 'like' );
        }

        DB::commit ();

        // 最新のarticlesを再取得
        $articles = ArticleController::getArticles ( $user_id, $skip, $take );

        return Response::json ( $articles );
    }

    /**
     * articles取得用SQL
     *
     * @param ユーザID $user_id
     * @param 取得開始行 $skip
     * @param 取得行数 $take
     * @return 取得結果
     */
    public function getArticles($user_id, $skip, $take) {
        $articles = DB::table ( 'articles' )
            ->select ( 'articles.id', 'articles.user_id', 'articles.article', 'articles.like',
                    'articles.created_at', 'likes.id as likesID', 'users.user_image',
                    'users.nickname'
                    )
            ->leftjoin ( 'users', 'articles.user_id', '=', 'users.id' ) // 投稿者情報
            ->leftjoin ( 'likes', // いいね取得
                function ($join) use ($user_id) {
                    $join->on ( 'articles.id', '=', 'likes.article_id' )
                    ->where ( 'likes.user_id', '=', $user_id );
            })
            ->whereIn('articles.user_id', // フレンドの記事
                function ($query) use ($user_id) {
                    $query
                        ->select('friend_id')
                        ->from('friends')
                        ->where ( 'user_id', '=', $user_id );
            })
            ->orWhere('articles.user_id', $user_id) // 自分の記事
            ->orderBy ( 'articles.updated_at', 'desc' )
            ->skip ( $skip )
            ->take ( $take )
            ->get ();

         $countArticles = count ( $articles );
         for($i = 0; $i < $countArticles; $i++) {
             $articles[$i]->my_article = false;
             if ($articles[$i]->user_id == $user_id) {
                 $articles [$i]->my_article = true;
             }
         }
            
        $countArticles = count ( $articles );

        // 各記事にコメントを追加
        for($i = 0; $i < $countArticles; $i ++) {

            // コメントを取得
            $comments = DB::table ( 'comments' )->select ( '*' )->leftjoin ( 'users', 'comments.user_id', '=', 'users.id' )->where ( 'comments.article_id', '=', $articles [$i]->id )->get ();

            $countComments = count ( $comments );
            $articles [$i]->commentArray = array ();

            // コメントを追加
            for($k = 0; $k < $countComments; $k ++) {
                if ($articles [$i]->id == $comments [$k]->article_id) {
                    array_push ( $articles [$i]->commentArray, $comments [$k] );
                }
            }
        }

        return $articles;
    }
    
    /**
     * 初期表示時フレンド取得用SQL
     *
     * @return 取得結果
     */
    public function getFriendObj() {
        
        // ログインセッションからユーザIDを取得
        $user_id = Sentry::getUser()->id;
        $submit_text = '';
        
        $users = ArticleController::getFriendCommonObj($user_id,$submit_text);
        
        return Response::json ( $users );
    }
    
    /**
     * 検索時フレンド取得用SQL
     *
     * @return 取得結果
     */
    public function getSearchFriendObj() {
        
        // ログインセッションからユーザIDを取得
        $user_id = Sentry::getUser()->id;
        $submit_text = $_POST ["submit_text"];
        
        $users = ArticleController::getFriendCommonObj($user_id,$submit_text);
        
        return Response::json ( $users );
    }
    
    /**
     * friends取得用
     *
     * @return 取得結果
     */
    public function getFriendCommonObj($user_id,$submit_text) {
                
        $users = DB::table ( 'users' )
        ->select ( 'users.id','users.first_name','users.last_name','users.nickname'
                ,'users.user_image','f1.approval as approval_1','f2.approval as approval_2'
                ,'f1.updated_at')
                ->leftjoin ( 'friends as f1', function ($join) use ($user_id) {
                    $join->on ( 'users.id', '=', 'f1.friend_id' )
                    ->where ( 'f1.user_id', '=', $user_id ); // f1:自分がリクエスト
                } )
                ->leftjoin ( 'friends as f2', function ($join) use ($user_id) {
                    $join->on ( 'users.id', '=', 'f2.user_id' )
                    ->where ( 'f2.friend_id', '=', $user_id ); // f2:自分にリクエスト
                } )
                ->where('users.id', '<>', $user_id)
                ->where('users.nickname', 'LIKE', '%'.$submit_text.'%')
                ->orWhere('users.first_name', 'LIKE', '%'.$submit_text.'%')
                ->orWhere('users.last_name', 'LIKE', '%'.$submit_text.'%')
                ->orderBy ( 'users.id', 'asc' )
                ->get ();
                
        return $users;
    }
    
    /**
     * フレンド申請、リクエスト承認処理
     *
     * @return 取得結果
     */
    public function setFriendRequestObj() {
        $user_id = Sentry::getUser()->id;
        $friend_id = $_POST ["friend_id"];
        
        // friendsテーブルに登録
        DB::beginTransaction ();
        $friend = new friend ();
        $friend->user_id = $user_id;
        $friend->friend_id = $friend_id;
        $friend->approval = '1';
        $friend->save ();
        DB::commit ();
    }
    
    /**
     * リクエスト取消、フレンド解消処理
     */
    public function cancelRequest() {
        $user_id = Sentry::getUser()->id;
        $friend_id = $_POST ["friend_id"];
    
        // 対象のfriendsテーブルを削除
        DB::beginTransaction ();
        DB::table ( 'friends' )
            ->where ( 'user_id', '=', $user_id )
            ->where ( 'friend_id', '=', $friend_id )
            ->delete ();
        DB::commit ();
    }
    
    /**
     * コメント追加処理
     */
    public function setCommentObj() {
        $user_id = Sentry::getUser()->id;
        $submit_text = $_POST ["submit_text"];
        $article_id = $_POST ["article_id"];
        
        // NGワードチェック
        $response = BaseController::checkNgWords($submit_text);
        if ($response[0] == '1') {
            return $response;
        }
        
        // friendsテーブルに登録
        DB::beginTransaction ();
        $comments = new comment();
        $comments->article_id = $article_id;
        $comments->comment = $submit_text;
        $comments->user_id = $user_id;
        $comments->save();
        DB::commit ();
    }
    
    /**
     * 記事更新処理
     */
    public function updateArticle() {
        $article_id = $_POST ["article_id"];
        $submit_text = $_POST ["submit_text"];
    
        // NGワードチェック
        $response = BaseController::checkNgWords($submit_text);
        if ($response[0] == '1') {
            return $response;
        }
        
        // 対象のarticlesテーブルを更新
        DB::beginTransaction ();
//         $articles = new Article();
//         $articles->article = $submit_text;
//         ->where ( 'id', '=', $article_id )
        
        DB::table('articles')
        ->where('id', $article_id)
        ->update(array('article' => $submit_text));
        
//         ->update ();
        DB::commit ();
    }
    
    /**
     * 記事削除処理
     */
    public function deleteArticle() {
        $article_id = $_POST ["article_id"];
    
        // 対象のarticlesテーブルを削除
        DB::beginTransaction ();
        DB::table ( 'articles' )
        ->where ( 'id', '=', $article_id )
        ->delete ();
        DB::commit ();
    }
    
    /**
     * 記事修正画面呼出時
     */
    public function getArticleOneObj() {
        $article = Article::where('id', '=', Input::get('id'))->get();
        return Response::json($article);
    }
}
?>
