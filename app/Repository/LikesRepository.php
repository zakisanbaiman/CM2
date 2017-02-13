<?php

class LikesRepository
{

    /**
     * likes登録
     * @param string $user_id ユーザID
     * @param string $article_id 記事ID
     */
    public function insertForArticles($user_id, $article_id)
    {
        DB::table('likes')->insert(array(
            'user_id' => $user_id,
            'article_id' => $article_id
        ));
    }

    /**
     * likes削除
     * @param string $user_id ユーザID
     * @param string $article_id 記事ID
     */
    public function deleteFotArticles($user_id, $article_id)
    {
        DB::table('likes')->where('user_id', '=', $user_id)
            ->where('article_id', '=', $article_id)
            ->delete();
    }

    /**
     * likes件数カウント
     * @param string $user_id ユーザID
     * @param string $article_id 記事ID
     * @return いいね件数
     */
    
    public function countLikes($user_id, $article_id)
    {
        return DB::table('like')
            ->select(DB::raw('count(*) as like_count'))
            ->where('article_id', '=', $article_id)
            ->groupBy('like_count')
            ->get();
    }
}
