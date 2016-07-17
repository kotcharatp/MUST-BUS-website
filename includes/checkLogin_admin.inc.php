<?php 
	session_start(); 
	require_once('includes/functions.inc.php'); 

	if(check_login_status() == false){
		redirect('login.php');
	}
	$uid = check_login_status(); 
	
 ?>