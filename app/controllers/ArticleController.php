<?php

use app\lib\image\Upload;
use Cartalyst\Sentry\Users\Eloquent\User;
use Symfony\Component\Translation\Tests\String;

class ArticleController extends BaseController
{

	public function getArticle() {

		//$articles = DB::table('articles');

		//$articles = DB::table('articles')->paginate(3);

		return View::make('frontend.article.index');
		//return View::make('article.index')->with('articles', $articles);
	}

	public function getArticleObj() {
		/*
		$article = DB::table('articles')
		->select(DB::raw('*'))
		->orderBy('created_at', 'desc')
		//->take(3)
		->get();
		*/
		
		//select @i:=@i+1 as rownum,user_id from (select @i:=0) as dummy,user;
		$article = DB::table('articles')
			->select(DB::raw('*'))
			->orderBy('created_at', 'desc')
			//->take(3)
			->get();
		
		return Response::json($article);
	}
	
	public function getArticleAppendObj() {
		$index = Input::get('index');
		
		//if ( $a !== null ){
			$index = $index + 2;
		//}else{
		//	$a = 3;
		//}
	
		$article = DB::table('articles')
		->select(DB::raw('*'))
		->orderBy('created_at', 'desc')
		->take($index)
		->get();
		return Response::json($article);
	}

	public function setArticleObj()	{

		$submit_text = $_POST["submit_text"];

		DB::beginTransaction();
			$article = new article;
			$article->article=$submit_text;
			$article->save();
		DB::commit();

		$this->getArticle();
	}

	public function loadmore() {
		//PDOでDB接続
		$dsn = 'mysql:dbname=cm;host=localhost';
		$user = 'homestead';
		$password = 'suzaki';
		global $pdo;
		$pdo = new PDO($dsn, $user, $password);

		//SQLを作成し実行
		$sql = "select * from articles limit " . $_POST['index'] . ", 1";
		$st = $pdo->prepare($sql);
		$st->execute();
		$row = $st->fetch(PDO::FETCH_ASSOC);

		//結果行が取得できたらliタグに埋め込んで表示
		if($row){
		?>
		<p class="box-p">@{{ row.user_id }}</p>
		<p class="article-box">@{{ row.article }}</p>
		<p class="article-box">いいね！@{{ row.like }}人</p>
		<p class="article-box">いいね！@{{ row.like }}人</p>
		<p class="box-p">
		<a class="btn btn-default" ng-click="openArticleDetail(article.id)">いいね！</a>
		<a class="btn btn-default" ng-click="openUpdateArticleDialog(article.id)">コメントする</a>
		<a class="btn btn-default" ng-click="openDeleteArticleDialog(article.id)">シェアする</a>
		<?php
		}
	}
}
?>
