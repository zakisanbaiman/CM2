<?php

class ArticlesRepository {

    /**
     * articles取得用
     * @param ユーザID
     * @param 取得開始行
     * @param 取得行数
     * @return 取得結果
     */
    public function selectArticlesByUserId($user_id, $skip, $take) {
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
     * articles登録用
     * @param ユーザID
     * @param 記事内容
     * @param ユーザID
     */
    public function insertArticles($submit_text, $user_id) {
        DB::beginTransaction ();
        $article = new article ();
        $article->article = $submit_text;
        $article->user_id = $user_id;
        $article->save ();
        DB::commit ();
    }
    
    /**
     * articles更新用
     */
    public function updateArticle( $article_id, $submit_text) {
        DB::beginTransaction ();
        DB::table('articles')
        ->where('id', $article_id)
        ->update(array('article' => $submit_text));
        DB::commit ();
    }
    
    /**
     * articles削除用
     */
    public function deleteByKey( $article_id) {
        DB::beginTransaction ();
        DB::table ( 'articles' )
        ->where ( 'id', '=', $article_id )
        ->delete ();
        DB::commit ();
    }
    
    /**
     * いいねをインクリメント
     * @param 記事ID
     */
    public function incrementLikes($article_id) {
        DB::table ( 'articles' )
            ->where ( 'id', '=', $article_id )
            ->increment ( 'like', 1 );
    }
    
    /**
     * いいねをデクリメント
     * @param 記事ID
     */
    public function decrementLikes($article_id) {
        DB::table ( 'articles' )
            ->where ( 'id', '=', $article_id )
            ->decrement ( 'like' );
    }
    
    
}
