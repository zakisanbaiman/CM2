<?php
class ManageController extends BaseController
{

	public function getManage() {
		$manage = Manage::all();
		return View::make('manage.index')
			->with('manage',$manage);
	}

	// manage list
	public function getManageList() {
		$manage = Manage::all();
		return View::make('manage.list')
			->with('manage',$manage);
	}

	public function getManageObj() {
		$manage = Manage::all();
		return Response::json($manage);
	}

	public function updateManageObj() {
		Manage::where('id', Input::get('id'))
			->update(array(
				'model_name' => Input::get('model_name'),
				'maker' => Input::get('maker'),
				'size' => Input::get('size'),
				'color' => Input::get('color'),
				'buy_date' => Input::get('buy_date'),
				'etc' => Input::get('etc'),
			));
	}

	public function deleteManageObj() {
		Manage::where('id', Input::get('id'))->delete();
	}

	public function insertManageObj() {
		Manage::insert(array());
	}

	// 画像
	public function updateModelImage() {
		$image = Input::file('model_image');
		Log::debug($image);
	}

}