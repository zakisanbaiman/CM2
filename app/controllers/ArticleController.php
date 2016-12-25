<?php

use app\lib\image\Upload;
use Cartalyst\Sentry\Users\Eloquent\User;
use Symfony\Component\Translation\Tests\String;

class ArticleController extends BaseController
{
	
	public function getArticle() {
		return View::make('frontend.article.index');
	}
	
	public function getTimeLine() {
	    return View::make('frontend.article.timeline');
	}
	
	public function getSettingProfile() {
	    return View::make('frontend.article.setting-profile');
	}
	
	//初期表示分の記事を取得
	public function getArticleObj() {
	    $user_id = Input::get('user_id');
	    
		$articles = DB::table('articles')
		    ->leftjoin('users', 'articles.user_id', '=', 'users.id')
// 		    ->leftjoin('comments', 'articles.ID', '=', 'comments.article_id')
// 		    ->leftjoin('users as u2', 'comments.user_id', '=', 'u2.id')
		    ->leftjoin('likes', function($join) use( $user_id ) 
		    {
		        $join->on('articles.ID', '=', 'likes.article_id')
		        ->where('likes.user_id', '=', $user_id);
		    })
		    ->select('articles.id', 'articles.user_id', 'articles.article', 'articles.like', 
		          'articles.created_at', 'likes.ID as likesID', 'users.user_image','users.nickname'
// 		          ,'comments.comment','u2.user_image as commenter_img', 'u2.nickname as commenter_nickname'
		          )
    		->orderBy('articles.updated_at', 'desc')
    		->take(10)
    		->get();
    		
    		$countArticles = count($articles);

//     		$articles->commentsArray = array("foo", "bar", "hello", "world");
    		for ($i = 0; $i < $countArticles; $i++) {
    		    // コメントを取得
    		    $comments = DB::table('comments')
    		    ->select('*')
//     		    ->join('articles', 'comments.article_id', '=', $articles[$i]->id)
//     		    ->where('articles.user_id', '=', $user_id)
    		    ->leftjoin('users', 'comments.user_id', '=', 'users.id')
    		    ->where('comments.article_id', '=', $articles[$i]->id)
    		    ->get();

    		    $countComments = count($comments);
    		    $articles[$i]->commentArray = array();
    		    
    		    for ($k = 0; $k < $countComments; $k++) {
        		    if ($articles[$i]->id == $comments[$k]->article_id) {
//         		        $articles[$i].push($comments[$k]);
        		        array_push($articles[$i]->commentArray, $comments[$k]);
        		    }  
    		    }
    		}
    		
		return Response::json($articles);
	}
	
	//初期表示分のコメントを取得
	public function getCommentObj() {
	    $user_id = Input::get('user_id');
	     
	    $comments = DB::table('comments')
	    ->select('*')
	    ->join('articles', 'comments.article_id', '=', 'articles.id')
	    ->where('articles.user_id', '=', $user_id)
	    ->get();

	    return Response::json($comments);
	}
	
	//いいね件数取得
	public function getCountLikes($article_id) {
		$like_count = DB::table('like')
			->select(DB::raw('count(*) as like_count'))
            ->where('article_id', '=', $article_id)
            ->groupBy('like_count')
            ->get();
		
        return Response::json($like_count);
	}
	
	//無限スクロール　リスト追加用
	public function getArticleAppendObj() {
		$skip = $_POST["skip"];
		$take = $_POST["take"];
		$user_id = $_POST["user_id"];
		
		$article = DB::table('articles')
		->join('users', 'articles.user_id', '=', 'users.id')
		->leftjoin('likes', function($join) use( $user_id )
		{
		    $join->on('articles.ID', '=', 'likes.article_id')
		    ->where('likes.user_id', '=', $user_id);
		})
		->select('articles.ID', 'articles.user_id', 'articles.article', 'articles.like', 
		          'articles.created_at', 'likes.ID as likesID', 'users.user_image')
		        ->orderBy('articles.created_at', 'desc')
		->orderBy('articles.created_at', 'desc')
		->skip($skip)
		->take($take)
		->get();
		return Response::json($article);
	}
	
	//記事投稿機能
	public function setArticleObj()	{
		$submit_text = $_POST["submit_text"];
		$user_id = $_POST["user_id"];

		DB::beginTransaction();
			$article = new article;
			$article->article=$submit_text;
			$article->user_id=$user_id;
			$article->save();
		DB::commit();

		$this->getArticle();
	}
	
	//いいねボタン押下時
	public function setLikeObj()	{
		$user_id = $_POST["user_id"];
		$article_id = $_POST["article_id"];
		
		$likes = DB::table('likes')
			->select(DB::raw('*'))
			->where('user_id', '=', $user_id)
			->where('article_id', '=', $article_id)
			->get();
		
		$count_like = count($likes); 
		$article_id = $_POST["article_id"];
		
		DB::beginTransaction();
		
		if ($count_like == 0){
		    //いいね未実行の場合
			DB::table('likes')->insert(
					array('user_id' => $user_id, 'article_id' => $article_id)
					);
			
			DB::table('articles')
				->where('ID', '=', $article_id)
				->increment('like',1);
				
		}else{
		    //いいね済みの場合
			DB::table('likes')
				->where('user_id', '=', $user_id)
				->where('article_id', '=', $article_id)
				->delete();
			
			DB::table('articles')
				->where('ID', '=', $article_id)
				->decrement('like');
		}
		
		DB::commit();
		
		$skip = $_POST["skip"];
		$take = $_POST["take"];
		$user_id = $_POST["user_id"];
		$article = DB::table('articles')
		->join('users', 'articles.user_id', '=', 'users.id')
		->leftjoin('likes', function($join) use( $user_id )
		{
		    $join->on('articles.ID', '=', 'likes.article_id')
		    ->where('likes.user_id', '=', $user_id);
		})
		->select('articles.ID', 'articles.user_id', 'articles.article', 'articles.like', 
		          'articles.created_at', 'likes.ID as likesID', 'users.user_image')
		        ->orderBy('articles.created_at', 'desc')
		        ->orderBy('articles.created_at', 'desc')
		        ->skip($skip)
		        ->take($take)
		        ->get();
	    return Response::json($article);
		        
	}
}
?>
