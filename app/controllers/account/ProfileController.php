<?php namespace Controllers\Account;

use AuthorizedController;
use Input;
use Redirect;
use Sentry;
use Validator;
use View;
use app\lib\image\Upload;
use File;
use User;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Image;

class ProfileController extends AuthorizedController {

    const USER_IMAGE_PATH = 'images/users/';
    
	/**
	 * User profile page.
	 *
	 * @return View
	 */
	public function getIndex()
	{
		// Get the user information
		$user = Sentry::getUser();

		// Show the page
		return View::make('frontend/account/profile', compact('user'));
	}

	/**
	 * User profile form processing page.
	 *
	 * @return Redirect
	 */
	public function postIndex()
	{
		// Declare the rules for the form validation
		$rules = array(
			//'first_name' => 'required|min:3',
			//'last_name'  => 'required|min:3',
			//'website'    => 'url',
			//'gravatar'   => 'email',
		);

		// Create a new validator instance from our validation rules
		$validator = Validator::make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			// Ooops.. something went wrong
			return Redirect::back()->withInput()->withErrors($validator);
		}

		// Grab the user
		$user = Sentry::getUser();
		
		$file = Input::file('image');
		if (isset($file)) {
		    
            try{
    		    // ファイル名を生成し画像をアップロード
    		    $setPath = public_path('images/users/');
    		    
    		    if(!file_exists($setPath)) {
    		        \File::makeDirectory($setPath, 0775, true);
    		    }
    		     
    		    $fileExtension = $file->getClientOriginalExtension();
    		    
    		    $upload = new Upload();
    		    // 拡張子チェック
    		    $upload->fileImgExtensionCheck($fileExtension);
    		    
    		    // サイズチェック
    		    $upload->fileSizeCheck($file->getSize());
    		    
    		    $filePath = $file->getRealPath();
    		    $fileName = $file->getClientOriginalName();
    		    
    		    // ファイルをtmpから移動
    		    File::move($filePath, $setPath . $fileName);
    		    
    		    // DB登録
    		    $user->user_image = $fileName;
    		    echo "";
            } catch (Exception $e) {
                echo $e->getMessage();
            }
    	}
		
		// Update the user information
		$user->first_name = Input::get('first_name');
		$user->last_name  = Input::get('last_name');
		$user->nickname   = Input::get('nickname');
		//$user->website    = Input::get('website');
		//$user->country    = Input::get('country');
		//$user->gravatar   = Input::get('gravatar');
		$user->save();

		// Redirect to the settings page
		return Redirect::route('profile')->with('success', 'Account successfully updated');
	}

}
