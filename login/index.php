<?php
	session_start();
	
	//ログイン(Controller)
	 require_once("../class.php");
	 require_once("model.php");

	//アクションの判定をする
	$getA = new getAction;
	$action = $getA->action($_GET);

	switch($action){
		case "":
			//初期表示
			require_once("login.php");
			break;

		case "check":
			//入力チェック
			$err_chk = new userDataChk;

			//値を取得
			$user_name = $_POST["user_name"];
			$password = $_POST["password"];

			//プロパティに値を代入
			$err_chk->user_name = $user_name;
			$err_chk->password = $password;
			
			//メソッドを実行して値を取得
			$err1 = $err_chk->chkUserName();
			$err2 = $err_chk->chkPassword();
			
			if($err1 != "" || $err2 != ""){
				//入力エラー
				//エラー表示
				require_once("login.php");

			}else{

				//ユーザーの確認
				$next = chk_user($user_name,$password);

				//次の処理判定
				switch($next){
					case "error":
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
		
		case "logout":
			 //セッション破棄
			if(isset($_SESSION['users'])){
				unset($_SESSION['users']);
			}
			require_once("login.php");
			break;

		default:
			echo "actionの異常エラー";
			break;
	}



?>
