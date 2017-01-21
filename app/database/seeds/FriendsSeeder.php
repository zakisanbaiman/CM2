<?php

class FriendsSeeder extends Seeder
{
    public function run()
    {
        DB::table('friends')->truncate();

        // 1
        Friend::create(array(
                'user_id'        => '12',
                'friend_id'        => '13',
                'approval'        => '0',
                'created_at'        => '2015-08-04 12:58:07',
                'updated_at'        => '2015-08-04 12:58:07'
        ));
        	
        // 2
        Friend::create(array(
                'user_id'        => '13',
                'friend_id'        => '12',
                'approval'        => '1',
                'created_at'        => '2015-08-04 12:58:07',
                'updated_at'        => '2015-08-04 12:58:08'
        ));
		
        // 3
        Friend::create(array(
                'user_id'        => '12',
                'friend_id'        => '14',
                'approval'        => '0',
                'created_at'        => '2015-08-04 12:58:07',
                'updated_at'        => '2015-08-04 12:58:09'
        ));
        
        // 4
        Friend::create(array(
                'user_id'        => '12',
                'friend_id'        => '15',
                'approval'        => '1',
                'created_at'        => '2015-08-04 12:58:07',
                'updated_at'        => '2015-08-04 12:58:10'
        ));
        
        // 5
        Friend::create(array(
                'user_id'        => '15',
                'friend_id'        => '12',
                'approval'        => '1',
                'created_at'        => '2015-08-04 12:58:07',
                'updated_at'        => '2015-08-04 12:58:11'
        ));
        
        // 6
        Friend::create(array(
                'user_id'        => '3',
                'friend_id'        => '15',
                'approval'        => '1',
                'created_at'        => '2015-08-04 12:58:07',
                'updated_at'        => '2015-08-04 12:58:12'
        ));
        
        // 7
        Friend::create(array(
                'user_id'        => '7',
                'friend_id'        => '15',
                'approval'        => '1',
                'created_at'        => '2015-08-04 12:58:07',
                'updated_at'        => '2015-08-04 12:58:13'
        ));
    }
}