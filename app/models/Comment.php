<?php

class Comment extends Eloquent {
    
    protected $table = 'comments';
    
    /**
     * createメソッド実行時に、入力を許可するカラムの指定
     *
     * @var array
     */
     // protected $fillable = array('id');
    
    /**
     * createメソッド実行時に、入力を禁止するカラムの指定
     *
     * @var array
     */
    protected $guarded = array('id');
}
