<?php
	session_start();

	//スレッド新規登録処理(Controller)
	
	require_once("model.php");
	
	//アクションの判定をする
	if(array_key_exists("action", $_GET)){
		$action = $_GET["action"];
	}else{
		$action = "";
	}

	//ログイン状態の確認
	if (!isset($_SESSION['users'])) {
		$login_flg = "false";
	}else{
		$nickname = $_SESSION['users']['nickname'];
		$login_flg = "true";
	}
	
	switch($action){
		case "":
			//初期表示
			require_once("entry_form.php");
			break;
			
		case "check":
/*			require_once("../common/dataChk.php");

			//値の取得
			$nickname = $_POST["nickname"];
			$title = $_POST["title"];
			$comment = $_POST["comment"];
			if(isset($_POST["preview"])){
				$preview = "checked";
			}
			//入力チェック
			$result = inputCheck($title, $comment);

			//結果の取得
			$next = $result["flg"];
*/
			//入力チェック
			$err_chk = new entryDataChk;
			
			//プロパティに値を代入
			$err_chk->title = $_POST["title"];
			$err_chk->comment = $_POST["comment"];
			
			//メソッドを実行して値を取得
			$err1 = $err_chk->chkTitle();
			$err2 = $err_chk->chkComment();
			
			if($err1 != "" || $err2 != ""){
				//OK

			}else{

				//エラー表示
			}
/*
			//次の処理判定
			switch($next){
				case "error":
					//エラー表示
					$err_title = $result["title"];
					$err_comment = $result["comment"];
					require_once("entry_form.php");
					break;

				case "success":
					//セッションに値を保存
					$_SESSION["join"]["nickname"] = $_POST["nickname"];
					$_SESSION["join"]["title"] = $_POST["title"];
					$_SESSION["join"]["comment"] = $_POST["comment"];
					$_SESSION["join"]["preview"] = $preview;
					
					//プレビュー判定
					if(isset($_POST["preview"])){
						//確認画面表示
						redirect("confirm.php");

					}else{
						//データベース登録
						make_thread();
						//完了画面
						redirect("end.php");
					}
				break;
*/			}
			
			break;

		case "back":
			//確認画面から戻ってきた時
			//セッションから値を取得して変数に代入
				$nickname = $_SESSION["join"]["nickname"];
				$title = $_SESSION["join"]["title"];
				$comment = $_SESSION["join"]["comment"];
				$preview = $_SESSION["join"]["preview"];
			//画面表示
			require_once("entry_form.php");
			break;

		case "entry":
			//データベースに登録
			make_thread();
			//完了画面
			redirect("end.php");

			break;

		default:
			echo "actionの異常エラー";
			break;
	}

/*

	//リダイレクト関数
	function redirect($pagename) { 
	    if (headers_sent()) {
	        exit("Error: redirect: Already header has sent!");
	    }
	
	    $host  = $_SERVER['HTTP_HOST'];
	    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	    header("Location: http://$host$uri/$pagename");
	    exit;
	}
	
	//入力チェック関数
	function inputCheck($title, $comment){
		
		$result = array();
	
		$result["flg"] = "success";
	
		//タイトル
		if(required($title) == false){
			$result["title"] = "タイトルを入力してください。";
			$result["flg"] = "error";
		}else{
			$result["title"] = "";
		}
				
		//スレッド本文
		if(required($comment) == false){
			$result["comment"] = "スレッド本文を入力してください。";
			$result["flg"] = "error";
		}else{
			$result["comment"] = "";
		}
	
		return $result;
	}
*/

?>