<?php

class OAuthLoginController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Facebookでログイン
    |--------------------------------------------------------------------------
    |
     */
    public function loginWithFacebook()
    {
        // get data from input
        $code = Input::get('code');

        // get fb service
        $fb = OAuth::consumer('Facebook');

        // if code is provided get user data
        if (!empty($code)) {

            // This was a callback request from facebook, get the token
            $token = $fb->requestAccessToken($code);

            // Send a request with it
            $result = json_decode($fb->request('/me?fields=id,name,first_name,last_name,email,photos'), true);

            if (!empty($token)){
                try {
                    // Find the user using the user id
                    $user = Sentry::findUserByLogin($result['email']);

                    // Log the user in
                    Sentry::login($user, false);

                    // 認証出来たのでリダイレクト
                    return Redirect::route('home')->with('success', 'Facebookユーザーでログインしました。');

                }
                catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e) {
                    // 制限中
                    $this->messageBag->add('all', Lang::get('auth/message.account_suspended'));
                }
                catch (Cartalyst\Sentry\Throttling\UserBannedException $e) {
                    // バン
                    $this->messageBag->add('all', Lang::get('auth/message.account_banned'));
                }
                catch (Exception $e) {
                    // 他
                    $this->messageBag->add('all', Lang::get('auth/message.login.error'));
                }
                return Redirect::back()->withInput()->withErrors($this->messageBag);
            }

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