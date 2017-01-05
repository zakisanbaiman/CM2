<?php

class FriendsSeeder extends Seeder
{
    public function run()
    {
        DB::table('friends')->truncate();

        // 1
        Friend::create(array(
                'user_request_from'        => '12',
                'user_request_to'        => '13',
                'approval'        => '0',
                'created_at'        => '2015-08-04 12:58:07',
                'updated_at'        => '2015-08-04 12:58:07'
        ));
        	
        // 2
        Friend::create(array(
                'user_request_from'        => '13',
                'user_request_to'        => '12',
                'approval'        => '1',
                'created_at'        => '2015-08-04 12:58:07',
                'updated_at'        => '2015-08-04 12:58:08'
        ));
		
        // 3
        Friend::create(array(
                'user_request_from'        => '12',
                'user_request_to'        => '14',
                'approval'        => '0',
                'created_at'        => '2015-08-04 12:58:07',
                'updated_at'        => '2015-08-04 12:58:09'
        ));
        
        // 4
        Friend::create(array(
                'user_request_from'        => '12',
                'user_request_to'        => '15',
                'approval'        => '1',
                'created_at'        => '2015-08-04 12:58:07',
                'updated_at'        => '2015-08-04 12:58:10'
        ));
    }
}