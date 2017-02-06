<?php

class CommonCheckController extends BaseController {

    /**
     * NGワードをチェック
     */
    public function checkNgWords($words)
    {
        $ngArray = Config::get('improper.improper_words');
        $ngList = '/' . implode('|',$ngArray) . '/' ;
        $is_matched = preg_match($ngList,$words);
        $errors[0] = '0';
        if($is_matched == '1'){
            $errors[0] = '1';
            $errors[1] = '不適切な表現が含まれています。';
            return $errors;
        }
        return $errors;
    }
}
