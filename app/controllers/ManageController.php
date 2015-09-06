<?php

use app\lib\image\Upload;

class ManageController extends BaseController
{

	public function getManage() {
//		$manage = Manage::all();
//		return View::make('manage.index')
//			->with('manage',$manage);
		return View::make('manage.index');
	}

	// manage list
	public function getManageList() {
//		$manage = Manage::all();
//		return View::make('manage.list')
//			->with('manage',$manage);
		return View::make('manage.list');
	}

	public function getManageObj() {
		$manage = Manage::all();
		return Response::json($manage);
	}

	public function getManageOneObj() {
		$manage = Manage::where('id', '=', Input::get('id'))->get();
		return Response::json($manage);
	}

	public function updateManageObj() {
		Manage::where('id', '=', Input::get('id'))
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
		Manage::where('id', '=', Input::get('id'))->delete();
	}

	public function insertManageObj() {
		Manage::insert(array());
	}

	// 画像
	public function updateModelImage() {

		try{
			// ファイル名を生成し画像をアップロード
			$setPath = public_path('upload/');
			$file = Input::file('modelImage');

			$fileExtension = $file->getClientOriginalExtension();

			// チェック処理
			$upload = new Upload();
			$upload->fileExtensionCheck($fileExtension);

			$filePath = $file->getRealPath();
			$fileName = $file->getClientOriginalName();
			// ファイルをtmpから移動
			File::move($filePath, $setPath . $fileName);

			// DB登録
			Manage::where('id', '=', Input::get('id'))
				->update(array(
					'model_image' => $fileName,
				));
			echo "";
		} catch (Exception $e) {
			echo $e->getMessage();
		}

	}


	public function getManageDetail() {
//		$manage = Manage::where('id', '=', Input::get('id'))->get();
//		return View::make('manage.detail')
//			->with('manage',$manage);
		return View::make('manage.detail');
	}

	public function getManageDetailObj() {
		$manage = Manage::where('id', '=', Input::get('id'))->get();
		return Response::json($manage);
	}

}