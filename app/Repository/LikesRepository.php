<?php

class LikesRepository {
    
    /**
     * likes登録用
     * @param ユーザID
     * @param 記事ID
     */
    public function insertLikes($user_id, $article_id) {
        DB::table ( 'likes' )
            ->insert ( array (
                'user_id' => $user_id,
                'article_id' => $article_id
            ) );
    }
    
    /**
     * likes削除用
     * @param ユーザID
     * @param 記事ID
     */
    public function deleteLikes($user_id, $article_id) {
        DB::table ( 'likes' )
            ->where ( 'user_id', '=', $user_id )
            ->where ( 'article_id', '=', $article_id )
            ->delete ();
    }
}
