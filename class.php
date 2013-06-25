<?php

require_once("settings.php");

class dbAccess extends PDO{

	protected $stmt = null;

	public function __construct(){

		$host = "localhost";
		$database  = "training01";
		$user = "root";
		$password = "root";
	
		//DSNセット
		$dsn = 'mysql:dbname=' . $database . ";host=" . $host;
		
		try{
			//親クラスのコンストラクタ
			parent::__construct(
				$dsn,   //DSN
				$user,  //ユーザー名
				$password,  //パスワード
				array(
					PDO::ATTR_PERSISTENT         => true,                       // 接続管理
					PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,     // エラーモード
					PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,           // フェッチモード
					PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET `utf8`", // 文字コード
				)
			);
		} catch (PDOException $e){
			die($e);
		}
	}

	//SQL文準備
	public function preparation($strSQL){
		$this->stmt = parent::prepare($strSQL);
		return $this->stmt;
	}


	//クエリ実行
	public function query($strSQL){
		$this->stmt = parent::query($strSQL);
		return $this->stmt;
	}
	
	//クエリ実行
	public function execute(){
		return $this->stmt->execute();
	}

	//件数取得
	public function rowCount(){
		return $this->stmt->rowCount();
	}
	
	//値取得
	public function fetch(){
		return $this->stmt->fetch();
	}
	
	public function fetchAll(){
		return $this->stmt->fetchAll();
	}

	//データベース切断
	public function db_cut($db){
		$this->stmt = null;
		$db = null;
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

//セッション破棄
class delSession{
	
	//ユーザー情報破棄
	public function users(){
		if(isset($_SESSION['users'])){
			unset($_SESSION['users']);
		}
	}
	
	//投稿情報破棄
	public function entry(){
		if(isset($_SESSION['join'])){
			unset($_SESSION['join']);
		}
	}

	//ログアウト時
	public function logout(){

		$this->users();
		$this->entry();
			
		$_SESSION = array();
	
		if (isset($_COOKIE["PHPSESSID"])) {
	    	setcookie("PHPSESSID", '', time() - 1800, '/');
		}
		session_destroy();	
	}
}

//アクション判定
class getParameter{
	
	public function action($get_data){

		if(array_key_exists("action",$get_data)){
			$action = $get_data["action"];
		}else{
			$action = "";
		}
		
		return $action;
	}

	public function pageNo($get_data){

		if(array_key_exists("page",$get_data)){

			$page = $get_data["page"];
			
			if (preg_match('/^[1-9][0-9]*$/', $page)) {
				$page = (int)$page;
			}else{
				$page = 1;
			}
			
		}else{
			$page = 1;
		}
		return $page;
	}


	public function backPage($get_data){

		if(array_key_exists("page",$get_data)){
			$pagename = $get_data["page"];
		}else{
			$pagename = "";
		}
		
		return $pagename;
	}
}

class changeString{
	
	public $value = "";
	
	//HTMLエンティティ
	public function entity($string){
	
		$this->value = htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
		
		return $this->value;
	}

	//HTMLエンティティデコード
	public function decode($string){

		$this->value = html_entity_decode($string, ENT_QUOTES, 'UTF-8');

		return $this->value;
	}
}

class setLayout extends changeString{
	
	protected $db;
	
	public function __construct(){
		$this->db = new dbAccess();
	}
	
	public function setHeader(){
		
		$strSQL = "SELECT tag_header FROM designsettings";
		
		$this->db->query($strSQL);
		
		$row = $this->db->fetch();
		
		$result = $row["tag_header"];

		$this->db->db_cut($this->db);

		$result = parent::decode($result);

		return $result;
	}

	public function setFooter(){
		
		$strSQL = "SELECT tag_footer FROM designsettings";
		
		$this->db->query($strSQL);
		
		$row = $this->db->fetch();
		
		$result = $row["tag_footer"];

		$this->db->db_cut($this->db);

		$result = parent::decode($result);

		return $result;
	}

	public function setSiteBgcolor(){
		
		$strSQL = "SELECT site_bgcolor FROM designsettings";
		
		$this->db->query($strSQL);
		
		$row = $this->db->fetch();
		
		$result = $row["site_bgcolor"];

		$this->db->db_cut($this->db);

		$result = parent::decode($result);

		return $result;
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
			if(preg_match("/^[a-zA-Z0-9]+$/",$this->user_name)){
				$err_msg = "";
			}else{
				$err_msg = "ユーザー名は半角英数字で入力してください。";
			}
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
		if(empty($this->nickname) || $this->nickname == ""){
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
	public $upfile;
	
	public function __construct(){
		$this->title = "";
		$this->comment = "";
		$this->image_file = "";
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
	
	public function chkUploadFile(){
		
		if($this->upfile["image_file"]["error"] == 0){
			
			//値取得
			$file_name = $this->upfile["image_file"]["name"];
			$file_size = $this->upfile["image_file"]["size"];
			
			//拡張子チェック
			$extension = pathinfo($file_name, PATHINFO_EXTENSION);
			
			if(($extension != "jpg") && ($extension != "gif")){
				$err_msg = "アップロード可能な画像ファイルは jpg または gif のみです。";
				return $err_msg;
			}
			
			//ファイルのサイズ制限チェック
			if($file_size > IMAGE_MAX_SIZE){
				$err_msg = "アップロード可能なファイルサイズを超えています。";
				return $err_msg;
			}
			
			$err_msg = "";

			return $err_msg;
		}
	}

}

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

//ページング
class paging{

	public $item_cnt;
	public $total;
	public $totalpages;
	
	public function __construct(){
		$db = new dbAccess();
		$this->getDisplayReviews($db);
		$this->getAllReviews($db);
		$this->totalpages = ceil($this->total/$this->item_cnt);
		$db->db_cut($db);
	}
	
	//1ページの表示件数取得
	protected function getDisplayReviews($db){
		
		$strSQL = "SELECT paging_cnt FROM designsettings";
		$cnt = $db->query($strSQL)->fetchColumn();
		$this->item_cnt = (int)$cnt;
	}

	//全件取得
	protected function getAllReviews($db){
		$strSQL = "SELECT COUNT(*) FROM board";
		$this->total = $db->query($strSQL)->fetchColumn();
	}
	
	//offset取得
	public function getOffset($cur_page){
	
		$cur_page = (int)$cur_page;
		
		return $this->item_cnt * ($cur_page - 1);
	}

}

//画面遷移
class pageMove{

	//プロパティを定義
	public $pagename;
	public $url;
	public $host;
	public $uri;

	public function __construct(){
		$this->pagename = "";
		$this->url = "";
//	    $this->host = $_SERVER['HTTP_HOST'];
	    $this->uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	}

	public function redirect(){
	    if(headers_sent()){
	        exit("Error: redirect: Already header has sent!");
	    }
				
		$this->url = "http://localhost$this->uri/$this->pagename";

	    header("Location: $this->url");
	    exit;
	}
}

?>