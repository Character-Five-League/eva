<?php
include_once('core.php');

session_start();
$db = new core;
$stat = $db->CheckPwd($db->fixstr($_POST['userid']),$_POST['password']);
// echo $stat;
if($stat == '0'){
	$_SESSION['uid'] = "0";
	$db->SRoute("userid",$_POST['userid'],"admin.php");
}elseif($stat == '1'){
	$_SESSION['uid'] = "1";
	$db->SRoute("userid",$_POST['userid'],"session_list.php");
}elseif($stat == '2'){
	$_SESSION['uid'] = "2";
	$db->SRoute("userid",$_POST['userid'],"session_list.php");
}elseif($stat == '3'){
	echo "has error...";
}elseif($stat == '4'){
	echo "password uncro";
}elseif($stat == '5'){
	echo $_POST['userid'].",no this user...";
}
?>
