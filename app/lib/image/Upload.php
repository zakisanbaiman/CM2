<?php
namespace app\lib\image;

class Upload {

    public function fileImgExtensionCheck($fileExtension) {
        $fileExtension = strtolower($fileExtension);

        if("jpg" != $fileExtension &&
           "png" != $fileExtension &&
           "jpeg" != $fileExtension){
            $error = "アップロード可能なファイルの拡張子は[jpg,jpeg,png]です。";
            throw new \Exception($error);
        }
    }

    public function fileCsvExtensionCheck($fileExtension) {
        $fileExtension = strtolower($fileExtension);

        if("csv" != $fileExtension) {
            $error = "アップロード可能なファイルの拡張子は[csv]です。";
            throw new \Exception($error);
        }
    }

    public function fileSizeCheck($size) {
        if(3000000 < $size) {
            $error = "アップロード可能なファイルサイズは3MB迄です。";
            throw new \Exception($error);
        }
    }



}