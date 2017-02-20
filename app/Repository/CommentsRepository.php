<?php

class CommentsRepository {

    /**
     * commentsテーブルに登録
     * @param int $articleId 対象記事ID
     * @param string $submitText コメント内容
     * @param int $userId ユーザID
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
    
    /**
     * comments更新用
     * @param int $commentId コメントID
     * @param string $submitText コメント内容
     */
    public function updateComment( $commentId, $submitText) {
        DB::beginTransaction ();
        DB::table('comments')
            ->where('id', $commentId)
            ->update(['comment' => $submitText]);
        DB::commit ();
    }
    
    /**
     * comments削除用
     * @param int $commentId コメントID
     */
    public function deleteByCommentId($commentId) {
        DB::beginTransaction ();
        DB::table ( 'comments' )
        ->where ( 'id', '=', $commentId )
        ->delete ();
        DB::commit ();
    }
    
    /**
     * comments検索用
     * @param int $commentId コメントID
     */
    public function findByCommentId($articleId) {
        $comments = DB::table ( 'comments' )
            ->select ( 'comments.*', 'users.nickname', 'users.user_image' )
            ->leftjoin ( 'users', 'comments.user_id', '=', 'users.id' )
            ->where ( 'comments.article_id', '=', $articleId )
            ->get ();
        
        return $comments;
    }
}
