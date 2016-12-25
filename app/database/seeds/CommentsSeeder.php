<?php

class CommentsSeeder extends Seeder
{
    public function run()
    {
        DB::table('comments')->truncate();

        // 1
        Comment::create(array(
                'article_id'        => '69',
                'comment'        => 'テストコメント1  for 69',
                'user_id'        => '14',
                'like'        => '5',
                'parent_id'        => NULL,
                'created_at'        => '2015-08-04 12:58:07',
                'updated_at'        => '2015-08-04 12:58:07',
        ));
        	
        // 2
        Comment::create(array(
                'article_id'        => '69',
                'comment'        => 'テストコメント２  for 69',
                'user_id'        => '13',
                'like'        => '5',
                'parent_id'        => NULL,
                'created_at'        => '2015-08-04 12:58:07',
                'updated_at'        => '2015-08-04 12:58:08',
        ));
		
        // 3
        Comment::create(array(
                'article_id'        => '69',
                'comment'        => 'テストコメント3  for 69',
                'user_id'        => '12',
                'like'        => '5',
                'parent_id'        => NULL,
                'created_at'        => '2015-08-04 12:58:07',
                'updated_at'        => '2015-08-04 12:58:09',
        ));
		
        // 4
        Comment::create(array(
                'article_id'        => '68',
                'comment'        => 'テストコメント１  for 68',
                'user_id'        => '13',
                'like'        => '5',
                'parent_id'        => NULL,
                'created_at'        => '2015-08-04 12:58:07',
                'updated_at'        => '2015-08-04 12:58:10',
        ));
		
        // 5
        Comment::create(array(
                'article_id'        => '68',
                'comment'        => 'テストコメント2  for 68',
                'user_id'        => '14',
                'like'        => '5',
                'parent_id'        => NULL,
                'created_at'        => '2015-08-04 12:58:07',
                'updated_at'        => '2015-08-04 12:58:11',
        ));
		
        // 6
        Comment::create(array(
                'article_id'        => '66',
                'comment'        => 'テストコメント１ for 66',
                'user_id'        => '12',
                'like'        => '5',
                'parent_id'        => NULL,
                'created_at'        => '2015-08-04 12:58:07',
                'updated_at'        => '2015-08-04 12:58:12',
        ));
		
        // 7
        Comment::create(array(
                'article_id'        => '66',
                'comment'        => 'テストコメント2 for 66',
                'user_id'        => '13',
                'like'        => '5',
                'parent_id'        => NULL,
                'created_at'        => '2015-08-04 12:58:07',
                'updated_at'        => '2015-08-04 12:58:13',
        ));
		
        // 8
        Comment::create(array(
                'article_id'        => '66',
                'comment'        => 'テストコメント2 for 66',
                'user_id'        => '12',
                'like'        => '5',
                'parent_id'        => NULL,
                'created_at'        => '2015-08-04 12:58:07',
                'updated_at'        => '2015-08-04 12:58:14',
        ));
		
        // 9
        Comment::create(array(
                'article_id'        => '66',
                'comment'        => 'テストコメント2 for 66',
                'user_id'        => '14',
                'like'        => '5',
                'parent_id'        => NULL,
                'created_at'        => '2015-08-04 12:58:07',
                'updated_at'        => '2015-08-04 12:58:15',
        ));
		
    }
}