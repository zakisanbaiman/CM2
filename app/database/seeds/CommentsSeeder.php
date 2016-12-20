<?php

class CommentsSeeder extends Seeder
{
    public function run()
    {
        DB::table('comments')->truncate();

        // 1
        Comment::create(array(
                'article_id'        => '69',
                'comment'        => 'テストコメント１',
                'user_id'        => '7010',
                'like'        => '5',
                'parent_id'        => NULL,
                'created_at'        => '2015-08-04 12:58:07',
                'updated_at'        => '2015-08-04 12:58:07',
        ));
        
        // 2
        Comment::create(array(
                'article_id'        => '69',
                'comment'        => 'テストコメント２',
                'user_id'        => '7010',
                'like'        => '5',
                'parent_id'        => NULL,
                'created_at'        => '2015-08-04 12:58:07',
                'updated_at'        => '2015-08-04 12:58:08',
        ));
        
        // 3
        Comment::create(array(
                'article_id'        => '69',
                'comment'        => 'テストコメント１',
                'user_id'        => '7010',
                'like'        => '5',
                'parent_id'        => NULL,
                'created_at'        => '2015-08-04 12:58:07',
                'updated_at'        => '2015-08-04 12:58:09',
        ));
    }
}