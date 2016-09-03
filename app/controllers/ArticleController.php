<?php

use app\lib\image\Upload;
use Cartalyst\Sentry\Users\Eloquent\User;
use Symfony\Component\Translation\Tests\String;

class ArticleController extends BaseController
{

	public function getArticle() {

		//$articles = DB::table('articles');
		$articles = DB::table('articles')
			->select(DB::raw('*'))
			->where('id', '>=', 120)
			->get();
		//$articles = DB::table('articles')->paginate(3);

		return View::make('frontend.article.index')->with('articles', $articles);
		//return View::make('article.index')->with('articles', $articles);
	}

	public function getArticleObj() {
		$article = Article::all();
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

	public function loadmore()	{
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

		}
	}
}