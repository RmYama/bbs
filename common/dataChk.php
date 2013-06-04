<?php

  //必須入力 
  function required($val){
	
	$chk_flg = true;

	if(empty($val)){
	  $chk_flg = false;
	}

	return $chk_flg;

  }
  
  //文字数チェック
  function strNumChk($key){

	$chk_flg = true;
	
    $cnt = strlen($key);
    if(($cnt>=4 && $cnt<=8) == False){
	  $chk_flg = false;
    }
	
	return $chk_flg;

  }