<?php

class FriendsRepository {

    /**
     * friends取得用
     * @param ユーザID
     * @param 検索文字列
     * @return 取得結果
     */
    public function findByUserIdWithSubmitText($user_id,$submit_text) {
                
        $users = DB::table ( 'users' )
        ->select ( 'users.id','users.first_name','users.last_name','users.nickname'
                ,'users.user_image','f1.approval as approval_1','f2.approval as approval_2'
                ,'f1.updated_at')
                ->leftjoin ( 'friends as f1', function ($join) use ($user_id) {
                    $join->on ( 'users.id', '=', 'f1.friend_id' )
                    ->where ( 'f1.user_id', '=', $user_id ); // f1:自分がリクエスト
                } )
                ->leftjoin ( 'friends as f2', function ($join) use ($user_id) {
                    $join->on ( 'users.id', '=', 'f2.user_id' )
                    ->where ( 'f2.friend_id', '=', $user_id ); // f2:自分にリクエスト
                } )
                ->where('users.id', '<>', $user_id)
                ->Where(function($query) use ($submit_text)
                {
                    $query->where('users.nickname', 'LIKE', '%'.$submit_text.'%')
                        ->orWhere('users.first_name', 'LIKE', '%'.$submit_text.'%')
                        ->orWhere('users.last_name', 'LIKE', '%'.$submit_text.'%');
                })
                ->orderBy ( 'users.id', 'asc' )
                ->get ();
                
        return $users;
    }
    
    /**
     * friendsテーブルに登録
     */
    public function insertFotRequest($user_id, $friend_id) {
        DB::beginTransaction ();
        $friend = new friend ();
        $friend->user_id = $user_id;
        $friend->friend_id = $friend_id;
        $friend->approval = '1';
        $friend->save ();
        DB::commit ();
    }
    
    /**
     * friendsテーブルを削除
     */
    public function deleteByUserIdWithFriendId($user_id, $friend_id) {
        DB::beginTransaction ();
        DB::table ( 'friends' )
        ->where ( 'user_id', '=', $user_id )
        ->where ( 'friend_id', '=', $friend_id )
        ->delete ();
        DB::commit ();
    }
}
