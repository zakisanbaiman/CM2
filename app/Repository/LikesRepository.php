<?php

class LikesRepository
{

    /**
     * likes登録
     * @param string $userId ユーザID
     * @param string $articleId 記事ID
     */
    public function insertForArticles($userId, $articleId)
    {
        DB::table('likes')->insert(array(
            'user_id' => $userId,
            'article_id' => $articleId
        ));
    }

    /**
     * likes削除
     * @param string $userId ユーザID
     * @param string $articleId 記事ID
     */
    public function deleteFotArticles($userId, $articleId)
    {
        DB::table('likes')->where('user_id', '=', $userId)
            ->where('article_id', '=', $articleId)
            ->delete();
    }

    /**
     * likes件数カウント
     * @param string $userId ユーザID
     * @param string $articleId 記事ID
     * @return いいね件数
     */
    
    public function countLikes($userId, $articleId)
    {
        return DB::table('likes')
            ->select(DB::raw('count(*) as like_count'))
            ->where('user_id', '=', $userId)
            ->where('article_id', '=', $articleId)
            ->get();
    }
}
