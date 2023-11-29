<?php
	require_once 'dbcon.php';
 
	if($_GET['tid'] != ""){
		$tid = $_GET['tid'];
 
		$conn->query("UPDATE `tasks` SET `stats` = '1' WHERE `tid` = $tid") or die(mysqli_errno($conn));
		header('location: todo.php');
	}
?>