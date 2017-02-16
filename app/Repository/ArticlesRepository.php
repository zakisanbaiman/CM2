<?php

class ArticlesRepository {

    /**
     * articles取得用
     * @param int $userId ユーザID
     * @param int $skip 取得開始行
     * @param int $take 取得行数
     * @return 取得結果
     */
    public function findByUserId($userId, $skip, $take) {
        $articles = DB::table ( 'articles' )
            ->select ( 'articles.id', 'articles.user_id', 'articles.article', 'articles.like',
                    'articles.created_at', 'likes.id as likesID', 'users.user_image',
                    'users.nickname'
            )
            ->leftjoin ( 'users', 'articles.user_id', '=', 'users.id' ) // 投稿者情報
            ->leftjoin ( 'likes', // いいね取得
                function ($join) use ($userId) {
                    $join->on ( 'articles.id', '=', 'likes.article_id' )
                    ->where ( 'likes.user_id', '=', $userId );
            })
            ->whereIn('articles.user_id', // フレンドの記事
                function ($query) use ($userId) {
                    $query
                    ->select('friend_id')
                    ->from('friends')
                    ->where ( 'user_id', '=', $userId );
                })
            ->orWhere('articles.user_id', $userId) // 自分の記事
            ->orderBy ( 'articles.updated_at', 'desc' )
            ->skip ( $skip )
            ->take ( $take )
            ->get ();

        $countArticles = count ( $articles );
        for($i = 0; $i < $countArticles; $i++) {
            $articles[$i]->my_article = false;
            if ($articles[$i]->user_id == $userId) {
                $articles [$i]->my_article = true;
            }
        }

        $countArticles = count ( $articles );

        // 各記事にコメントを追加
        for($i = 0; $i < $countArticles; $i ++) {

            // コメントを取得
            $comments = DB::table ( 'comments' )
                ->select ( 'comments.*', 'users.nickname', 'users.user_image' )
                ->leftjoin ( 'users', 'comments.user_id', '=', 'users.id' )
                ->where ( 'comments.article_id', '=', $articles [$i]->id )
                ->get ();

            $countComments = count ( $comments );
            $articles [$i]->commentArray = [];

            // コメントを追加
            for($k = 0; $k < $countComments; $k ++) {
                if ($articles [$i]->id == $comments [$k]->article_id) {
                    
                    $comments[$k]->my_comment = false;
                    if ($comments[$k]->user_id == $userId) {
                        $comments[$k]->my_comment = true;
                    }
                    
                    array_push ( $articles [$i]->commentArray, $comments [$k] );
                }
            }
        }
        return $articles;
    }
    
    /**
     * articles登録用
     * @param string $submitText 記事内容
     * @param int $userId ユーザID
     */
    public function insertForSubmit($submitText, $userId) {
        DB::beginTransaction ();
        $article = new article ();
        $article->article = $submitText;
        $article->user_id = $userId;
        $article->save ();
        DB::commit ();
    }
    
    /**
     * articles更新用
     * @param int $articleId 記事ID
     * @param int $submitText 記事内容
     */
    public function updateArticle( $articleId, $submitText) {
        DB::beginTransaction ();
        DB::table('articles')
        ->where('id', $articleId)
        ->update(['article' => $submitText]);
        DB::commit ();
    }
    
    /**
     * articles削除用
     * @param int $articleId 記事ID
     */
    public function deleteByKey( $articleId) {
        DB::beginTransaction ();
        DB::table ( 'articles' )
        ->where ( 'id', '=', $articleId )
        ->delete ();
        DB::commit ();
    }
    
    /**
     * いいねをインクリメント
     * @param int $articleId 記事ID
     */
    public function incrementLikes($articleId) {
        DB::table ( 'articles' )
            ->where ( 'id', '=', $articleId )
            ->increment ( 'like', 1 );
    }
    
    /**
     * いいねをデクリメント
     * @param int $articleId 記事ID
     */
    public function decrementLikes($articleId) {
        DB::table ( 'articles' )
            ->where ( 'id', '=', $articleId )
            ->decrement ( 'like' );
    }
    
    /**
     * アイテムの変更をタイムラインに反映
     * @param string $userNickname ニックネーム
     * @param int $userId ユーザID
     */
    public function insertChangeItem($userId, $userNickname) {
        DB::beginTransaction ();
        $article = new article ();
        $article->article = $userNickname . 'さんがアイテムを更新しました。';
        $article->user_id = $userId;
        $article->save ();
        DB::commit ();
    }
}
