<?php 
	class core{
		const db_host = "localhost";
		const db_username = "root";
		const db_password = "000000";
		const db_database_name = "eva";



		function fixstr($str){
			$fix = preg_replace("/[^0-9]/", "", $str);
			return $fix;
		}

		function checkE(){
			if(isset($_SESSION['userid']))
				return;
				else
					echo "Please Login...";
		}

		function TestDb(){
			$link = mysqli_connect($this::db_host,$this::db_username,$this::db_password,$this::db_database_name);
			if($link)
				return 1;
			else
				return 0;
			mysqli_close($link);
		}

		function Linkdb(){
			$link = mysqli_connect($this::db_host,$this::db_username,$this::db_password,$this::db_database_name);
			if($link)
				return $link;
			else
				return "E:no links..";
			mysqli_close($link);
		}

		function SRoute($sessionname,$value,$locate){
			$_SESSION[$sessionname] = $value;
			header("location:$locate");

		}

		function check_uid($datalist){
			$uid = $datalist['uid'];
			if($uid == 'admin'){
				return 0;
			}elseif ($uid == 'tea') {
				return 1;
			}elseif($uid == 'stu'){
				return 2;
			}else{
				return 3;
			}
			$links->close();

		}

		function CheckPwd($userid,$password){
			if($this->TestDb()){
				$links = $this->Linkdb();
				$sql = "select user_id,uid,password from eva.users where user_id='$userid'";
				$res = $links->query($sql);
				if($res->num_rows > 0){
					$data = mysqli_fetch_assoc($res);
					$pwd = $data['password'];
					if(password_verify($password, $pwd)){
						$uid = $this->check_uid($data);
						return $uid;
					}else{
						return 4;
						$links->close();
					}
				}else{
					return 5;
					$links->close();
				}
			}else{
				echo "E: no connect";
			}
		}
	}
?>
