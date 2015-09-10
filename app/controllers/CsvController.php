<?php

use app\lib\image\Upload;

class CsvController extends BaseController
{

	public function getCsvImport() {
		return View::make('csv.import');
	}

	public function updateCsvImage() {

		try{
			$file = Input::file('uploadCsvImage');

			$fileExtension = $file->getClientOriginalExtension();

			$upload = new Upload();
			$upload->fileCsvExtensionCheck($fileExtension);

			$filePath = $file->getRealPath();
			DB::beginTransaction();
			if (($handle = fopen($filePath, "r")) !== false) {
				while (($line = fgetcsv($handle, 1000, ",")) !== false) {
					$manage = new Manage;
					$manage->model_name= $line[0];
					$manage->maker=$line[1];
					$manage->size=$line[2];
					$manage->color=$line[3];
					$manage->buy_date=$line[4];
					$manage->etc=$line[5];
					$manage->model_image=$line[6];
					$manage->create_user_id=$line[7];
					$manage->created_at=$line[8];
					$manage->updated_at=$line[9];
					$manage->save();
				}
				DB::commit();
				fclose($handle);
			}

		} catch (Exception $e) {
			DB::rollback();
			echo $e->getMessage();
		}

	}


}