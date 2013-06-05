<?php

  //データベース系ファイル読込み
  require_once("common/db.php");
  require_once("common/sql.php");


  //データベース接続
  $link = db_link();

  $strSQL = '';
  $strSQL = 'SELECT * FROM board';
  $strSQL = 'ORDER BY desc';

/*
  //boardに登録されているデータ全取得
  $stmt = get_allData_board($dbh);

  //boardデータ全件出力
  while($result = $stmt->fetch(PDO::FETCH_BOTH)){
    echo '<tr>';
	echo '<td>'.$result['id'].'</td>';
	echo '<td class="title">'.$result['title'].'</td>';
	echo '<td class="btn"><input type="button" value="詳細" onClick="Detail('.$result['id'].')" /></td>';
    echo '</tr>';
  }
  echo '</table>';
 
*/
  //データベース切断
  db_cut($link);

?>
