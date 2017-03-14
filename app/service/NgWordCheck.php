<?php

class NgWordCheck {

    const SUCCESS_CODE = '0';
    const FAILD_CODE= '1';
    const IS_MATCHED= '1';
    
    /**
     * NGワードチェック
     * @param string $words チェックワード
     * @return string 実行結果
     */
    public function checkNgWords($words)
    {
        $ngArray = Config::get('improper.improper_words');
        $ngList = '/' . implode('|',$ngArray) . '/' ;
        $isMatched = preg_match($ngList,$words);
        $result['status'] = self::SUCCESS_CODE;
        if($isMatched == self::IS_MATCHED){
            $result['status'] = self::FAILD_CODE;
            $result['message'] = '不適切な表現が含まれています。';
            return $result;
        }
        return $result;
    }
}
