<?php

class NgWordCheck {

    /**
     * NGワードをチェック
     */
    public function checkNgWords($words)
    {
        $ngArray = Config::get('improper.improper_words');
        $ngList = '/' . implode('|',$ngArray) . '/' ;
        $is_matched = preg_match($ngList,$words);
        $errors['status'] = '0';
        if($is_matched == '1'){
            $errors['status'] = '1';
            $errors['message'] = '不適切な表現が含まれています。';
            return $errors;
        }
        return $errors;
    }
}
