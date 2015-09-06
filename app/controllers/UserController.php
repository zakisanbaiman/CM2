<?php
class UserController extends BaseController
{

	public function getUserList() {
		return View::make('user.list');
	}

	public function getUserListObj() {
		$UsersDetail = UsersDetail::all();
		return Response::json($UsersDetail);
	}

	public function getProfile() {
		return View::make('user.profile');
	}

	public function getProfileObj() {
		$UsersDetail = UsersDetail::where('id', '=', Input::get('id'))->get();
		return Response::json($UsersDetail);
	}

	public function updateProfileObj() {
		UsersDetail::where('id', '=', Input::get('id'))
			->update(array(
				'nickname' => Input::get('nickname'),
				'mail_adress' => Input::get('mail_adress'),
				'twitter' => Input::get('twitter'),
				'facebook' => Input::get('facebook'),
				'adress' => Input::get('adress'),
				'tel' => Input::get('tel'),
				'etc' => Input::get('etc'),
			));
	}

	public function deleteProfileObj() {
		UserDetail::where('id', '=', Input::get('id'))->delete();
	}

}