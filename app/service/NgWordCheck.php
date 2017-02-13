<?php

class NgWordCheck {

    const SUCCESS_CODE = '0';
    const FAILD_CODE= '1';
    
    /**
     * NGワードをチェック
     */
    public function checkNgWords($words)
    {
        $ngArray = Config::get('improper.improper_words');
        $ngList = '/' . implode('|',$ngArray) . '/' ;
        $is_matched = preg_match($ngList,$words);
        $errors['status'] = self::SUCCESS_CODE;
        if($is_matched == '1'){
            $errors['status'] = self::FAILD_CODE;
            $errors['message'] = '不適切な表現が含まれています。';
            return $errors;
        }else{
            $errors['status'] = self::SUCCESS_CODE;
        }
        return $errors;
    }
}
