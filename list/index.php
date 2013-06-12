<?php
	session_start();

	//一覧表示画面(Controller)
	require_once("../class.php");
	require_once("model.php");
	
	//ログイン状態の確認
	$login = new loginState;
	$state = $login->state();

	if($state == "true"){
		//ニックネーム取得
		$nickname = $_SESSION["users"]["nickname"];
	}

	//アクションの判定をする
	$getA = new getAction;
	$action = $getA->action($_GET);
	
	switch($action){
		case "list":
			//初期表示
			if(array_key_exists("no",$_GET)){
				$_SESSION["join"]["no"] = $_GET["no"];
			}else{
				exit("エラー");
			}
			
			//データ取得して画面出力
			getListData();
			break;

		case "check":
			//プレビュー保持
			if(isset($_POST["preview"])){
				$preview = "checked";
			}

			//入力チェック
			$err_chk = new entryDataChk;
			
			//プロパティに値を代入
			$err_chk->comment = $_POST["comment"];
			
			//メソッドを実行して値を取得
			$err1 = $err_chk->chkComment();
			
			if($err1 != ""){
				//データ取得して画面出力
				getListData();
			}else{
				//セッションに値を保存
				$_SESSION["join"]["comment"] = $_POST["comment"];
				
				//プレビュー判定
				if($preview == "checked"){
					
					//プレビューもセッションに保持
					$_SESSION["join"]["preview"] = $preview;

					//確認画面表示
					nextPage("confirm.php");
				}else{
					//データベース登録
					make_res();
					//完了画面
					nextPage("end.php");
					
					//投稿系のセッション破棄
					if(isset($_SESSION['join'])){
						unset($_SESSION['join']);
					}
				}
			}
			break;

		case "back":
			//確認画面から戻ってきた時
			//セッションから値を取得して変数に代入
			$comment = $_SESSION["join"]["comment"];
			$preview = $_SESSION["join"]["preview"];

			//データ取得して画面出力
			getListData();
			break;

		case "entry":
			//データベースに登録
			make_res();

			//完了画面
			nextPage("end.php");

			//投稿系のセッション破棄
			if(isset($_SESSION['join'])){
				unset($_SESSION['join']);
			}

			break;

		case "edit":
			//編集・削除
			if(array_key_exists("no",$_GET)){
				$_SESSION["join"]["res_no"] = $_GET["no"];
			}else{
				exit("編集・削除エラー");
			}
			
			//データベースクラスのインスタンス化
			$db = new dbAccess;
			
			
			
			
			//編集・削除画面表示
			require_once("edit.php");
			break;

		default:
			echo "actionの異常エラー";
			break;
	}


	//データ取得して画面出力
	function getListData(){

		//データベースクラスのインスタンス化
		$db = new dbAccess;
		
		$no = $_SESSION["join"]["no"];
		
		$result = make_list($db,$no);

		$flg = $result["flg"];
		$title = $result["title"];

		require_once("list.php");

		//データベース切断
		$db->db_cut();	
	}

	//リダイレクト
	function nextPage($pagename){

		//classインスタンス化
		$move = new pageMove;
		$move->pagename = $pagename;
		$move->redirect();

	}

?>