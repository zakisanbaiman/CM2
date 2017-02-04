<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	/**
	 * Message Bag
	 * @var Illuminate\Support\MessageBag
	 */
	protected $messageBag = null;

	public function __construct()
	{
		$this->messageBag = new Illuminate\Support\MessageBag();
	}

	/**
	 * NGワードをチェック
	 */
	public function checkNgWords($words)
	{
	    $ngArray = array(
	            '事故','死亡','骨折','重傷','殺害','傷害','暴力','被害者','放送事故',
	            'ポルノ','アダルト','セックス','バイブレーター','マスターベーション','オナニー','スケベ','羞恥','セクロス',
	            'エッチ','SEX','風俗','童貞','ペニス','巨乳','ロリ','触手','羞恥','ノーブラ','手ブラ',
	            'ローアングル','禁断','Tバック','グラビア','美尻','お尻','セクシー','無臭性',
	            '大麻','麻薬',
	            '基地外','糞','死ね','殺す',
	            'shit','piss','fuck','cunt','cocksucker','motherfucker','tits',
	    );
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
