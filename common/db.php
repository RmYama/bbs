<?php
	
  //データベース接続
  function db_link(){

    //データベース接続情報
	$server = 'localhost';
    $user= 'root';
    $password = 'root';
	$datebase = 'training01';
	
	$link = mysqli_connect($server,$user,$password,$datebase);
	
	if(!$link){
		die("データベース接続に失敗しました。".mysqli_error());
	}
	return $link;
  }
  
  //データベース切断
  function db_cut($link){
    mysqli_close($link);
  }

?>