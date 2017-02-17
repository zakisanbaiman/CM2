<?php

class UsersRepository {

    /**
     * usersテーブルを検索
     * @param int $friendId フレンドID
     */
    public function findByKey($userId) {
    
        $users = DB::table('users')
            ->select('*')
            ->where('users.id', '=', $userId)
            ->get();
    
        return $users;
    }
    
    /**
     * usersテーブルを検索
     * @param int $friendId フレンドID
     */
    public function findForEmail($friendId) {
    
        $users = DB::table('users')
        ->select('email')
        ->where('users.id', '=', $friendId)
        ->get();
    
        return $users;
    }
}
