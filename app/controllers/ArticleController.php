<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

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
        $articles = self::getArticleList ( $userId, self::SKIP_DEFAULT, self::TAKE_DEFAULT );

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
        $articles = self::getArticleList( $userId, $skip, self::TAKE_DEFAULT );
            
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
        $articles = self::getArticleList( $userId, self::SKIP_DEFAULT, $take );

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
     * フレンド申請
     * @return 取得結果
     */
    public function setRequestFriend() {
        $userId = Sentry::getUser()->id;
        $friendId = Input::get('friendId');
        
        // friendsテーブルに登録
        $friendsRepository = new FriendsRepository;
        $friendsRepository->insertFotRequest($userId, $friendId);
        
        // リクエスト元情報取得
        $usersRepository = new UsersRepository;
        $userFrom = $usersRepository->findByUserId($userId);
        
        // リクエスト先メールアドレス取得
        $userTo = $usersRepository->findEmailByUserId($friendId);
        $email = $userTo[0]->email;
        
        // メール本文に使用するビューに渡されるデータを連想配列で定義する。
        $data = array(
            'userFrom'          => $userFrom,
            'urlSearchFriends' => 'http://cm.app/search-friends/',
        );
        
        // メール送信
        Mail::send('emails.FriendRequest', $data, function($m) use ($userFrom, $email)
        {
            $m->to($email);
            $m->subject($userFrom[0]->nickname . 'さんからフレンドリクエストが届きました！');
        });
    }
    
    /**
     * フレンド承認
     * @return 取得結果
     */
    public function setApprovalRequest() {
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
     * フレンド申請却下
     */
    public function setRejectRequest() {
        $userId = Sentry::getUser()->id;
        $friendId = Input::get('friendId');
    
        // friendsテーブルを削除
        $friendsRepository = new FriendsRepository;
        $friendsRepository->deleteByUserIdWithFriendId($friendId, $userId);
    
        // 送信元情報取得
        $usersRepository = new UsersRepository;
        $userFrom = $usersRepository->findByUserId($userId);
    
        // 送信先メールアドレス取得
        $userTo = $usersRepository->findEmailByUserId($friendId);
        $email = $userTo[0]->email;
    
        // メール本文に使用するビューに渡されるデータを連想配列で定義する。
        $data = array(
            'userFrom'          => $userFrom,
            'urlSearchFriends' => 'http://cm.app/search-friends/',
        );
    
        // メール送信
        Mail::send('emails.RejectRequest', $data, function($m) use ($userFrom, $email)
        {
            $m->to($email);
            $m->subject($userFrom[0]->nickname . 'さんからフレンドリクエストが却下されました');
        });
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
        $articlesRepository->deleteByArticleId($articleId);
    }
    
    /**
     * コメント削除処理
     */
    public function deleteComment() {
        $commentId = Input::get('id');
    
        // 対象のcommentsテーブルを削除
        $commentsRepository = new CommentsRepository;
        $commentsRepository->deleteByCommentId($commentId);
    }
    
    /**
     * 記事修正画面呼出時
     */
    public function getArticleOneObj() {
        $article = Article::where('id', '=', Input::get('id'))->get();
        return Response::json($article);
    }
    
    /**
     * 記事一覧を取得
     * @param int $userId ユーザID
     * @param int $skip 取得開始行
     * @param int $take 取得行数
     * @return 取得結果
     */
    protected function getArticleList($userId, $skip, $take) {
    
        // articlesを取得
        $articlesRepository = new ArticlesRepository();
        $articles = $articlesRepository->findByUserId ( $userId, $skip, $take );
    
        $countArticles = count ( $articles );
        for($i = 0; $i < $countArticles; $i++) {
            $articles[$i]->my_article = false;
            if ($articles[$i]->user_id == $userId) {
                $articles [$i]->my_article = true;
            }
        }
    
        $countArticles = count ( $articles );
        $commentRepository = new CommentsRepository();
    
        // 各記事にコメントを追加
        for($i = 0; $i < $countArticles; $i ++) {
    
            // コメントを取得
            $articleId = $articles [$i]->id;
            $comments = $commentRepository->findByCommentId($articleId);
    
            $countComments = count ( $comments );
            $articles [$i]->commentArray = [];
    
            // コメントを追加
            for($k = 0; $k < $countComments; $k ++) {
                if ($articles [$i]->id == $comments [$k]->article_id) {
    
                    $comments[$k]->my_comment = false;
                    if ($comments[$k]->user_id == $userId) {
                        $comments[$k]->my_comment = true;
                    }
    
                    array_push ( $articles [$i]->commentArray, $comments [$k] );
                }
            }
        }
        return $articles;
    }
    
}

