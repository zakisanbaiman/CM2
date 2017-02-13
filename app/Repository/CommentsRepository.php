<?php

class CommentsRepository {

    /**
     * commentsテーブルに登録
     */
    public function insertByUserIdWithArticleId(
            $articleId, $submitText, $userId) {
        DB::beginTransaction ();
        $comments = new comment();
        $comments->article_id = $articleId;
        $comments->comment = $submitText;
        $comments->user_id = $userId;
        $comments->save();
        DB::commit ();
    }
}
