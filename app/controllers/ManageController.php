<?php

use app\lib\image\Upload;
use Cartalyst\Sentry\Users\Eloquent\User;

class ManageController extends BaseController
{

    /**
     * 構成管理画面に遷移
     * @return 構成管理画面VIEW
     */
	public function getManage() {
		$manages = DB::table('manages');
		return View::make('manage.index')->with('manages', $manages);
	}

    /**
     * 構成管理一覧画面に遷移
     * @return 構成管理一覧画面VIEW
     */
	public function getManageList() {
		return View::make('manage.list');
	}

	/**
	 * アイテムを取得
	 * @return 取得結果
	 */
	public function getManageObj() {
		
	    // ユーザID取得
	    $userId = Sentry::getUser()->id;
	    
	    // managesテーブルを検索
		$manages = self::getManageByUserId($userId);
		
		return Response::json($manages);
	}

	/**
	 * managesテーブルを検索
	 * @param int $userId ユーザID
	 * @return 取得結果
	 */
	protected function getManageByUserId($userId) {
	
	    $managesRepository = new ManagesRepository();
	    $manages = $managesRepository->findByUserId($userId);
	
	    $countManages = count ( $manages );
	    for($i = 0; $i < $countManages; $i++) {
	        $manages[$i]->my_item = false;
	        if ($manages[$i]->create_user_id == $userId) {
	            $manages [$i]->my_item = true;
	        }
	    }
	    return $manages;
	}
	
    /**
     * アイテムを取得
     * @return 取得結果
     */
	public function getManageOneObj() {
		$manage = Manage::where('id', '=', Input::get('id'))->get();
		return Response::json($manage);
	}

	/**
	 * アイテム更新
	 */
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
		$userId = Sentry::getUser()->id;
		
		$users = DB::table ( 'users' )
            ->select ( 'users.nickname')
		    ->where('users.id', '=', $userId)
		    ->get ();
		$userNickname = $users[0]->nickname;
		
		$articleRepository = new ArticlesRepository();
		$articleRepository->insertChangeItem($userId, $userNickname);
	}

	/**
	 * アイテム削除
	 */
	public function deleteManageObj() {
		Manage::where('id', '=', Input::get('id'))->delete();
	}

	/**
	 * アイテム追加
	 */
	public function insertManageObj() {
		
	    $userId = Sentry::getUser()->id;
	    
		$managesRepository = new ManagesRepository();
		$manage = $managesRepository->insertUserId($userId);
	}

	/**
	 * イメージ画像更新
	 */
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

	/**
	 * アイテム詳細を表示
	 * @return アイテム詳細VIEW
	 */
	public function getManageDetail() {
		return View::make('manage.detail');
	}
}
