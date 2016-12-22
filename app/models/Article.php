<?php

class Article extends Eloquent {
    
    protected $table = 'articles';
    
    /**
     * createメソッド実行時に、入力を許可するカラムの指定
     *
     * @var array
     */
//     protected $fillable = array('email','login_name');
    
    /**
     * createメソッド実行時に、入力を禁止するカラムの指定
     *
     * @var array
     */
    protected $guarded = array('id');
}
