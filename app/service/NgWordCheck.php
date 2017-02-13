<?php

class NgWordCheck {

    const SUCCESS_CODE = '0';
    const FAILD_CODE= '1';
    const IS_MATCHED= '1';
    
    /**
     * NGワードをチェック
     */
    public function checkNgWords($words)
    {
        $ngArray = Config::get('improper.improper_words');
        $ngList = '/' . implode('|',$ngArray) . '/' ;
        $isMatched = preg_match($ngList,$words);
        $errors['status'] = self::SUCCESS_CODE;
        if($isMatched == self::IS_MATCHED){
            $errors['status'] = self::FAILD_CODE;
            $errors['message'] = '不適切な表現が含まれています。';
            return $errors;
        }
        return $errors;
    }
}
