<?php
include_once('core.php');
session_start();
$db = new core;
$err = '';
if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$stat = $db->CheckPwd($db->fixstr($_POST['userid']),$_POST['password']);
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
		$err = "has error...";
	}elseif($stat == '4'){
		$err = "密码错误";
	}elseif($stat == '5'){
		$err = "额..".$_POST['userid'].",用户不存在...";
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>login</title>
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/base.css">
	<link href="">
</head>
<body>
	<div id="container" style="text-align: center;margin: 10%;">
		<div class="rounded" style="margin: 0 25% 0 25%;border: 1px black solid;">
			<form role="form" method="POST">
				<h1>欢迎!</h1><br>
				<h2>请输入登陆信息</h2><br>
				<h2>按下登陆键进入系统</h2><br>
				<p>用户名:<span><input type="text" name="userid" ></span></p><br>
				<p>密 码:<span><input type="password" name="password"></span></p><br>
				<span style="color: red;"><?=$err;?></span><br>
				<input class="btn btn-primary btn-lg" type="submit" name="submit" value="登陆">
			</form>
		</div>
	</div>
</body>
</html>