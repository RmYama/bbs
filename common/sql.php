<?php

  //スレッド新規登録
  function make_thread($name, $title, $contents, $key){
  
  	  //データベース接続
	  $dbh = db_link();

	  //boardテーブルにINSERT
	  board_insert($dbh,$title);

	  //boardテーブルからidの最大取得
	  $max_id = get_board_maxId($dbh);

	  //commentテーブルにINSERT
	  comment_insert($dbh,$max_id, $name, $contents, $key);
	  
	   //データベース切断
	   db_cut($dbh);
  }

  //boardテーブルに新規追加
  function board_insert($dbh,$title){
	$strSQL = 'INSERT INTO training01.board(title)'.
	          ' VALUES ("'.$title.'")';
	$dbh->query($strSQL);
  }
  
  //boardテーブルからidの最大取得
  function get_board_maxId($dbh){
    $strSQL = 'SELECT MAX(id) as id FROM training01.board';
    $stmt = $dbh->query($strSQL);
	$result = $stmt->fetch(PDO::FETCH_BOTH);
	return $result["id"];  
  }

  //boardに登録されているデータ全取得
  function get_allData_board($dbh){
    $strSQL = 'SELECT * FROM training01.board';  
    $stmt = $dbh->query($strSQL);
	return $stmt;
  }
  
  //boardテーブルから該当のデータを取得
  function get_selectData_board($dbh,$id){
  
    $strSQL = 'SELECT * FROM training01.board
               WHERE id = '.$id;
    $stmt = $dbh->query($strSQL);
	return $stmt;
  }


  //commentテーブルに新規追加
  function comment_insert($dbh,$id,$name,$contents,$key){
    
    $strSQL = 'INSERT INTO training01.comment(board_id, name, contents, edit_key)'.
	          ' VALUES ('.$id.',"'.$name.'","'.$contents.'",'.$key.')';
    $dbh->query($strSQL);
  
  }

  //ccommentテーブルからスレッドの該当データ抽出
  function comment_selectData_board($dbh,$id){
    
    $strSQL = 'SELECT * FROM training01.comment
               WHERE board_id = '.$id;
    $stmt = $dbh->query($strSQL);
    return $stmt;
  }


?>