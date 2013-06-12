<?php

//データベース接続・切断
class dbAccess{

    //データベース接続情報
	const DB_HOST = 'localhost';
	const DB_USER = 'root';
	const DB_PASSWORD = 'root';
	const DB_NAME = 'training01';

	public $link;
	public $cur_rec;

	function __construct(){
		//データベース接続
		$db_link = mysqli_connect(self::DB_HOST,self::DB_USER,self::DB_PASSWORD,self::DB_NAME);
		if(!$db_link){
			die("データベース接続に失敗しました。".mysqli_error());
		}
		
		$this->link = $db_link;
	}

	//SQLインジェクション対策
	function injection($value){
	
		$value = mysqli_real_escape_string($this->link,trim($value));
		
		return $value;
	}

	//クエリ実行
	function sql($strSQL){

		$result = mysqli_query($this->link, $strSQL);

		if(!$result){
			die("クエリ失敗".mysqli_error());
		}
		
		//SQL文判定
        if (preg_match("/^\s*(?:select|show|describe|explain)/i", $strSQL)){
			$this->cur_rec = $result;
		}
		return $result;
	}

	//値取得
	function fetch_array(){
		return mysqli_fetch_array($this->cur_rec);
	}
	
	//データベース切断
	function db_cut(){
		mysqli_close($this->link);
	}
}

//ログイン状態確認
class loginState{
	
	public function state(){
	
		if(!isset($_SESSION["users"])){
			$login_flg = "false";
		}else{
			$login_flg = "true";
		}

		return $login_flg;
	}
}

//アクション判定
class getAction{
	
	public function action($get_data){

		if(array_key_exists("action",$get_data)){
			$action = $get_data["action"];
		}else{
			$action = "";
		}
		
		return $action;
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

//画面遷移
class pageMove{

	//プロパティを定義
	public $pagename;
	
	public function __construct(){
		$this->pagename = "";
	}

	public function redirect(){
	    if(headers_sent()){
	        exit("Error: redirect: Already header has sent!");
	    }

	    $host = $_SERVER['HTTP_HOST'];
	    $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	    header("Location: http://$host$uri/$this->pagename");
	    exit;
	}
}
