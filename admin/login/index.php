<?php
	session_start();
	
	//ログイン(Controller)
	 require_once("../../class.php");
	 require_once("model.php");

	//アクションの判定をする
	$getP = new getParameter();
	$action = $getP->action($_GET);

	switch($action){
		case "":
			//初期表示
			
			if(isset($_SESSION["admin"]["id"])){
				//ログインしている状態ならメニューへ
				//トップページに戻る
				$move = new pageMove();
				$move->pagename ="../index.php";
				$move->redirect();
				
			}else{
				require_once("login.php");
			}


			break;

		case "check":
			//入力チェック
			$err_chk = new userDataChk();

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
				$next = chkUser($user_name,$password);

				//次の処理判定
				switch($next){
					case "error":
						$err3 = "ユーザーID、または、パスワードが間違っています。";
						//エラー表示
						require_once("login.php");
						break;
	
					case "success":
						//前の画面に戻る
						$move = new pageMove();
						$move->pagename ="../index.php";
						$move->redirect();
						break;
				}
			}
			break;
		
		case "logout":
			 //セッション破棄
			 $delS = new adminDelSession();
			 $delS->logout();
			 //トップページに戻る
			 $move = new pageMove();
			 $move->pagename ="logout.php";
			 $move->redirect();
			 break;

		default:
			echo "actionの異常エラー";
			break;
	}



?>
