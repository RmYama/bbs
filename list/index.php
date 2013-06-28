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
		case "list":
			//初期表示
			if(array_key_exists("no",$_GET)){
				$_SESSION["join"]["board_id"] = $_GET["no"];
			}else{
				exit("エラー");
			}
			
			$board_id = $_SESSION["join"]["board_id"];

			//スレッドタイトル取得
			$db = new dbAccess();
			$title = getThreadTitle($db,$board_id);
			$flg = makeList($db,$board_id);

			//セッションに保持
			$_SESSION["join"]["title"] = $title;
	
			require_once("list.php");

			//データベース切断
			$db->db_cut($db);
			break;

		case "check":
			//セッションに値を保存
			$_SESSION["join"]["comment"] = $_POST["comment"];
			$comment = $_POST["comment"];

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
					$image_file_t = $up_img->img_path_t;
					$_SESSION["join"]["thumbnail"] = $up_img->img_path_t;
					$_SESSION["join"]["original"] = $up_img->img_path_o;

				}else{
					$err_flg += 1; 
				}
			}

			if($err_flg != 0){
				//エラー出力
				//セッションからデータ取得
				$board_id = $_SESSION["join"]["board_id"];
				$title = $_SESSION["join"]["title"];

				$db = new dbAccess();
				$flg = makeList($db,$board_id);
				
				require_once("list.php");
	
				//データベース切断
				$db->db_cut($db);	

			}else{
				
				//プレビュー判定
				if($preview == "checked"){
					
					//確認画面表示
					nextPage("confirm.php");

				}else{
					//データベース登録
					makeRes();

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
			$board_id = $_SESSION["join"]["board_id"];
			$title = $_SESSION["join"]["title"];
			$comment = $_SESSION["join"]["comment"];
			$preview = $_SESSION["join"]["preview"];

			$thumbnail = $_SESSION["join"]["thumbnail"];
			$original = $_SESSION["join"]["original"];
			
			$up_img = new uploadImgFile();
			$del_flg = $up_img->fileDelete($original,$thumbnail);

			//データ取得して画面出力
			//データベースクラスのインスタンス化
			$db = new dbAccess();
			$flg = makeList($db,$board_id);

			require_once("list.php");
			break;

		case "back":
			//確認画面から戻ってきた時
			//セッションから値を取得して変数に代入
			$board_id = $_SESSION["join"]["board_id"];
			$title = $_SESSION["join"]["title"];
			$comment = $_SESSION["join"]["comment"];
			$preview = $_SESSION["join"]["preview"];

			if(isset($_SESSION["join"]["thumbnail"]) && $_SESSION["join"]["thumbnail"] !=""){
				$image_file_t = $_SESSION["join"]["thumbnail"];
			}

			//データ取得して画面出力
			//データベースクラスのインスタンス化
			$db = new dbAccess();
			$flg = makeList($db,$board_id);
	
			require_once("list.php");

			//データベース切断
			$db->db_cut($db);
			break;

		case "entry":
			//データベースに登録
			makeRes();

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