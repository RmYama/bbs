<?php

  //データベース接続
  function db_link(){

    //データベース接続情報	
    $dsn = 'mysql:dnname=training01;host=localhost';
    $user= 'root';
    $password = 'root';

    try{
        $dbh = new PDO($dsn, $user, $password);
      }catch(PDOException $e){
        print('Error:'.$e->getMessage());
	    die();
      }
	  
	  return $dbh;
  }
  
  //データベース切断
  function db_cut($dbh){
    $dbh = null;
  }

?>