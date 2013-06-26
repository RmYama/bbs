<?php
	session_start();

	//スレッド新規登録処理(Controller)
	require_once("../class.php");
	require_once("model.php");

	//ログイン状態の確認
	$login = new loginState();
	$state = $login->state();

	if($state == "true"){
		//ニックネームを取得
		$nickname = $_SESSION["users"]["nickname"];
	}

	//アクションの判定をする
	$getP = new getParameter();
	$action = $getP->action($_GET);

	switch($action){
		case "":
			//初期表示
			require_once("entry_form.php");
			break;
			
		case "check":
			//プレビュー保持
			if(isset($_POST["preview"])){
				$preview = "checked";
			}else{
				$preview = "";
			}

			$err_flg = 0;

			//入力チェック
			$err_chk = new entryDataChk();
			
			//プロパティに値を代入
			$err_chk->title = $_POST["title"];
			$err_chk->comment = $_POST["comment"];
			
			//メソッドを実行して値を取得
			$err1 = $err_chk->chkTitle();
			$err2 = $err_chk->chkComment();
			
			if($err1 != "" || $err2 != ""){
				$err_flg += 1;
			}
			
			//画像のアップロード判定
			if(is_uploaded_file($_FILES["image_file"]["tmp_name"])){
				$err_chk->upfile = $_FILES;
				$err3 = $err_chk->chkUploadFile();

				//エラーがない場合ファイルを保管
				if($err3 == ""){
					$up_img = new uploadImgFile();
					$up_img->upfile = $_FILES;
					$up_img->fileStorage();
					
					//画像パスを変数とセッションにセット
					$tmp_img_path_t = $up_img->img_path_t;
					$_SESSION["join"]["thumbnail"] = $up_img->img_path_t;
					$_SESSION["join"]["original"] = $up_img->img_path_o;

				}else{
					$err_flg += 1; 
				}
			}
			
			if($err_flg != 0){
				//入力エラー
				//フォームに値のセット
				$title = $_POST["title"];
				$comment = $_POST["comment"];
				
				//エラー表示
				require_once("entry_form.php");

			}else{
				
				//セッションに値を保存
				$_SESSION["join"]["title"] = $_POST["title"];
				$_SESSION["join"]["comment"] = $_POST["comment"];
				
				//プレビュー判定
				if($preview == "checked"){
					
					//プレビューもセッションに保持
					$_SESSION["join"]["preview"] = $preview;

					//確認画面表示
					nextPage("confirm.php");

				}else{

					//データベース登録
					makeThread();

					//投稿系のセッション破棄
					$delS = new delSession();
					$delS->entry();

					//完了画面
					nextPage("end.php");
				}
			}
			break;

		case "imageDel":
			//画像削除
			//セッションから画像パス取得
			$thumbnail = $_SESSION["join"]["thumbnail"];
			$original = $_SESSION["join"]["original"];
			
			$up_img = new uploadImgFile();
			$del_flg = $up_img->fileDelete($original,$thumbnail);

			require_once("entry_form.php");
			break;

		case "back":
			//確認画面から戻ってきた時
			//セッションから値を取得して変数に代入
				$title = $_SESSION["join"]["title"];
				$comment = $_SESSION["join"]["comment"];
				$preview = $_SESSION["join"]["preview"];
				if(isset($_SESSION["join"]["thumbnail"])){
					$tmp_img_path_t = $_SESSION["join"]["thumbnail"];
				}

			//画面表示
			require_once("entry_form.php");
			break;

		case "entry":
			
			//画像がセットされている場合
			if(isset($_SESSION["join"]["thumbnail"])){
				
			}

			//データベースに登録
			makeThread();
			//投稿系のセッション破棄
			$delS = new delSession();
			$delS->entry();
			//完了画面
			nextPage("end.php");
			break;

		default:
			echo "actionの異常エラー";
			break;
	}

	//リダイレクト
	function nextPage($pagename){

		//classインスタンス化
		$move = new pageMove();
		$move->pagename = $pagename;
		$move->redirect();

	}

?>