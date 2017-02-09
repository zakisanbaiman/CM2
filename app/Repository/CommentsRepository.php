<?php

class CommentsRepository {

    /**
     * commentsテーブルに登録
     */
    public function insertByUserIdWithArticleId(
            $article_id, $submit_text, $user_id) {
        DB::beginTransaction ();
        $comments = new comment();
        $comments->article_id = $article_id;
        $comments->comment = $submit_text;
        $comments->user_id = $user_id;
        $comments->save();
        DB::commit ();
    }
}
