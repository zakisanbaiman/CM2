<?php

class OAuthRegisterController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Facebookで新規会員登録
    |--------------------------------------------------------------------------
    | まずはFacebookでOAuth認証させる。
    | OAuth認証に成功したら
    | アプリユーザとして登録されているか確認する。
    | アプリユーザーとして未登録ならSentryでユーザー登録する。
    |
    */
    public function registerWithFacebook()
    {
        // Facebookで認証させる
        // get data from input
        $code = Input::get('code');

        // get fb service
        $fb = OAuth::consumer('Facebook');

        // check if code is valid
        // code が有効かどうかチェックする。

        // if code is provided get user data
        // code が与えられていればユーザデータをゲットする。
        if (!empty($code)) {

            // This was a callback request from facebook, get the token
            // Facebook からのコールバックリクエストをtokenとしてゲットする。
            $token = $fb->requestAccessToken($code);

            // Send a request with it
            // Facebook上の自分の情報をjson形式でresultに代入
            $result = json_decode($fb->request('/me?fields=id,name,first_name,last_name,email,photos'), true);

            //dd($result);

            /* 既に登録済みFacebookユーザか確認する。
             * 登録済みのFacebookユーザはログインページに返す。
             * usersテーブルのoa_flagsがfacebookでoa_idが一意かをチェック
             */

            // バリデーションでチェックするには連想配列にする必要あり
            $oa_id = array('oa_id' => $result['id']);

            // バリデーションルールの指定
            // usersテーブルのoa_flagsがfacebookの行でoa_idが一意かをチェック
            $rules = array(
                'oa_id' => 'unique:users,oa_id,NULL,id,oa_flags,facebook',
            );

            // バリデーションメッセージの指定
            $messages = array(
                'unique' => 'このユーザーは既に登録されています。', // カスタムメッセージ（オリジナルだと変数名が表示されるので）
            );

            // バリデーションチェック
            $validator = Validator::make($oa_id, $rules, $messages);

            // バリデーションNGならログインページに返す。
            if ($validator->fails()) {
                return Redirect::to('auth/login')
                    //->withErrors($validator);
                    ->with('error', 'Facebookユーザーは既に登録されています。Facebookでログインしてください。');
            }

            // Sentryで$userインスタンスを作成する
            $user = Sentry::register(array(
                'activated' => 1,
                'password'  => Hash::make(uniqid(time())),
                'email'     => $result['email'],
                'oa_email'  => $result['email'],    // サービスで利用しているメールアドレスをセット
                'oa_flags'  => "facebook",          // OAフラグのセット
                'oa_id'     => $result['id'],       // サービスごとに一意の値をセット

            ));

            // グループID=2 にセットする
            $usergroup = Sentry::getGroupProvider()->findById(2);
            $user->addGroup($usergroup);

            // ログインページにリダイレクトさせる。
            return Redirect::route('login')
                ->with('success', 'Facebookユーザーで会員登録しました。Facebookでログインしてください。');
        }

        // 一番最初にアクセスした時
        else {
            // get fb authorization
            $url = $fb->getAuthorizationUri();

            // return to facebook login url
            return Redirect::to((string)$url);
        }
    }

}