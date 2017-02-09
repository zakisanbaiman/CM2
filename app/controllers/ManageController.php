<?php

use app\lib\image\Upload;
use Cartalyst\Sentry\Users\Eloquent\User;

class ManageController extends BaseController
{

	public function getManage() {
		$manages = DB::table('manages')->paginate(3);
		return View::make('manage.index')->with('manages', $manages);
	}

	// manage list
	public function getManageList() {
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
			->update([
				'model_name' => Input::get('model_name'),
				'maker' => Input::get('maker'),
				'size' => Input::get('size'),
				'color' => Input::get('color'),
				'buy_date' => Input::get('buy_date'),
				'etc' => Input::get('etc'),
			]);
			
		// タイムラインに反映
		$user_id = Sentry::getUser()->id;
		
		$users = DB::table ( 'users' )
            ->select ( 'users.nickname')
		    ->where('users.id', '=', $user_id)
		    ->get ();
		$user_nickname = $users[0]->nickname;
		
        DB::beginTransaction ();
        $article = new article ();
        $article->article = $user_nickname . 'さんがアイテムを更新しました。';
        $article->user_id = $user_id;
        $article->save ();
        DB::commit ();
	}

	public function deleteManageObj() {
		Manage::where('id', '=', Input::get('id'))->delete();
	}

	public function insertManageObj() {
		Manage::insert([]);
	}

	// 画像
	public function updateModelImage() {

		try{
			// ファイル名を生成し画像をアップロード
			$setPath = public_path('upload/');
			$file = Input::file('modelImage');

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
			Manage::where('id', '=', Input::get('id'))
				->update([
					'model_image' => $fileName,
				]);
				
			echo "";
		} catch (Exception $e) {
			echo $e->getMessage();
		}

	}

	public function getManageDetail() {
		return View::make('manage.detail');
	}

	public function getManageDetailObj() {
		$manage = Manage::where('id', '=', Input::get('id'))->get();
		return Response::json($manage);
	}

}