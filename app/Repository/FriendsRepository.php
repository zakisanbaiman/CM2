<?php

class FriendsRepository {

    /**
     * friends取得用
     * @param ユーザID
     * @param 検索文字列
     * @return 取得結果
     */
    public function findByUserIdWithSubmitText($userId,$submitText) {
                
        $users = DB::table ( 'users' )
        ->select ( 'users.id','users.first_name','users.last_name','users.nickname'
                ,'users.user_image','f1.approval as approval_1','f2.approval as approval_2'
                ,'f1.updated_at')
                ->leftjoin ( 'friends as f1', function ($join) use ($userId) {
                    $join->on ( 'users.id', '=', 'f1.friend_id' )
                    ->where ( 'f1.user_id', '=', $userId ); // f1:自分がリクエスト
                } )
                ->leftjoin ( 'friends as f2', function ($join) use ($userId) {
                    $join->on ( 'users.id', '=', 'f2.user_id' )
                    ->where ( 'f2.friend_id', '=', $userId ); // f2:自分にリクエスト
                } )
                ->where('users.id', '<>', $userId)
                ->Where(function($query) use ($submitText)
                {
                    $query->where('users.nickname', 'LIKE', '%'.$submitText.'%')
                        ->orWhere('users.first_name', 'LIKE', '%'.$submitText.'%')
                        ->orWhere('users.last_name', 'LIKE', '%'.$submitText.'%');
                })
                ->orderBy ( 'users.id', 'asc' )
                ->get ();
                
        return $users;
    }
    
    /**
     * friendsテーブルに登録
     */
    public function insertFotRequest($userId, $friendId) {
        DB::beginTransaction ();
        $friend = new friend ();
        $friend->user_id = $userId;
        $friend->friend_id = $friendId;
        $friend->approval = '1';
        $friend->save ();
        DB::commit ();
    }
    
    /**
     * friendsテーブルを削除
     */
    public function deleteByUserIdWithFriendId($userId, $friendId) {
        DB::beginTransaction ();
        DB::table ( 'friends' )
        ->where ( 'user_id', '=', $userId )
        ->where ( 'friend_id', '=', $friendId )
        ->delete ();
        DB::commit ();
    }
}
