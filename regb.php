<?php 
	include_once('core.php');
	include_once('dbc.php');
	session_start();
	$core = new core;
	$dbc = new dbc;
	$link = $core->Linkdb();
	if ($_SESSION['euid'] == 'stu') {
		$fixpwd = password_hash($_SESSION['password'],PASSWORD_DEFAULT);
		$dbc->insertStudent($link,$_SESSION['user_id'],$_SESSION['euid'],$fixpwd,$_SESSION['username'],$_SESSION['class_id']);
		header("refresh:3;url=admin.php");
		echo "<br>三秒后返回";
	}elseif ($_SESSION['euid'] == 'tea') {
		$fixpwd = password_hash($_SESSION['password'],PASSWORD_DEFAULT);
		$dbc->insertTeacher($link,$_SESSION['user_id'],$_SESSION['euid'],$fixpwd,$_SESSION['username'],$_SESSION['phone'],$_SESSION['email']);
		header("refresh:3;url=admin.php");
		echo "<br>三秒后返回";
	}else{
		echo "has error..";
		header("refresh:3;url=admin.php");
		echo "<br>三秒后返回";
	}
?>