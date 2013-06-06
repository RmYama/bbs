
<?php

//画面遷移
class pageMove{

	//プロパティを定義
	public $pagename;
	
	public function __construct(){
		$this->pagename = "";
	}
	
	function redirect() { 

	    if (headers_sent()) {
	        exit("Error: redirect: Already header has sent!");
	    }

	    $host  = $_SERVER['HTTP_HOST'];
	    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	    header("Location: http://$host$uri/$this->pagename");
	    exit;
	}
}

//ユーザー情報入力チェック
class userDataChk{

	//プロパティを定義
	public $user_name;
	public $password;
	public $nickname;

	public function __construct(){
		$this->user_name = "";
		$this->password = "";
		$this->nickname = "";
	}

	//メソッド定義
	//必須入力
	public function chkUserName(){
		if(empty($this->user_name) || $this->user_name == ""){
			$err_msg = "ユーザー名を入力してください。";
		}else{
			$err_msg = "";
		}
		return $err_msg;
	}
	
	public function chkPassword(){
		if(empty($this->password) || $this->password == ""){
			$err_msg = "パスワードを入力してください。";
		}else{
			$err_msg = "";
		}
		return $err_msg;
	}
	
	public function chkNickname(){
		if(empty($this->chkNickname) || $this->chkNickname == ""){
			$err_msg = "ニックネームを入力してください。";
		}else{
			$err_msg = "";
		}
		return $err_msg;
	}
}


//スレッド,レス入力チェック
class entryDataChk{

	//プロパティを定義
	public $title;
	public $comment;

	public function __construct(){
		$this->title = "";
		$this->comment = "";
	}

	//メソッド定義
	//必須入力
	public function chkTitle(){
		if(empty($this->title) || $this->title == ""){
			$err_msg = "タイトルを入力してください。";
		}else{
			$err_msg = "";
		}
		return $err_msg;
	}
	
	public function chkComment(){
		if(empty($this->comment) || $this->comment == ""){
			$err_msg = "本文を入力してください。";
		}else{
			$err_msg = "";
		}
		return $err_msg;
	}
}