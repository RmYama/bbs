<?php

	//会員一覧(model)

	//
	function makeMemberList($db){
		
		$result = array();

		$strSQL = "SELECT * FROM users order by id asc";
		
		$stmt = $db->query($strSQL);
		
		return $stmt;
		
	}

?>