<?php

use app\lib\image\Upload;
use Cartalyst\Sentry\Users\Eloquent\User;

class ArticleController extends BaseController
{

	public function getArticle() {

		return View::make('frontend.article.index');
	}

}