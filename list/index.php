<?php
	session_start();

	//一覧表示画面(Controller)
	require_once("../class.php");
	require_once("model.php");
	
	//ログイン状態の確認
	$login = new loginState;
	$state = $login->state();

	if($state == "true"){
		//idとニックネーム取得
		$user_id = $_SESSION["users"]["user_id"];
		$nickname = $_SESSION["users"]["nickname"];
	}

	//アクションの判定をする
	$getP = new getParameter;
	$action = $getP->action($_GET);
	
	switch($action){
		case "list":
			//初期表示
			if(array_key_exists("no",$_GET)){
				$_SESSION["join"]["board_id"] = $_GET["no"];
			}else{
				exit("エラー");
			}
			
			//データ取得して画面出力
			//データベースクラスのインスタンス化
			$db = new dbAccess;
			
			$board_id = $_SESSION["join"]["board_id"];
			
			$result = makeList($db,$board_id);
	
			$flg = $result["flg"];
			$title = $result["title"];
	
			require_once("list.php");

			//データベース切断
			$db->db_cut($db);	
			break;

		case "check":

			//値の取得
			$comment = $_POST["comment"];
			if(isset($_POST["preview"])){
				$preview = "checked";
			}else{
				$preview = "";
			}

			//入力チェック
			$err1 = chkData($comment);

			if($err1 != ""){
				//データ取得して画面出力
				//データベースクラスのインスタンス化
				$db = new dbAccess;
				
				$board_id = $_SESSION["join"]["board_id"];
				
				$result = makeList($db,$board_id);
		
				$flg = $result["flg"];
				$title = $result["title"];
		
				require_once("list.php");
	
				//データベース切断
				$db->db_cut($db);	

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
					makeRes();

					//完了画面
					nextPage("end.php");

					//投稿系のセッション破棄
					$delS = new delSession;
					$delS->entry();

				}
			}
			break;

		case "back":
			//確認画面から戻ってきた時
			//セッションから値を取得して変数に代入
			$comment = $_SESSION["join"]["comment"];
			$preview = $_SESSION["join"]["preview"];

			//データ取得して画面出力
			//データベースクラスのインスタンス化
			$db = new dbAccess;
			
			$board_id = $_SESSION["join"]["board_id"];
			
			$result = makeList($db,$board_id);
	
			$flg = $result["flg"];
			$title = $result["title"];
	
			require_once("list.php");

			//データベース切断
			$db->db_cut($db);	
			break;

		case "entry":
			//データベースに登録
			makeRes();

			//完了画面
			nextPage("end.php");

			//投稿系のセッション破棄
			$delS = new delSession;
			$delS->entry();

			break;

		case "edit":
			//編集・削除
			if(array_key_exists("no",$_GET)){
				$_SESSION["join"]["res_id"] = $_GET["no"];
				$res_id = $_GET["no"];
			}else{
				exit("編集・削除エラー");
			}
			
			//データベースクラスのインスタンス化
			$db = new dbAccess;
			
			//スレッド修正の場合はタイトル取得。
			if($res_id == 0){
				$title = selectTitle($db);
			}
			//本文取得
			$comment = selectRes($db);
			
			//データベース切断
			$db->db_cut($db);
			
			//編集・削除画面表示
			require_once("edit.php");
			break;
			
		case "editCheck":

			//値の取得
			$comment = $_POST["comment"];

			if(isset($_POST["title"])){
				$title = $_POST["title"];
			}

			if(isset($_POST["preview"])){
				$preview = "checked";
			}else{
				$preview = "";
			}

			//入力チェック
			$err1 = chkData($comment);
			
			if($err1 != ""){
				//値をフォームに戻す
				 $res_id  = $_SESSION["join"]["res_id"];
				//エラー表示
				require_once("edit.php");

			}else{
			
				//セッションに値を保存
				$_SESSION["join"]["comment"] = $_POST["comment"];
				
				//プレビュー判定
				if($preview == "checked"){

					//セッションに保持
					if(isset($title)){
						$_SESSION["join"]["title"] = $title;
					}
					$_SESSION["join"]["preview"] = $preview;

					//確認画面表示
					nextPage("e_confirm.php");

				}else{
					//データベース修正
					updateRes();
					
					//完了画面
					nextPage("e_end.php");

					//投稿系のセッション破棄
					$delS = new delSession;
					$delS->entry();

				}
			}
			break;

		case "editBack":
			//確認画面から戻ってきた時
			//セッションから値を取得して変数に代入
			$res_id = $_SESSION["join"]["res_id"];
			
			if(isset($_SESSION["join"]["title"])){
				$title = $_SESSION["join"]["title"];
			}
			$comment = $_SESSION["join"]["comment"];
			if(isset($_SESSION["join"]["preview"])){
				$preview = $_SESSION["join"]["preview"];
			}
			require_once("edit.php");

			break;

		case "update":
			//修正
			updateRes();
			
			//完了画面
			nextPage("e_end.php");

			//投稿系のセッション破棄
			$delS = new delSession;
			$delS->entry();
			break;

		case "delCheck":
			//値の取得
			$_SESSION["join"]["comment"] = $_POST["comment"];

			if(isset($_POST["title"])){
				$_SESSION["join"]["title"] = $_POST["title"];
			}

			//確認画面表示
			nextPage("e_confirm.php?action=del");
			break;

		case "delete":
			//削除
			deleteData();
			
			//完了画面へ移動
			nextPage("e_end.php");

			//投稿系のセッション破棄
			$delS = new delSession;
			$delS->entry();
			break;

		default:
			echo "actionの異常エラー";
			break;
	}


	//入力チェック
	function chkData($comment){

		$err_chk = new entryDataChk;
		
		//プロパティに値を代入
		$err_chk->comment = $comment;
		
		//メソッドを実行して値を取得
		$err1 = $err_chk->chkComment();
		
		return $err1;
	}
	
	//リダイレクト
	function nextPage($pagename){

		//classインスタンス化
		$move = new pageMove;
		$move->pagename = $pagename;
		$move->redirect();

	}

?>