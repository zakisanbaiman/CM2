<?php

class ArticlesSeeder extends Seeder
{
    public function run()
    {
        DB::table('articles')->truncate();

        // 1
        Article::create(array(
                'article'        => 'testarticle001',
                'user_id'        => '7010',
                'like'        => '5',
                'created_at'        => '2015-08-04 12:58:07',
                'updated_at'        => '2015-08-04 12:58:07',
        ));
        
        // 2
        Article::create(array(
                'article'        => 'testarticle002',
                'user_id'        => '7010',
                'like'        => '5',
                'created_at'        => '2015-08-04 12:58:07',
                'updated_at'        => '2015-08-04 12:58:08',
        ));
        
        // 3
        Article::create(array(
                'article'        => 'testarticle003',
                'user_id'        => '7010',
                'like'        => '5',
                'created_at'        => '2015-08-04 12:58:07',
                'updated_at'        => '2015-08-04 12:58:09',
        ));
        
        // 4
        Article::create(array(
                'article'        => 'testarticle004',
                'user_id'        => '7011',
                'like'        => '6',
                'created_at'        => '2015-08-04 12:58:08',
                'updated_at'        => '2015-08-04 12:58:10',
        ));
        
        // 5
        Article::create(array(
                'article'        => 'testarticle005',
                'user_id'        => '7011',
                'like'        => '6',
                'created_at'        => '2015-08-04 12:58:08',
                'updated_at'        => '2015-08-04 12:58:11',
        ));
        
        // 6
        Article::create(array(
                'article'        => 'testarticle006',
                'user_id'        => '7011',
                'like'        => '6',
                'created_at'        => '2015-08-04 12:58:08',
                'updated_at'        => '2015-08-04 12:58:12',
        ));
        
        // 7
        Article::create(array(
                'article'        => 'testarticle007',
                'user_id'        => '7012',
                'like'        => '7',
                'created_at'        => '2015-08-04 12:58:09',
                'updated_at'        => '2015-08-04 12:58:13',
        ));
        
        // 8
        Article::create(array(
                'article'        => 'testarticle008',
                'user_id'        => '7012',
                'like'        => '7',
                'created_at'        => '2015-08-04 12:58:09',
                'updated_at'        => '2015-08-04 12:58:14',
        ));
        
        // 9
        Article::create(array(
                'article'        => 'testarticle009',
                'user_id'        => '7012',
                'like'        => '7',
                'created_at'        => '2015-08-04 12:58:09',
                'updated_at'        => '2015-08-04 12:58:15',
        ));
        
        // 10
        Article::create(array(
                'article'        => 'testarticle010',
                'user_id'        => '7013',
                'like'        => '8',
                'created_at'        => '2015-08-04 12:58:10',
                'updated_at'        => '2015-08-04 12:58:16',
        ));
        
        // 11
        Article::create(array(
                'article'        => 'testarticle011',
                'user_id'        => '7011',
                'like'        => '6',
                'created_at'        => '2015-08-04 12:58:08',
                'updated_at'        => '2015-08-04 12:58:17',
        ));
        
        // 12
        Article::create(array(
                'article'        => 'testarticle012',
                'user_id'        => '7011',
                'like'        => '6',
                'created_at'        => '2015-08-04 12:58:08',
                'updated_at'        => '2015-08-04 12:58:18',
        ));
        
        // 13
        Article::create(array(
                'article'        => 'testarticle013',
                'user_id'        => '7012',
                'like'        => '7',
                'created_at'        => '2015-08-04 12:58:09',
                'updated_at'        => '2015-08-04 12:58:19',
        ));
        
        // 14
        Article::create(array(
                'article'        => 'testarticle014',
                'user_id'        => '7012',
                'like'        => '7',
                'created_at'        => '2015-08-04 12:58:09',
                'updated_at'        => '2015-08-04 12:58:20',
        ));
        
        // 15
        Article::create(array(
                'article'        => 'testarticle015',
                'user_id'        => '7012',
                'like'        => '7',
                'created_at'        => '2015-08-04 12:58:09',
                'updated_at'        => '2015-08-04 12:58:21',
        ));
        
        // 16
        Article::create(array(
                'article'        => 'testarticle016',
                'user_id'        => '7013',
                'like'        => '8',
                'created_at'        => '2015-08-04 12:58:10',
                'updated_at'        => '2015-08-04 12:58:22',
        ));
        
        // 17
        Article::create(array(
                'article'        => 'testarticle017',
                'user_id'        => '7013',
                'like'        => '8',
                'created_at'        => '2015-08-04 12:58:10',
                'updated_at'        => '2015-08-04 12:58:23',
        ));
        
        // 18
        Article::create(array(
                'article'        => 'testarticle018',
                'user_id'        => '7013',
                'like'        => '8',
                'created_at'        => '2015-08-04 12:58:10',
                'updated_at'        => '2015-08-04 12:58:24',
        ));
        
        // 19
        Article::create(array(
                'article'        => 'testarticle019',
                'user_id'        => '7014',
                'like'        => '9',
                'created_at'        => '2015-08-04 12:58:11',
                'updated_at'        => '2015-08-04 12:58:25',
        ));
        
        // 20
        Article::create(array(
                'article'        => 'testarticle020',
                'user_id'        => '7012',
                'like'        => '7',
                'created_at'        => '2015-08-04 12:58:09',
                'updated_at'        => '2015-08-04 12:58:26',
        ));
        
        // 21
        Article::create(array(
                'article'        => 'testarticle021',
                'user_id'        => '7012',
                'like'        => '7',
                'created_at'        => '2015-08-04 12:58:09',
                'updated_at'        => '2015-08-04 12:58:27',
        ));
        
        // 22
        Article::create(array(
                'article'        => 'testarticle022',
                'user_id'        => '7013',
                'like'        => '8',
                'created_at'        => '2015-08-04 12:58:10',
                'updated_at'        => '2015-08-04 12:58:28',
        ));
        
        // 23
        Article::create(array(
                'article'        => 'testarticle023',
                'user_id'        => '7013',
                'like'        => '8',
                'created_at'        => '2015-08-04 12:58:10',
                'updated_at'        => '2015-08-04 12:58:29',
        ));
        
        // 24
        Article::create(array(
                'article'        => 'testarticle024',
                'user_id'        => '7013',
                'like'        => '8',
                'created_at'        => '2015-08-04 12:58:10',
                'updated_at'        => '2015-08-04 12:58:30',
        ));
        
        // 25
        Article::create(array(
                'article'        => 'testarticle025',
                'user_id'        => '7014',
                'like'        => '9',
                'created_at'        => '2015-08-04 12:58:11',
                'updated_at'        => '2015-08-04 12:58:31',
        ));
        
        // 26
        Article::create(array(
                'article'        => 'testarticle026',
                'user_id'        => '7014',
                'like'        => '9',
                'created_at'        => '2015-08-04 12:58:11',
                'updated_at'        => '2015-08-04 12:58:32',
        ));
        
        // 27
        Article::create(array(
                'article'        => 'testarticle027',
                'user_id'        => '7014',
                'like'        => '9',
                'created_at'        => '2015-08-04 12:58:11',
                'updated_at'        => '2015-08-04 12:58:33',
        ));
        
        // 28
        Article::create(array(
                'article'        => 'testarticle028',
                'user_id'        => '7015',
                'like'        => '10',
                'created_at'        => '2015-08-04 12:58:12',
                'updated_at'        => '2015-08-04 12:58:34',
        ));
        
        // 29
        Article::create(array(
                'article'        => 'testarticle029',
                'user_id'        => '7013',
                'like'        => '8',
                'created_at'        => '2015-08-04 12:58:10',
                'updated_at'        => '2015-08-04 12:58:35',
        ));
        
        // 30
        Article::create(array(
                'article'        => 'testarticle030',
                'user_id'        => '7013',
                'like'        => '8',
                'created_at'        => '2015-08-04 12:58:10',
                'updated_at'        => '2015-08-04 12:58:36',
        ));
        
        // 31
        Article::create(array(
                'article'        => 'testarticle031',
                'user_id'        => '7014',
                'like'        => '9',
                'created_at'        => '2015-08-04 12:58:11',
                'updated_at'        => '2015-08-04 12:58:37',
        ));
        
        // 32
        Article::create(array(
                'article'        => 'testarticle032',
                'user_id'        => '7014',
                'like'        => '9',
                'created_at'        => '2015-08-04 12:58:11',
                'updated_at'        => '2015-08-04 12:58:38',
        ));
        
        // 33
        Article::create(array(
                'article'        => 'testarticle033',
                'user_id'        => '7014',
                'like'        => '9',
                'created_at'        => '2015-08-04 12:58:11',
                'updated_at'        => '2015-08-04 12:58:39',
        ));
        
        // 34
        Article::create(array(
                'article'        => 'testarticle034',
                'user_id'        => '7015',
                'like'        => '10',
                'created_at'        => '2015-08-04 12:58:12',
                'updated_at'        => '2015-08-04 12:58:40',
        ));
        
        // 35
        Article::create(array(
                'article'        => 'testarticle035',
                'user_id'        => '7015',
                'like'        => '10',
                'created_at'        => '2015-08-04 12:58:12',
                'updated_at'        => '2015-08-04 12:58:41',
        ));
        
        // 36
        Article::create(array(
                'article'        => 'testarticle036',
                'user_id'        => '7015',
                'like'        => '10',
                'created_at'        => '2015-08-04 12:58:12',
                'updated_at'        => '2015-08-04 12:58:42',
        ));
        
        // 37
        Article::create(array(
                'article'        => 'testarticle037',
                'user_id'        => '7016',
                'like'        => '11',
                'created_at'        => '2015-08-04 12:58:13',
                'updated_at'        => '2015-08-04 12:58:43',
        ));
        
        // 38
        Article::create(array(
                'article'        => 'testarticle038',
                'user_id'        => '7014',
                'like'        => '9',
                'created_at'        => '2015-08-04 12:58:11',
                'updated_at'        => '2015-08-04 12:58:44',
        ));
        
        // 39
        Article::create(array(
                'article'        => 'testarticle039',
                'user_id'        => '7014',
                'like'        => '9',
                'created_at'        => '2015-08-04 12:58:11',
                'updated_at'        => '2015-08-04 12:58:45',
        ));
        
        // 40
        Article::create(array(
                'article'        => 'testarticle040',
                'user_id'        => '7015',
                'like'        => '10',
                'created_at'        => '2015-08-04 12:58:12',
                'updated_at'        => '2015-08-04 12:58:46',
        ));
        
        // 41
        Article::create(array(
                'article'        => 'testarticle041',
                'user_id'        => '7015',
                'like'        => '10',
                'created_at'        => '2015-08-04 12:58:12',
                'updated_at'        => '2015-08-04 12:58:47',
        ));
        
        // 42
        Article::create(array(
                'article'        => 'testarticle042',
                'user_id'        => '7015',
                'like'        => '10',
                'created_at'        => '2015-08-04 12:58:12',
                'updated_at'        => '2015-08-04 12:58:48',
        ));
        
        // 43
        Article::create(array(
                'article'        => 'testarticle043',
                'user_id'        => '7016',
                'like'        => '11',
                'created_at'        => '2015-08-04 12:58:13',
                'updated_at'        => '2015-08-04 12:58:49',
        ));
        
        // 44
        Article::create(array(
                'article'        => 'testarticle044',
                'user_id'        => '7016',
                'like'        => '11',
                'created_at'        => '2015-08-04 12:58:13',
                'updated_at'        => '2015-08-04 12:58:50',
        ));
        
        // 45
        Article::create(array(
                'article'        => 'testarticle045',
                'user_id'        => '7016',
                'like'        => '11',
                'created_at'        => '2015-08-04 12:58:13',
                'updated_at'        => '2015-08-04 12:58:51',
        ));
        
        // 46
        Article::create(array(
                'article'        => 'testarticle046',
                'user_id'        => '7017',
                'like'        => '12',
                'created_at'        => '2015-08-04 12:58:14',
                'updated_at'        => '2015-08-04 12:58:52',
        ));
        
        // 47
        Article::create(array(
                'article'        => 'testarticle047',
                'user_id'        => '7015',
                'like'        => '10',
                'created_at'        => '2015-08-04 12:58:12',
                'updated_at'        => '2015-08-04 12:58:53',
        ));
        
        // 48
        Article::create(array(
                'article'        => 'testarticle048',
                'user_id'        => '7015',
                'like'        => '10',
                'created_at'        => '2015-08-04 12:58:12',
                'updated_at'        => '2015-08-04 12:58:54',
        ));
        
        // 49
        Article::create(array(
                'article'        => 'testarticle049',
                'user_id'        => '7016',
                'like'        => '11',
                'created_at'        => '2015-08-04 12:58:13',
                'updated_at'        => '2015-08-04 12:58:55',
        ));
        
        // 50
        Article::create(array(
                'article'        => 'testarticle050',
                'user_id'        => '7016',
                'like'        => '11',
                'created_at'        => '2015-08-04 12:58:13',
                'updated_at'        => '2015-08-04 12:58:56',
        ));
        
        // 51
        Article::create(array(
                'article'        => 'testarticle051',
                'user_id'        => '7016',
                'like'        => '11',
                'created_at'        => '2015-08-04 12:58:13',
                'updated_at'        => '2015-08-04 12:58:57',
        ));
        
        // 52
        Article::create(array(
                'article'        => 'testarticle052',
                'user_id'        => '7017',
                'like'        => '12',
                'created_at'        => '2015-08-04 12:58:14',
                'updated_at'        => '2015-08-04 12:58:58',
        ));
        
        // 53
        Article::create(array(
                'article'        => 'testarticle053',
                'user_id'        => '7017',
                'like'        => '12',
                'created_at'        => '2015-08-04 12:58:14',
                'updated_at'        => '2015-08-04 12:58:59',
        ));
        
        // 54
        Article::create(array(
                'article'        => 'testarticle054',
                'user_id'        => '7017',
                'like'        => '12',
                'created_at'        => '2015-08-04 12:58:14',
                'updated_at'        => '2015-08-04 12:59:00',
        ));
        
        // 55
        Article::create(array(
                'article'        => 'testarticle055',
                'user_id'        => '7018',
                'like'        => '13',
                'created_at'        => '2015-08-04 12:58:15',
                'updated_at'        => '2015-08-04 12:59:01',
        ));
        
        // 56
        Article::create(array(
                'article'        => 'testarticle056',
                'user_id'        => '7016',
                'like'        => '11',
                'created_at'        => '2015-08-04 12:58:13',
                'updated_at'        => '2015-08-04 12:59:02',
        ));
        
        // 57
        Article::create(array(
                'article'        => 'testarticle057',
                'user_id'        => '7016',
                'like'        => '11',
                'created_at'        => '2015-08-04 12:58:13',
                'updated_at'        => '2015-08-04 12:59:03',
        ));
        
        // 58
        Article::create(array(
                'article'        => 'testarticle058',
                'user_id'        => '7017',
                'like'        => '12',
                'created_at'        => '2015-08-04 12:58:14',
                'updated_at'        => '2015-08-04 12:59:04',
        ));
        
        // 59
        Article::create(array(
                'article'        => 'testarticle059',
                'user_id'        => '7017',
                'like'        => '12',
                'created_at'        => '2015-08-04 12:58:14',
                'updated_at'        => '2015-08-04 12:59:05',
        ));
        
        // 60
        Article::create(array(
                'article'        => 'testarticle060',
                'user_id'        => '7017',
                'like'        => '12',
                'created_at'        => '2015-08-04 12:58:14',
                'updated_at'        => '2015-08-04 12:59:06',
        ));
        
        // 61
        Article::create(array(
                'article'        => 'testarticle061',
                'user_id'        => '7018',
                'like'        => '13',
                'created_at'        => '2015-08-04 12:58:15',
                'updated_at'        => '2015-08-04 12:59:07',
        ));
        
        // 62
        Article::create(array(
                'article'        => 'testarticle062',
                'user_id'        => '7018',
                'like'        => '13',
                'created_at'        => '2015-08-04 12:58:15',
                'updated_at'        => '2015-08-04 12:59:08',
        ));
        
        // 63
        Article::create(array(
                'article'        => 'testarticle063',
                'user_id'        => '7018',
                'like'        => '13',
                'created_at'        => '2015-08-04 12:58:15',
                'updated_at'        => '2015-08-04 12:59:09',
        ));
        
        // 64
        Article::create(array(
                'article'        => 'testarticle064',
                'user_id'        => '7019',
                'like'        => '14',
                'created_at'        => '2015-08-04 12:58:16',
                'updated_at'        => '2015-08-04 12:59:10',
        ));
        
        // 65
        Article::create(array(
                'article'        => 'testarticle065',
                'user_id'        => '7017',
                'like'        => '12',
                'created_at'        => '2015-08-04 12:58:14',
                'updated_at'        => '2015-08-04 12:59:11',
        ));
        
        // 66
        Article::create(array(
                'article'        => 'testarticle066',
                'user_id'        => '7017',
                'like'        => '12',
                'created_at'        => '2015-08-04 12:58:14',
                'updated_at'        => '2015-08-04 12:59:12',
        ));
        
        // 67
        Article::create(array(
                'article'        => 'testarticle067',
                'user_id'        => '7018',
                'like'        => '13',
                'created_at'        => '2015-08-04 12:58:15',
                'updated_at'        => '2015-08-04 12:59:13',
        ));
        
        // 68
        Article::create(array(
                'article'        => 'testarticle068',
                'user_id'        => '7018',
                'like'        => '13',
                'created_at'        => '2015-08-04 12:58:15',
                'updated_at'        => '2015-08-04 12:59:14',
        ));
        
        // 69
        Article::create(array(
                'article'        => 'testarticle069',
                'user_id'        => '7018',
                'like'        => '14',
                'created_at'        => '2015-08-04 12:58:15',
                'updated_at'        => '2015-08-04 12:59:15',
        ));
        
    }
}