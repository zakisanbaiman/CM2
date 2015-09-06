<?php
namespace app\lib\image;

class Upload {

    public function fileExtensionCheck($fileExtension) {
        if("jpg" != $fileExtension &&
           "png" != $fileExtension){
            $error = "アップロード可能なファイルの拡張子は[jpg,png]です。";
            throw new \Exception($error);
        }
    }

}