<?php 
	include_once('core.php');
	include_once('dbc.php');
	session_start();
	$core = new core;
	$dbc = new dbc;
	$link = $core->Linkdb();
	if ($_SESSION['editor'] == "session_edit") {
		$dbc->insertData($link,$_SESSION['id'],$_SESSION['userid'],$_SESSION['work_attitude'],$_SESSION['teaching_level'],$_SESSION['answer_attitude'],$_SESSION['course_atmosphere']);
	}elseif ($_SESSION['editor'] == "addf") {
		$tar = $_GET['tar'];
		if ($tar == "form") {
			$dbc->insertForm($link,$_POST['teacher_id'],$_POST['class_id'],$_POST['course_id'],$_POST['status_post']);
		}elseif($tar == "class"){
			$class_name = "";
			$chk = false;
			if (empty($_POST['class_id'])) {
				header("refresh:3;url=addf_core.php?tar=class");
				echo "E：请先填写班级序列<br>三秒后返回";
				$chk = true;
			}
			if(empty($_POST['class_name'])){
				$class_name = "匿名班级";
			}else{
				$class_name = $_POST['class_name'];
			}
			if ($chk == false) {
				$dbc->insertClass($link,$_POST['class_id'],$_POST['grade'],$class_name);
				header("refresh:3;url=admin.php");
				echo "<br>三秒后返回";
			}
		}elseif($tar == "course"){
			$course_name = "";
			if(empty($_POST['course_name'])){
				$course_name = "匿名课程";
			}else{
				$course_name = $_POST['course_name'];
			}
			$dbc->insertCourse($link,$course_name);
		}else{
			header("refresh:3;url=admin.php");
			echo "<br>三秒后返回";
		}
	}elseif ($_SESSION['editor'] == "editf") {
		//update only
		if ($_SESSION['pc'] == "0") {
			echo "not change pwd";
		}else{
			$fixpwd = password_hash($_SESSION['password'], PASSWORD_DEFAULT);
			$dbc->updateUser($link,$_SESSION['e_user_id'],$fixpwd);
		}
		if($_SESSION['euid'] == "tea"){
			$dbc->updateTea($link,$_SESSION['e_user_id'],$_SESSION['user_name'],$_SESSION['user_phone'],$_SESSION['user_email']);
		}elseif($_SESSION['euid'] == "stu"){
			if ($_SESSION['cp'] == "0") {
				echo "not change pwd";
				$dbc->updateStu($link,$_SESSION['e_user_id'],$_SESSION['user_name']);
			}else{
			$dbc->updateStuC($link,$_SESSION['e_user_id'],$_SESSION['user_name'],$_SESSION['class_id']);
			}
		}
	}elseif($_SESSION['editor'] == "admin"){
		switch ($_GET['act']) {
			case "delu":
				$dbc->deleteUser($link,$_GET['id']);
				header("refresh:3;url=admin.php");
				echo "<br>三秒后返回";
				break;
			
			case "dels":
				$dbc->deleteCourse($link,$_GET['id']);
				header("refresh:3;url=admin.php");
				echo "<br>三秒后返回";
				break;

			case "delc":
				$dbc->deleteClass($link,$_GET['id']);
				header("refresh:3;url=admin.php");
				echo "<br>三秒后返回";
				break;

			case "delt":
				$dbc->deleteSession($link,$_GET['id']);
				header("refresh:3;url=admin.php");
				echo "<br>三秒后返回";
				break;

			case "push":
				$dbc->updatePostStat($link,$_GET['id'],"'no'");
				header("refresh:3;url=admin.php");
				echo "<br>三秒后返回";
				break;

			case "pull":
				$dbc->updatePostStat($link,$_GET['id'],"'yes'");
				header("refresh:3;url=admin.php");
				echo "<br>三秒后返回";
				break;

			default:
				// code...
				break;
		}
	}else{
		echo "has error,session is wrong";
	}
 ?>