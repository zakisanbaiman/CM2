<?php

class ManagesRepository {

    /**
     * managesテーブルを検索
     * @param int $userId ユーザID
     * @return 取得結果
     */
    public function findByUserId($userId) {
    
        $manages = DB::table('manages')
        ->select('*')
        ->whereIn('manages.create_user_id',
            function ($query) use ($userId) {
                $query
                ->select('friend_id')
                ->from('friends')
                ->where ( 'user_id', '=', $userId );
            })
        ->orWhere('manages.create_user_id', '=', $userId)
        ->orderBy('manages.updated_at', 'desc')
        ->get();
    
        return $manages;
    }
    
    /**
     * managesテーブルを登録
     * @param int $userId ユーザID
     */
    public function insertUserId($userId) {
    
        DB::beginTransaction ();
        $manage = new Manage();
        $manage->create_user_id = $userId;
        $manage->save ();
        DB::commit ();
    }
}
