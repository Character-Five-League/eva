<?php 
	class dbc{
		function listsessions($link){
			$sql = "select * from eva.form";
			$res = $link->query($sql);
			return $res;
		}
		function listUsers($link,$uid){
			$sql = '';
			if ($uid == 'admin') {
				$sql .= "select user_id,uid from eva.users where uid = '$uid'";
			}elseif ($uid == 'tea') {
				$sql .= "select * from eva.teachers";
			}elseif ($uid == 'stu') {
				$sql .= "select * from eva.students";
			}
			$res = $link->query($sql);
			return $res;
		}
		function getUserInfo($link,$user_id){
			$sql = "select * from eva.users where user_id = $user_id";
			$res = $link->query($sql);
			return $res;
		}
		function getTeaInfo($link,$user_id){
			$sql = "select user_name,user_phone,user_email from eva.teacher_info where user_id = $user_id";
			$res = $link->query($sql);
			return $res;
		}
		function getStuInfo($link,$user_id){
			$sql = "select user_name,class_id from eva.student_info where user_id = $user_id";
			$res = $link->query($sql);
			return $res;
		}
		function listClass($link){
			$sql = "select * from eva.class";
			$res = $link->query($sql);
			return $res;
		}
		function listCourse($link){
			$sql = "select * from eva.course";
			$res = $link->query($sql);
			return $res;
		}
		function listcheck($link,$form_id,$teacher_id){
			$sql ="select * from eva.form_list where form_id = $form_id and teacher_id = $teacher_id";
			$res = $link->query($sql);
			if ($res->num_rows > 0) {
				// echo "this user is be used..<br>";
				return 1;
			}else{
				// echo "no this user,used<br>";
				return 0;
			}
		}
		function checkClass($link,$form_id,$student_id){
			$sql ="select * from eva.form_list,eva.student_info where form_id = $form_id and user_id = $student_id and eva.form_list.class_id = eva.student_info.class_id";
			$res = $link->query($sql);
			if ($res->num_rows > 0) {
				// echo "this user is be used..<br>";
				return 1;
			}else{
				// echo "no this user,used<br>";
				return 0;
			}
		}
		function checkUser($link,$userid){
			$sql = "select user_id from eva.users where user_id = $userid"; 
			$res = $link->query($sql);
			if ($res->num_rows > 0) {
				echo "此ID已被使用<br>";
				return 1;
			}else{
				return 0;
			}
		}
		function checkInsert($link,$id,$student_id){
			$sql = "select * from eva.form_data where form_id = $id and student_id = $student_id";
			$res = $link->query($sql);
			if($res->num_rows == 0){
				return 0;
			}else{
				return 1;
			}
		}
		function checkClassExist($link,$class_id){
			$sql = "select class_id from eva.class where class_id = $class_id"; 
			$res = $link->query($sql);
			if ($res->num_rows > 0) {
				echo "此ID已被使用<br>";
				return 1;
			}else{
				return 0;
			}
		}
		function insertClass($link,$class_id,$grade,$class_name){
			if ($this->checkClassExist($link,$class_id) == 0) {
				$sql = "insert into eva.class (class_id,grade,class_name) values (?,?,?)";
				$mlink = $link->prepare($sql);
				$mlink->bind_param("iss",$class_id,$grade,$class_name);
				$mlink->execute();
				echo "写入成功";
				$mlink->close();
				return 1;
			}else{
				echo "发生错误，数据未提交";
				return 0;
			}
		}
		function insertUser($link,$user_id,$uid,$password){
			if ($this->checkUser($link,$user_id) == 0) {
				$sql = "insert into eva.users (user_id,uid,password) values (?,?,?)";
				$mlink = $link->prepare($sql);
				$mlink->bind_param("iss",$user_id,$uid,$password);
				$mlink->execute();
				echo "写入成功";
				$mlink->close();
				return 1;
			}else{
				echo "发生错误，数据未提交";
				return 0;
			}
		}
		function deleteUser($link,$user_id){
			$sql = "delete from eva.users where user_id = $user_id";
			$link->query($sql);
			echo "完成";
		}
		function deleteClass($link,$class_id){
			$sql = "delete from eva.class where class_id = $class_id";
			if($link->query($sql)){
				echo "完成";
			}else{
				echo "has error,please make shure this class has no student";
			}
		}
		function deleteCourse($link,$course_id){
			$sql = "delete from eva.course where course_id = $course_id";
			$link->query($sql);
			echo "完成";
		}
		function deleteSession($link,$form_id){
			$sql = "delete from eva.form_list where form_id = $form_id";
			$link->query($sql);
			echo "完成";
		}
		function updatePostStat($link,$form_id,$status_post){
			$sql = "update eva.form_list set status_post = $status_post where form_id = $form_id";
			$link->query($sql);
			echo "完成";
		}
		function insertStudent($link,$user_id,$uid,$password,$username,$class_id){
			$sins = $this->insertUser($link,$user_id,$uid,$password);
			if ($sins == 1) {
				$sql = "insert into eva.student_info values (?,?,?)";
				$mlink = $link->prepare($sql);
				$mlink->bind_param("dsd",$user_id,$username,$class_id);
				$mlink->execute();
				echo "stu insert finish<br>";
				$mlink->close();
			}else{
				echo "has error<br>";
			}
		}
		function insertTeacher($link,$user_id,$uid,$password,$username,$phone,$email){
			$sins = $this->insertUser($link,$user_id,$uid,$password);
			if($sins == 1){
				$sql = "insert into eva.teacher_info values (?,?,?,?)";
				$mlink = $link->prepare($sql);
				$mlink->bind_param("dsss",$user_id,$username,$phone,$email);
				$mlink->execute();
				echo "tea insert finish<br>";
				$mlink->close();
			}else{
				echo "has error<br>";
			}
		}
		function insertCourse($link,$course_name){
			$sql = "insert into eva.course values (course_id,?)";
			$mlink = $link->prepare($sql);
			$mlink->bind_param("s",$course_name);
			$mlink->execute();
			echo "insert course complete";
			$mlink->close();
		}
		function insertForm($link,$teacher_id,$class_id,$course_id,$status_post){
			$sql = "insert into eva.form_list values (form_id,?,?,?,?)";
			$mlink = $link->prepare($sql);
			$mlink->bind_param("ddds",$teacher_id,$class_id,$course_id,$status_post);
			$mlink->execute();
			echo "insert form complete";
			$mlink->close();
		}
		function insertData($link,$form_id,$student_id,$data1,$data2,$data3,$data4){
			$sql = "insert into eva.form_data values (?,?,?,?,?,?)";
			$mlink = $link->prepare($sql);
			$mlink->bind_param("ddssss",$form_id,$student_id,$data1,$data2,$data3,$data4);
			$mlink->execute();
			echo "insert data complete";
			$mlink->close();
		}
		function updateUser($link,$user_id,$password){
			$sql = "update eva.users set password='$password' where user_id=$user_id";
			$link->query($sql);
			echo "update password finish<br>";
		}
		function updateTea($link,$user_id,$user_name,$user_phone,$user_email){
			$sql = "update eva.teacher_info set user_name='$user_name',user_phone='$user_phone',user_email='$user_email' where user_id=$user_id";
			$link->query($sql);
			echo "update info finish";
		}
		function updateStu($link,$user_id,$user_name){
			$sql = "update eva.student_info set user_name='$user_name' where user_id=$user_id";
			$link->query($sql);
			echo "update info finish";
		}
		function updateStuC($link,$user_id,$user_name,$class_id){
			$sql = "update eva.student_info set user_name='$user_name',class_id='$class_id' where user_id=$user_id";
			$link->query($sql);
			echo "update info finish";
		}
		function prepare_form_data($link,$form_id,$conulm_name,$conulm_value){
			$sql = "select count($conulm_name) as resout from eva.form_data where form_id = $form_id and  $conulm_name = $conulm_value";
			$res = $link->query($sql);
			$data = mysqli_fetch_assoc($res);
			return $data['resout'];
		}
		function together_data($link,$id){
			//create array to insert base data for teacher's showing-data,then gether in array
			//now can into data from function..like this:
			//$this->prepare_form_data($link,$id,'conulm_name','"conulm_value"');
			$w1=$this->prepare_form_data($link,$_GET['id'],'work_attitude','"很满意"');
			$w2=$this->prepare_form_data($link,$_GET['id'],'work_attitude','"满意"');
			$w3=$this->prepare_form_data($link,$_GET['id'],'work_attitude','"不满意"');
			$w4=$this->prepare_form_data($link,$_GET['id'],'work_attitude','"很不满意"');
			$w5=$this->prepare_form_data($link,$_GET['id'],'teaching_level','"很满意"');
			$w6=$this->prepare_form_data($link,$_GET['id'],'teaching_level','"满意"');
			$w7=$this->prepare_form_data($link,$_GET['id'],'teaching_level','"不满意"');
			$w8=$this->prepare_form_data($link,$_GET['id'],'teaching_level','"很不满意"');
			$w9=$this->prepare_form_data($link,$_GET['id'],'answer_attitude','"很满意"');
			$w10=$this->prepare_form_data($link,$_GET['id'],'answer_attitude','"满意"');
			$w11=$this->prepare_form_data($link,$_GET['id'],'answer_attitude','"不满意"');
			$w12=$this->prepare_form_data($link,$_GET['id'],'answer_attitude','"很不满意"');
			$w13=$this->prepare_form_data($link,$_GET['id'],'course_atmosphere','"很满意"');
			$w14=$this->prepare_form_data($link,$_GET['id'],'course_atmosphere','"满意"');
			$w15=$this->prepare_form_data($link,$_GET['id'],'course_atmosphere','"不满意"');
			$w16=$this->prepare_form_data($link,$_GET['id'],'course_atmosphere','"很不满意"');
			$res = array(
				"work_attitude" => array(
					"a" => $w1,
					"b" => $w2,
					"c" => $w3,
					"d" => $w4
				),
				"teaching_level" => array(
					"a" => $w5,
					"b" => $w6,
					"c" => $w7,
					"d" => $w8
				),
				"answer_attitude" => array(
					"a" => $w9,
					"b" => $w10,
					"c" => $w11,
					"d" => $w12
				),
				"course_atmosphere" => array(
					"a" => $w13,
					"b" => $w14,
					"c" => $w15,
					"d" => $w16
				)
			);
			return $res;
		}
	}
 ?>