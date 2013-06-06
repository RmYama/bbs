<?php
	session_start();
	
	 //データベース
	 require_once("../common/class.php");
	 require_once("model.php");


	//アクションの判定をする
	if(array_key_exists("action", $_GET)){
		$action = $_GET["action"];
	}else{
		$action = "";
	}
	
	switch($action){
		case "":
			//初期表示
			require_once("login.php");
			break;

		case "check":
			//入力チェック
			$err_chk = new userDataChk;
			
			//プロパティに値を代入
			$err_chk->user_name = $_POST["user_name"];
			$err_chk->password = $_POST["password"];
			
			//メソッドを実行して値を取得
			$err1 = $err_chk->chkUserName();
			$err2 = $err_chk->chkPassword();
			
			if($err1 != "" || $err2 != ""){

				//フォームに値のセット
				$user_name = $_POST["user_name"];
				$password = $_POST["password"];

				//エラー表示
				require_once("login.php");
			}else{
				//ユーザーの確認
				$user_name = $_POST["user_name"];
				$password = $_POST["password"];

				$next = chk_user($user_name,$password);

				//次の処理判定
				switch($next){
					case "error":
						//フォームに値のセット
						$user_name = $_POST["user_name"];
						$password = $_POST["password"];
						$err3 = "ユーザーID、または、パスワードが間違っています。";
						//エラー表示
						require_once("login.php");
						break;
	
					case "success":
						$move = new pageMove;
						$move->pagename ="../thread/index.php";
						$move->redirect();
						break;
				}
			}
			break;

		default:
			echo "actionの異常エラー";
			break;
	}



?>
