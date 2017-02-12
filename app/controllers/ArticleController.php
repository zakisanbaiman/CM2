<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
// use Request;

class ArticleController extends BaseController {
    
    /** 取得開始行 */
    const SKIP_DEFAULT = 0;
    /** 取得行数 */
    const TAKE_DEFAULT = 10;
    
    public function getArticle() {
        return View::make ( 'frontend.article.index' );
    }
    public function getTimeLine() {
        return View::make ( 'frontend.article.index' );
    }
    public function getSettingProfile() {
        return View::make ( 'frontend.article.setting-profile' );
    }
    public function getSearchFriends() {
        return View::make ( 'frontend.article.search-friends' );
    }

    // 初期表示分の記事を取得
    public function getArticleObj() {
        $user_id = Sentry::getUser()->id;

        // articlesを取得
        $articlesRepository = new ArticlesRepository();
        $articles = $articlesRepository->findByUserId ( $user_id, self::SKIP_DEFAULT, self::TAKE_DEFAULT );

        return Response::json ( $articles );
    }

    // いいね件数取得
    public function getCountLikes($article_id) {
        $like_count = DB::table ( 'like' )->select ( DB::raw ( 'count(*) as like_count' ) )->where ( 'article_id', '=', $article_id )->groupBy ( 'like_count' )->get ();

        return Response::json ( $like_count );
    }

    // 無限スクロール　リスト追加用
    public function getArticleAppendObj() {
        $skip = Input::get('skip');
        $user_id = Sentry::getUser()->id;

        // ページに追加するarticlesを取得
        $articlesRepository = new ArticlesRepository;
        $articles = $articlesRepository->findByUserId ( $user_id, $skip, self::TAKE_DEFAULT );
            
        return Response::json ( $articles );
    }

    // 記事投稿機能
    public function setArticleObj() {
        $submit_text = Input::get('submit_text');
       
        // NGワードチェック
        $ngWordCheck = new NgWordCheck();
        $response = $ngWordCheck->checkNgWords($submit_text);
        if ($response['status'] == $ngWordCheck::FAILD_CODE) {
            return $response;
        }
        
        $user_id = Sentry::getUser()->id;

        // 記事登録処理
        $articlesRepository = new ArticlesRepository();
        $articlesRepository->insertForSubmit($submit_text, $user_id);

        $this->getArticle ();
    }

    // いいねボタン押下時
    public function setLikeObj() {
        $article_id = Input::get('article_id');
        $user_id = Sentry::getUser()->id;
        $take = Input::get('take');

        // すでに同じ記事およびコメントに対していいねを押していないか検索
        $count_like = DB::table ( 'likes' )->select ( DB::raw ( 'count(*) as like_count' ) )->where ( 'user_id', '=', $user_id )->where ( 'article_id', '=', $article_id )->get ();

        DB::beginTransaction ();
        $likesRepository = new LikesRepository();
        $articlesRepository = new ArticlesRepository();
        
        if ($count_like [0]->like_count == 0) {
            // いいね未実行の場合、likesテーブルに登録
            $likesRepository->insertForArticles($user_id, $article_id);

            // articlesテーブルのlike（いいね件数）をインクリメント
            $articlesRepository->incrementLikes($article_id);
        } else {
            // いいね済みの場合、likesテーブルから削除
            $likesRepository->deleteFotArticles($user_id, $article_id);

            // articlesテーブルのlike（いいね件数）をデクリメント
            $articlesRepository->decrementLikes($article_id);
        }

        DB::commit ();

        // 最新のarticlesを再取得
        $articlesRepository = new ArticlesRepository;
        $articles = $articlesRepository->findByUserId ( $user_id, self::SKIP_DEFAULT, $take );

        return Response::json ( $articles );
    }
    
    /**
     * 初期表示時フレンド取得用SQL
     *
     * @return 取得結果
     */
    public function getFriendObj() {
        
        // ログインセッションからユーザIDを取得
        $user_id = Sentry::getUser()->id;
        $submit_text = '';
        
        $friendsRepository = new FriendsRepository;
        $users = $friendsRepository->findByUserIdWithSubmitText($user_id,$submit_text);
        
        return Response::json ( $users );
    }
    
    /**
     * 検索時フレンド取得用SQL
     *
     * @return 取得結果
     */
    public function getSearchFriendObj() {
        
        // ログインセッションからユーザIDを取得
        $user_id = Sentry::getUser()->id;
        $submit_text = Input::get('submit_text');
        
        $friendsRepository = new FriendsRepository;
        $users = $friendsRepository->findByUserIdWithSubmitText($user_id,$submit_text);
        
        return Response::json ( $users );
    }
        
    /**
     * フレンド申請、リクエスト承認処理
     *
     * @return 取得結果
     */
    public function setFriendRequestObj() {
        $user_id = Sentry::getUser()->id;
        $friend_id = Input::get('friend_id');
        
        // friendsテーブルに登録
        $friendsRepository = new FriendsRepository;
        $friendsRepository->insertFotRequest($user_id, $friend_id);
    }
    
    /**
     * リクエスト取消、フレンド解消処理
     */
    public function cancelRequest() {
        $user_id = Sentry::getUser()->id;
        $friend_id = Input::get('friend_id');
    
        // 対象のfriendsテーブルを削除
        $friendsRepository = new FriendsRepository;
        $friendsRepository->deleteByUserIdWithFriendId($user_id, $friend_id);
    }
    
    /**
     * コメント追加処理
     */
    public function setCommentObj() {
        $user_id = Sentry::getUser()->id;
        $submit_text = Input::get('submit_text');
        $article_id = Input::get('article_id');
        
        // NGワードチェック
        $ngWordCheck = new NgWordCheck();
        $response = $ngWordCheck->checkNgWords($submit_text);
        if ($response['status'] == $ngWordCheck::FAILD_CODE) {
            return $response;
        }
        
        // commentsテーブルに登録
        $commentsRepository = new CommentsRepository;
        $commentsRepository->insertByUserIdWithArticleId($article_id, $submit_text, $user_id);
    }
    
    /**
     * 記事更新処理
     */
    public function updateArticle() {
        $submit_text = Input::get('submit_text');
        $article_id = Input::get('article_id');
    
        // NGワードチェック
        $ngWordCheck = new NgWordCheck();
        $response = $ngWordCheck->checkNgWords($submit_text);
        if ($response['status'] == $ngWordCheck::FAILD_CODE) {
            return $response;
        }
        
        // 対象のarticlesテーブルを更新
        $articlesRepository = new ArticlesRepository;
        $articlesRepository->updateArticle($article_id, $submit_text);
    }
    
    /**
     * 記事削除処理
     */
    public function deleteArticle() {
        $article_id = Input::get('article_id');
    
        // 対象のarticlesテーブルを削除
        $articlesRepository = new ArticlesRepository;
        $articlesRepository->deleteByKey($article_id);
    }
    
    /**
     * 記事修正画面呼出時
     */
    public function getArticleOneObj() {
        $article = Article::where('id', '=', Input::get('id'))->get();
        return Response::json($article);
    }
}

