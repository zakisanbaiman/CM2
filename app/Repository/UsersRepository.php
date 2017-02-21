<?php

class UsersRepository {

    /**
     * usersテーブルを検索
     * @param int $userId ユーザID
     */
    public function findByUserId($userId) {
    
        $users = DB::table('users')
            ->select('*')
            ->where('users.id', '=', $userId)
            ->get();
    
        return $users;
    }
    
    /**
     * usersテーブルを検索
     * @param int $userId ユーザID
     */
    public function findEmailByUserId($userId) {
    
        $users = DB::table('users')
            ->select('email')
            ->where('users.id', '=', $userId)
            ->get();
    
        return $users;
    }
}
