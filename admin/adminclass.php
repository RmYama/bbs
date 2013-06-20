<?php
//tag入力チェック
class tagDataChk{

	//プロパティを定義
	public $tag_header;
	public $tag_footer;

	public function __construct(){
		$this->tag_header = "";
		$this->tag_footer = "";
	}

	//メソッド定義
	//必須入力
	public function chkHeader(){
		if(empty($this->tag_header) || $this->tag_header == ""){
			$err_msg = "ヘッダーエリアしてください。";
		}else{
			$err_msg = "";
		}
		return $err_msg;
	}
	
	public function chkFooter(){
		if(empty($this->tag_footer) || $this->tag_footer == ""){
			$err_msg = "フッターエリアを入力してください。";
		}else{
			$err_msg = "";
		}
		return $err_msg;
	}
}



?>