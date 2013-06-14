<?php
	session_start();
	
	//ログイン(Controller)
	 require_once("../class.php");
	 require_once("model.php");

	//アクションの判定をする
	$getP = new getParameter;
	$action = $getP->action($_GET);

	$login = new loginState;
	$state = $login->state();

	switch($action){
		case "":
			//初期表示
			require_once("signup.php");
			break;

		case "check":
			//入力チェック
			$err_chk = new userDataChk;

			//値を取得
			$user_name = $_POST["user_name"];
			$nickname = $_POST["nickname"];
			$password = $_POST["password"];

			//プロパティに値を代入
			$err_chk->user_name = $user_name;
			$err_chk->nickname = $nickname;
			$err_chk->password = $password;

			//メソッドを実行して値を取得
			$err1 = $err_chk->chkUserName();
			$err2 = $err_chk->chkNickname();
			$err3 = $err_chk->chkPassword();
			
			if($err1 != "" || $err2 != "" || $err3 != ""){
				//エラー表示
				require_once("signup.php");
			}else{

				//ユーザーの確認
				$next = chkUser($user_name,$password);

				//次の処理判定
				switch($next){
					case "error":
						$err4 = "入力されたユーザー名は、他のユーザーが既に使用しています。";
						//エラー表示
						require_once("signup.php");
						break;
	
					case "success":
						//ユーザー登録
						makeUser($user_name,$nickname,$password);

						//前の画面に戻る
						$move = new pageMove;
						$move->pagename ="end.php";
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
