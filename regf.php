<?php 
	include_once('core.php');
	session_start();
	$core = new core;
	$chk = false;
	$sete = $nerr1 = $nerr2 = $cerr = $perr1 = $perr2 = '';
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if($_POST['euid'] == "stu"){
			if(empty($_POST['userid1'])){
				$nerr1 = 'you need input here';
				$chk = true;
			}elseif(empty($core->fixstr($_POST['userid1']))){
				$nerr1 = 'err,please try again..';
				$chk = true;
			}
			if(empty($_POST['password1'])){
				$perr1 = 'input password..';
				$chk = true;
			}
			if(empty($_POST['class_id'])){
				$cerr = 'input classid..';
				$chk = true;
			}
			if ($chk == false) {
				$_SESSION['euid'] = $_POST['euid'];
				$_SESSION['user_id'] = $_POST['userid1'];
				$_SESSION['password'] = $_POST['password1'];
				$_SESSION['class_id'] = $_POST['class_id'];
				if (empty($_POST['username1'])) {
					$_SESSION['username'] = "user_name";
				}else{
					$_SESSION['username'] = $_POST['username1'];
				}
				header("location:regb.php");
			}
		}elseif($_POST['euid'] == "tea"){
			if(empty($_POST['userid2'])){
				$nerr2 = 'you need input header';
				$chk = true;
			}
			if(empty($_POST['password2'])){
				$perr2 = 'input password..';
				$chk = true;
			}
			if ($chk == false) {
				$_SESSION['euid'] = $_POST['euid'];
				$_SESSION['user_id'] = $_POST['userid2'];
				$_SESSION['password'] = $_POST['password2'];
				if (empty($_POST['username2'])) {
					$_SESSION['username'] = 'user_name';
				}else{
					$_SESSION['username'] = $_POST['username2'];
				}
				if (empty($_POST['phone'])) {
					$_SESSION['phone'] = "user_phone";
				}else{
					$_SESSION['phone'] = $_POST['phone'];
				}
				if (empty($_POST['email'])) {
					$_SESSION['email'] = "user@email";
				}else{
					$_SESSION['email'] = $_POST['email'];
				}
				header("location:regb.php");
			}
		}else{
			$sete = "ERROR:maybe not set...";
			$chk = true;
		}
	}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>reg</title>
	<link rel="stylesheet" href="css/base.css">
	<link rel="stylesheet" href="css/bootstrap.css">
	<script src="js/jquery.js"></script>
	<script>
		$(document).ready(function(){
			var checked = $("#istu").value;
			$("#istu").click(function(){
				$("#stu").show();
				$("#tea").hide();
			});
			$("#itea").click(function(){
				$("#stu").hide();
				$("#tea").show();
			});
		});
	</script>
</head>
<body>
	<div class="container">
		<div class="jumbotron" style="text-align: center;margin: 10% 25% 10% 25%;border: 1px black solid;">
			<h1>注册</h1>
		 	<form role="form" method="post" onkeydown="if(event.keyCode==13)return false;">
				<div>
					<ul>
						<li><input type="radio" name="euid" id="istu" value="stu" checked="true">学生？</li>
						<li><input type="radio" name="euid" id="itea" value="tea">老师？</li>
						<span><small><?=$sete ?></small></span>
					</ul>
				</div>
				<div id="stu">
					<p>用户序列<span><small><?=$nerr1; ?></small></span><input type="text" name="userid1" onkeyup="this.value=this.value.replace(/\D/g,'')"></p>
					<p>密码<span><small><?=$perr1; ?></small></span><input type="text" name="password1"></p><br>
					<p>用户名<input type="text" name="username1"></p><br>
					<p>班级序列<span><small><?=$cerr; ?></small></span><input type="text" name="class_id"></p><br>
					<input class="btn btn-primary" type="reset" name="reset" value="重置">
					<input class="btn btn-primary" type="submit" name="submit" value="确认注册">
				</div>
				<div id="tea" style="display: none;" onkeydown=" if(event.keyCode==13)return false;">
					<p>用户序列<span><small><?=$nerr2; ?></small></span><input type="text" name="userid2" onkeyup="this.value=this.value.replace(/\D/g,'')"></p><br>
					<p>密码<span><small><?=$perr2; ?></small></span><input type="text" name="password2"></p><br>
					<p>用户名<input type="text" name="username2"></p><br>
					<p>电话<input type="tel" name="phone" onkeyup="this.value=this.value.replace(/\D/g,'')"></p><br>
					<p>电子邮箱<input type="email" name="email"></p><br>
					<input class="btn btn-primary btn-lg" type="reset" name="reset" value="重置">
					<input class="btn btn-primary btn-lg" type="submit" name="submit" value="确认注册">
				</div>
			</form>
		</div>
	</div>
 </body>
</html>