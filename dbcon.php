<?php
	$serverName = "localhost";
	$userName = "root";
	$pswd = "";
	$dbName = "workmanagement";
	
	$conn = mysqli_connect('localhost','root','','workmanagement');
	
	if(!$conn){
		die("DB Error". mysqli_connect_error());
	}
	

?>