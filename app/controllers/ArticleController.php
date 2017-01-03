<?php
class ArticleController extends BaseController {
    public function getArticle() {
        return View::make ( 'frontend.article.index' );
    }
    public function getTimeLine() {
        return View::make ( 'frontend.article.timeline' );
    }
    public function getSettingProfile() {
        return View::make ( 'frontend.article.setting-profile' );
    }
    
    public function getSearchFriends() {
        return View::make ( 'frontend.article.search-friends' );
    }

    // 初期表示分の記事を取得
    public function getArticleObj() {
        $user_id = Input::get ( 'user_id' );

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
        $user_id = $_POST ["user_id"];

        // ページに追加するarticlesを取得
        $articles = ArticleController::getArticles ( $user_id, $skip, $take );
            
        return Response::json ( $articles );
    }

    // 記事投稿機能
    public function setArticleObj() {
        $submit_text = $_POST ["submit_text"];
        $user_id = $_POST ["user_id"];

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
        $user_id = $_POST ["user_id"];
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
        $articles = DB::table ( 'articles' )->select ( 'articles.id', 'articles.user_id', 'articles.article', 'articles.like', 'articles.created_at', 'likes.id as likesID', 'users.user_image', 'users.nickname' )->leftjoin ( 'users', 'articles.user_id', '=', 'users.id' )->leftjoin ( 'likes', function ($join) use ($user_id) {
            $join->on ( 'articles.id', '=', 'likes.article_id' )->where ( 'likes.user_id', '=', $user_id );
        } )->orderBy ( 'articles.updated_at', 'desc' )->skip ( $skip )->take ( $take )->get ();

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
}
?>
