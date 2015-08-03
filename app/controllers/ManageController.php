<?php
class ManageController extends BaseController
{

	public function getManage() {
		$manage = Manage::all();
		return View::make('manage.index')
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
			));
	}


}