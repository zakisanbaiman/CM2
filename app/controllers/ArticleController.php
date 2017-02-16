<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
// use Request;

class ArticleController extends BaseController {
    
    /** 取得開始行 */
    const SKIP_DEFAULT = 0;
    /** 取得行数 */
    const TAKE_DEFAULT = 10;
    
    /**
     * 記事一覧画面に遷移
     * @return 記事画面VIEW
     */
    public function getArticle() {
        return View::make ( 'frontend.article.index' );
    }

    /**
     * フレンド検索画面に遷移
     * @return フレンド検索画面VIEW
     */
    public function getSearchFriends() {
        return View::make ( 'frontend.article.search-friends' );
    }

    /**
     * 初期表示分の記事を取得
     * @return 取得結果
     */
    public function getArticleObj() {
        $userId = Sentry::getUser()->id;

        // articlesを取得
        $articlesRepository = new ArticlesRepository();
        $articles = $articlesRepository->findByUserId ( $userId, self::SKIP_DEFAULT, self::TAKE_DEFAULT );

        return Response::json ( $articles );
    }

    /**
     * 無限スクロール　リスト追加用
     * @return スクロール分の記事
     */
    public function getArticleAppendObj() {
        $skip = Input::get('skip');
        $userId = Sentry::getUser()->id;

        // ページに追加するarticlesを取得
        $articlesRepository = new ArticlesRepository;
        $articles = $articlesRepository->findByUserId ( $userId, $skip, self::TAKE_DEFAULT );
            
        return Response::json ( $articles );
    }

    /**
     * 記事投稿機能
     * @return 実行結果
     */
    public function setArticleObj() {
        $submitText = Input::get('submitText');
       
        // NGワードチェック
        $ngWordCheck = new NgWordCheck();
        $response = $ngWordCheck->checkNgWords($submitText);
        if ($response['status'] == $ngWordCheck::FAILD_CODE) {
            return $response;
        }
        
        $userId = Sentry::getUser()->id;

        // 記事登録処理
        $articlesRepository = new ArticlesRepository();
        $articlesRepository->insertForSubmit($submitText, $userId);

        $this->getArticle ();
        
        return $response;
    }

    /**
     * いいねボタン押下時
     * @return 記事
     */
    public function setLikeObj() {
        $articleId = Input::get('articleId');
        $userId = Sentry::getUser()->id;
        $take = Input::get('take');

        // すでに同じ記事およびコメントに対していいねを押していないか検索
        $likesRepository = new LikesRepository();
        $countLikes = $likesRepository->countLikes($userId, $articleId);

        DB::beginTransaction ();
        $articlesRepository = new ArticlesRepository();
        
        if ($countLikes [0]->like_count == 0) {
            // いいね未実行の場合、likesテーブルに登録
            $likesRepository->insertForArticles($userId, $articleId);

            // articlesテーブルのlike（いいね件数）をインクリメント
            $articlesRepository->incrementLikes($articleId);
        } else {
            // いいね済みの場合、likesテーブルから削除
            $likesRepository->deleteFotArticles($userId, $articleId);

            // articlesテーブルのlike（いいね件数）をデクリメント
            $articlesRepository->decrementLikes($articleId);
        }

        DB::commit ();

        // 最新のarticlesを再取得
        $articlesRepository = new ArticlesRepository;
        $articles = $articlesRepository->findByUserId ( $userId, self::SKIP_DEFAULT, $take );

        return Response::json ( $articles );
    }
    
    /**
     * 初期表示時フレンド取得用SQL
     * @return 取得結果
     */
    public function getFriendObj() {
        
        // ログインセッションからユーザIDを取得
        $userId = Sentry::getUser()->id;
        $submitText = '';
        
        $friendsRepository = new FriendsRepository;
        $users = $friendsRepository->findByUserIdWithSubmitText($userId,$submitText);
        
        return Response::json ( $users );
    }
    
    /**
     * 検索時フレンド取得用SQL
     * @return 取得結果
     */
    public function getSearchFriendObj() {
        
        // ログインセッションからユーザIDを取得
        $userId = Sentry::getUser()->id;
        $submitText = Input::get('submitText');
        
        $friendsRepository = new FriendsRepository;
        $users = $friendsRepository->findByUserIdWithSubmitText($userId,$submitText);
        
        return Response::json ( $users );
    }
        
    /**
     * フレンド申請、リクエスト承認処理
     * @return 取得結果
     */
    public function setFriendRequestObj() {
        $userId = Sentry::getUser()->id;
        $friendId = Input::get('friendId');
        
        // friendsテーブルに登録
        $friendsRepository = new FriendsRepository;
        $friendsRepository->insertFotRequest($userId, $friendId);
    }
    
    /**
     * リクエスト取消、フレンド解消処理
     */
    public function cancelRequest() {
        $userId = Sentry::getUser()->id;
        $friendId = Input::get('friendId');
    
        // 対象のfriendsテーブルを削除
        $friendsRepository = new FriendsRepository;
        $friendsRepository->deleteByUserIdWithFriendId($userId, $friendId);
    }
    
    /**
     * コメント追加処理
     * @return 実行結果
     */
    public function setCommentObj() {
        $userId = Sentry::getUser()->id;
        $submitText = Input::get('submitText');
        $articleId = Input::get('articleId');
        
        // NGワードチェック
        $ngWordCheck = new NgWordCheck();
        $response = $ngWordCheck->checkNgWords($submitText);
        if ($response['status'] == $ngWordCheck::FAILD_CODE) {
            return $response;
        }
        
        // commentsテーブルに登録
        $commentsRepository = new CommentsRepository;
        $commentsRepository->insertByUserIdWithArticleId($articleId, $submitText, $userId);
        
        return $response;
    }
    
    /**
     * 記事更新処理
     * @return 実行結果
     */
    public function updateArticle() {
        $submitText = Input::get('submitText');
        $articleId = Input::get('articleId');
    
        // NGワードチェック
        $ngWordCheck = new NgWordCheck();
        $response = $ngWordCheck->checkNgWords($submitText);
        if ($response['status'] == $ngWordCheck::FAILD_CODE) {
            return $response;
        }
        
        // 対象のarticlesテーブルを更新
        $articlesRepository = new ArticlesRepository;
        $articlesRepository->updateArticle($articleId, $submitText);
        
        return $response;
    }
    
    /**
     * コメント更新処理
     * @return 実行結果
     */
    public function updateComment() {
        $submitText = Input::get('submitText');
        $commentId = Input::get('commentId');
    
        // NGワードチェック
        $ngWordCheck = new NgWordCheck();
        $response = $ngWordCheck->checkNgWords($submitText);
        if ($response['status'] == $ngWordCheck::FAILD_CODE) {
            return $response;
        }
    
        // 対象のcommentsテーブルを更新
        $commentsRepository = new CommentsRepository();
        $commentsRepository->updateComment($commentId, $submitText);
    
        return $response;
    }
    
    /**
     * 記事削除処理
     */
    public function deleteArticle() {
        $articleId = Input::get('id');
    
        // 対象のarticlesテーブルを削除
        $articlesRepository = new ArticlesRepository;
        $articlesRepository->deleteByKey($articleId);
    }
    
    /**
     * コメント削除処理
     */
    public function deleteComment() {
        $commentId = Input::get('id');
    
        // 対象のcommentsテーブルを削除
        $commentsRepository = new CommentsRepository;
        $commentsRepository->deleteByKey($commentId);
    }
    
    /**
     * 記事修正画面呼出時
     */
    public function getArticleOneObj() {
        $article = Article::where('id', '=', Input::get('id'))->get();
        return Response::json($article);
    }
}

