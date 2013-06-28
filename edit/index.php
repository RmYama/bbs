<?php
	session_start();

	//一覧表示画面(Controller)
	require_once("../class.php");
	require_once("model.php");
	
	//ログイン状態の確認
	$login = new loginState();
	$state = $login->state();

	if($state == "true"){
		//idとニックネーム取得
		$user_id = $_SESSION["users"]["user_id"];
		$nickname = $_SESSION["users"]["nickname"];
	}

	//アクションの判定をする
	$getP = new getParameter();
	$action = $getP->action($_GET);
	
	switch($action){
		case "edit":
			//編集・削除
			if(array_key_exists("no",$_GET)){
				$_SESSION["join"]["res_id"] = $_GET["no"];
				$res_id = $_GET["no"];

			}else{
				exit("編集・削除エラー");
			}
			
			//データベースクラスのインスタンス化
			$db = new dbAccess();
			
			//スレッド修正の場合はタイトル取得。
			if($res_id == 0){
				$title = getThreadTitle($db);
				$_SESSION["join"]["title"] = $title;
			}else{
				$_SESSION["join"]["title"] = "";
			}
			
			//本文取得
			$result = getRes($db);
			
			$comment = $result["comment"];
			$image_file_t = $result["image_file_t"];
			$image_file_o = $result["image_file_o"];
			
			//セッションに保持
			$_SESSION["join"]["comment"] = $comment;
			$_SESSION["join"]["thumbnail"] = $image_file_t;
			$_SESSION["join"]["original"] = $image_file_o;
			$_SESSION["join"]["old_thumbnail"] = $image_file_t;
			$_SESSION["join"]["old_original"] = $image_file_o;
			
			//データベース切断
			$db->db_cut($db);
			
			//編集・削除画面表示
			require_once("edit.php");
			break;
			
		case "check":

			//値の取得
			$comment = $_POST["comment"];
			$_SESSION["join"]["comment"] = $comment;

			if(isset($_POST["title"])){
				$title = $_POST["title"];
				$_SESSION["join"]["title"] = $title;
			}

			if(isset($_POST["preview"])){
				$preview = "checked";
				$_SESSION["join"]["preview"] = $preview;
			}else{
				$preview = "";
			}
			
			//入力チェック
			$err_flg = 0;
			$err_chk = new entryDataChk();

			//プロパティに値を代入
			$err_chk->comment = $comment;
			
			//メソッドを実行して値を取得
			$err1 = $err_chk->chkComment();

			if($err1 != ""){
				$err_flg += 1;
			}

			//画像のアップロード判定
			if(is_uploaded_file($_FILES["image_file"]["tmp_name"])){

				$err_chk->upfile = $_FILES;
				$err2 = $err_chk->chkUploadFile();

				//エラーがない場合ファイルを保管
				if($err2 == ""){
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
			
			if($err1 != ""){
				//値をフォームに戻す
				 $res_id  = $_SESSION["join"]["res_id"];

				//エラー表示
				require_once("edit.php");

			}else{
			
				//プレビュー判定
				if($preview == "checked"){
					//確認画面表示
					nextPage("confirm.php");
				}else{
					//データベース修正
					updateRes();
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
			//セッションから値取得
			$res_id = $_SESSION["join"]["res_id"];
			$title = $_SESSION["join"]["title"];
			$comment = $_SESSION["join"]["comment"];
			
			if(isset($_SESSION["join"]["preview"])){
				$preview = $_SESSION["join"]["preview"];
			}
			
			$thumbnail = $_SESSION["join"]["thumbnail"];
			$original = $_SESSION["join"]["original"];
			$old_thumbnail = $_SESSION["join"]["old_thumbnail"];
			$old_original = $_SESSION["join"]["old_original"];

			if(($old_thumbnail === $thumbnail) && ($old_original === $original)){
				$image_file_t = "none";
				$del_flg = true;
			}else{
				$up_img = new uploadImgFile();
				$del_flg = $up_img->fileDelete($original,$thumbnail);
			}

			if($del_flg == true){
				$_SESSION["join"]["thumbnail"] = "none";
				$_SESSION["join"]["original"] = "none";
			}

			require_once("edit.php");
			break;


		case "back":
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

			if(isset($_SESSION['join']['thumbnail']) && $_SESSION['join']['thumbnail'] != "none"){
				$image_file_t = $_SESSION['join']['thumbnail'];
			}
			
			require_once("edit.php");

			break;

		case "update":
			//修正
			updateRes();

			//投稿系のセッション破棄
			$delS = new delSession();
			$delS->entry();
			
			//完了画面
			nextPage("end.php");

			break;

		case "delCheck":
			//値の取得
			$_SESSION["join"]["comment"] = $_POST["comment"];

			if(isset($_POST["title"])){
				$_SESSION["join"]["title"] = $_POST["title"];
			}

			//確認画面表示
			nextPage("confirm.php?action=del");
			break;

		case "delete":
			//削除
			deleteData();

			//投稿系のセッション破棄
			$delS = new delSession();
			$delS->entry();
			
			//完了画面へ移動
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