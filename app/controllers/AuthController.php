<?php

class AuthController extends BaseController {

    /**
     * Account login.
     *
     * @return View
     */
    public function getLogin()
    {
        // Is the user logged in?
        if (Sentry::check())
        {
            //return Redirect::route('account');
            return Redirect::route('home');
        }

        // Show the page
        return View::make('frontend.auth.login');
    }

    /**
     * Account login form processing.
     *
     * @return Redirect
     */
    public function postLogin()
    {
        // Declare the rules for the form validation
        $rules = array(
            'email'    => 'required|email',
            'password' => 'required|between:3,32',
        );

        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails())
        {
            // Ooops.. something went wrong
            return Redirect::back()->withInput()->withErrors($validator);
        }

        try
        {
            // Try to log the user in
            Sentry::authenticate(Input::only('email', 'password'), Input::get('remember-me', 0));

            // Get the page we were before
            // Don't forget to set the filters.php to store the current uri in the session as loginRedirect !!
            $redirect = Session::get('loginRedirect', 'account');

            // Unset the page we were before from the session
            Session::forget('loginRedirect');

            // Redirect to the users page
            //return Redirect::to($redirect)->with('success', Lang::get('auth/message.login.success'));
            return Redirect::route('home');

        }
        catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            $this->messageBag->add('email', Lang::get('auth/message.account_not_found'));
        }
        catch (Cartalyst\Sentry\Users\UserNotActivatedException $e)
        {
            $this->messageBag->add('email', Lang::get('auth/message.account_not_activated'));
        }
        catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e)
        {
            $this->messageBag->add('email', Lang::get('auth/message.account_suspended'));
        }
        catch (Cartalyst\Sentry\Throttling\UserBannedException $e)
        {
            $this->messageBag->add('email', Lang::get('auth/message.account_banned'));
        }

        // Ooops.. something went wrong
        return Redirect::back()->withInput()->withErrors($this->messageBag);
    }


    /**
     * Account sign up.
     *
     * @return View
     */
	public function getSignUp()
	{
		// Is the user logged in?
		if (Sentry::check())
		{
			return Redirect::route('account');
		}

		// Show the page
		return View::make('frontend.auth.signup');

	}

    /**
     * Account sign up form processing.
     *
     * @return Redirect
     */
	public function postSignUp()
	{

		$rules = array(
 				'email'             => 'required|email|unique:users',
				'email_confirm'     => 'required|email|same:email',
				'password'          => 'required|min:4',
				'password_confirm'  => 'required|min:4'
		);

		$validator = Validator::make(Input::all(), $rules);

		// バリデーシ
		if ($validator->fails())
		{
			// 失敗
            return Redirect::back()->withInput()->withErrors($validator);
		}

		// 成功
		try{
			// ユーザーの追加
			$user = Sentry::register(array(
			'email'    => Input::get('email'),
			'password' => Input::get('password'),
			));

			// 一般ユーザグループに追加
			UsersGroup::insert(array(
				'user_id'  => $user->id,
				'group_id' => '2'
			));

            // メール本文に使用するビューに渡されるデータを連想配列で定義する。
            // アクティベーションURLを生成してメール本文ビューに渡すデータに含める。
            $data = array(
                'user'          => $user,
                'activationUrl' => URL::route('activate', $user->getActivationCode()),
            );
            // activate のルートは AuthController@getActivate を使うように routes.php で定義している。
            // getActivate() は後ほど定義する。


            // アクティベーションコードをメール送信
            // Mail::send() の第1引数はメール本文に使用されるビューの名前
            Mail::send('emails.register-activate', $data, function($m) use ($user)
            {
                $m->to($user->email);
                $m->subject('ようこそ ' . $user->email);
            });

            // 登録成功したら、成功メッセージとともに登録ページに戻る。
            return Redirect::back()->with('success', Lang::get('auth/message.signup.success'));
		}

        catch (Cartalyst\Sentry\Users\UserExistsException $e)
        {
			$this->messageBag->add('all', Lang::get('auth/message.signup.error'));
		}

        // なんか問題があったのでエラーメッセージと共に戻る。
		return Redirect::back()->withInput()->withErrors($this->messageBag);
	}


    /**
     * User account activation page.
     *
     * @param  string  $actvationCode
     * @return
     */
    public function getActivate($activationCode = null)
    {
        // Is the user logged in?
        if (Sentry::check())
        {
            return Redirect::route('account');
        }

        try
        {
            // Get the user we are trying to activate
            $user = Sentry::getUserProvider()->findByActivationCode($activationCode);

            // Try to activate this user account
            if ($user->attemptActivation($activationCode))
            {
                // Redirect to the login page
                return Redirect::route('login')->with('success', Lang::get('auth/message.activate.success'));
            }

            // The activation failed.
            $error = Lang::get('auth/message.activate.error');
        }
        catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            $error = Lang::get('auth/message.activate.error');
        }

        // Ooops.. something went wrong
        return Redirect::route('login')->with('error', $error);
    }

    /**
     * Forgot password page.
     *
     * @return View
     */
    public function getForgotPassword()
    {
        // Show the page
        return View::make('frontend.auth.forgot-password');
    }

    /**
     * Forgot password form processing page.
     *
     * @return Redirect
     */
    public function postForgotPassword()
    {
        // Declare the rules for the validator
        $rules = array(
            'email' => 'required|email',
        );

        // Create a new validator instance from our dynamic rules
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails())
        {
            // Ooops.. something went wrong
            return Redirect::route('forgot-password')->withInput()->withErrors($validator);
        }

        try
        {
            // Get the user password recovery code
            $user = Sentry::getUserProvider()->findByLogin(Input::get('email'));

            // Data to be used on the email view
            $data = array(
                'user'              => $user,
                'forgotPasswordUrl' => URL::route('forgot-password-confirm', $user->getResetPasswordCode()),
            );

            // Send the activation code through email
            Mail::send('emails.forgot-password', $data, function($m) use ($user)
            {
                $m->to($user->email, $user->first_name . ' ' . $user->last_name);
                $m->subject('Account Password Recovery');
            });
        }
        catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            // Even though the email was not found, we will pretend
            // we have sent the password reset code through email,
            // this is a security measure against hackers.
        }

        //  Redirect to the forgot password
        return Redirect::route('forgot-password')->with('success', Lang::get('auth/message.forgot-password.success'));
    }

    /**
     * Forgot Password Confirmation page.
     *
     * @param  string  $passwordResetCode
     * @return View
     */
    public function getForgotPasswordConfirm($passwordResetCode = null)
    {
        try
        {
            // Find the user using the password reset code
            $user = Sentry::getUserProvider()->findByResetPasswordCode($passwordResetCode);
        }
        catch(Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            // Redirect to the forgot password page
            return Redirect::route('forgot-password')->with('error', Lang::get('auth/message.account_not_found'));
        }

        // Show the page
        return View::make('frontend.auth.forgot-password-confirm');
    }

    /**
     * Forgot Password Confirmation form processing page.
     *
     * @param  string  $passwordResetCode
     * @return Redirect
     */
    public function postForgotPasswordConfirm($passwordResetCode = null)
    {
        // Declare the rules for the form validation
        $rules = array(
            'password'         => 'required',
            'password_confirm' => 'required|same:password'
        );

        // Create a new validator instance from our dynamic rules
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails())
        {
            // Ooops.. something went wrong
            return Redirect::route('forgot-password-confirm', $passwordResetCode)->withInput()->withErrors($validator);
        }

        try
        {
            // Find the user using the password reset code
            $user = Sentry::getUserProvider()->findByResetPasswordCode($passwordResetCode);

            // Attempt to reset the user password
            if ($user->attemptResetPassword($passwordResetCode, Input::get('password')))
            {
                // Password successfully reseted
                return Redirect::route('login')->with('success', Lang::get('auth/message.forgot-password-confirm.success'));
            }
            else
            {
                // Ooops.. something went wrong
                return Redirect::route('login')->with('error', Lang::get('auth/message.forgot-password-confirm.error'));
            }
        }
        catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            // Redirect to the forgot password page
            return Redirect::route('forgot-password')->with('error', Lang::get('auth/message.account_not_found'));
        }
    }

    /**
     * Logout page.
     *
     * @return Redirect
     */
    public function getLogout()
    {
        // Log the user out
        Sentry::logout();

        // Redirect to the users page
        return Redirect::route('home')->with('success', 'You have successfully logged out!');
    }

}