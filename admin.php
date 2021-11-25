<?php 
	include_once('core.php');
	include_once('dbc.php');
	session_start();
	$_SESSION['editor'] = "admin";
	$core = new core;
	$dbc = new dbc;
	$link = $core->Linkdb();
	$res_admin = $dbc->listUsers($link,'admin');
	$res_tea = $dbc->listUsers($link,'tea');
	$res_stu = $dbc->listUsers($link,'stu');
	$res_form = $dbc->listsessions($link);
	$res_class = $dbc->listClass($link);
	$res_course = $dbc->listCourse($link);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>admin</title>
	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.bundle.js"></script>
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/base.css">
</head>
<body>
    <div class="container" style="margin-top: 5%;border: 1px black solid; ">
        <div>
		<h1 style="text-align: center;">管理界面</h1>
            <div class="nav-tabs-parent">
                <ul class="nav nav-tabs">
                    <li class="nav-item active"><a class="nav-link" href="#admin" data-bs-toggle="tab">管理员</a></li>
                    <li class="nav-item" ><a class="nav-link"  href="#tea" data-bs-toggle="tab">教师</a></li>
                    <li class="nav-item" ><a class="nav-link"  href="#stu" data-bs-toggle="tab">学生</a></li>
                    <li class="nav-item" ><a class="nav-link"  href="#form" data-bs-toggle="tab">表单</a></li>
                    <li class="nav-item" ><a class="nav-link"  href="#class" data-bs-toggle="tab">班级</a></li>
                    <li class="nav-item" ><a class="nav-link"  href="#course" data-bs-toggle="tab">课程</a></li>
                </ul>
            </div>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="admin">
					<table class="table">
						<tr>
							<th>用户ID</th>
							<th>用户组</th>
							<th>操作</th>
						</tr>
						<tbody>
							<?php 
								while($row = mysqli_fetch_assoc($res_admin)):
							 ?>
							<tr>
								<td><?=$row['user_id'];?></td>
								<td><?=$row['uid'];?></td>
								<td>
									<button type="button" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="right" title="您需要使用本地脚本操作管理员" id="del" >无权操作</button>
								</td>
							</tr>
						<?php endwhile; ?>
						</tbody>
					</table>
					<div style="margin-bottom: 15px;"><a href="regf.php"><button class="btn btn-primary" id="reg" >注册用户</button></a></div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="tea">
					<table class="table">
						<tr>
							<th>教师ID</th>
							<th>教师名称</th>
							<th>教师电话</th>
							<th>教师邮箱</th>
							<th>操作</th>
						</tr>
						<tbody>
							<?php 
								while ($row = mysqli_fetch_assoc($res_tea)):
							 ?>
							<tr>
								<td><?=$row['用户序列'];?></td>
								<td><?=$row['教师名'];?></td>
								<td><?=$row['教师电话'];?></td>
								<td><?=$row['教师电子邮箱'];?></td>
								<td>
									<a href="editf_core.php?uid=tea&id=<?=$row['用户序列'];?>"><button class="btn btn-primary">编辑</button></a>
									<button class="btn btn-danger" onclick="confirm('确实要删除此用户吗?')?window.location.href='cc.php?act=delu&id=<?=$row['用户序列'];?>':null;">删除</button>
								</td>
							</tr>
						<?php endwhile; ?>
						</tbody>
					</table>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="stu">
					<table class="table">
						<tr>
							<th>学生ID</th>
							<th>学生姓名</th>
							<th>所在年级</th>
							<th>所在班级</th>
							<th>操作</th>
						</tr>
						<tbody>
							<?php 
								while ($row = mysqli_fetch_assoc($res_stu)):
							 ?>
							<tr>
								<td><?=$row['用户序列']?></td>
								<td><?=$row['学生名']?></td>
								<td><?=$row['年级']?></td>
								<td><?=$row['所在班级']?></td>
								<td>
									<a href="editf_core.php?uid=stu&id=<?=$row['用户序列'];?>"><button class="btn btn-primary">编辑</button></a>
									<button class="btn btn-danger" onclick="confirm('确实要删除此用户吗?')?window.location.href='cc.php?act=delu&id=<?=$row['用户序列'];?>':null;">删除</button>
								</td>
							</tr>
							<?php endwhile; ?>
						</tbody>
					</table>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="form">
					<table class="table">
						<tr>
			 				<th>表单序列</th>
			 				<th>教师名称</th>
			 				<th>课程</th>
			 				<th>发布状态</th>
			 				<th>操作</th>
						</tr>
						<tbody>
							<?php 
								while($row = mysqli_fetch_assoc($res_form)):
							 ?>
							<tr>
					 			 <td><?=$row['表单序列'];?></td>
			 					 <td><?=$row['教师'];?></td>
			 					 <td><?=$row['班级'];?></td>
			 					 <td><?=$row['课程'];?></td>
			 					 <td><?=$row['发布状态'];?></td>
			 					 <td>
			 					 	<?php if($row['发布状态'] == 'no'): ?>
									<button class="btn btn-primary" onclick="confirm('are you shure?')?window.location.href='cc.php?act=pull&id=<?=$row['表单序列'];?>':null;">发布</button>
			 			 			<?php elseif($row['发布状态'] == 'yes'): ?>
									<button class="btn btn-primary" onclick="confirm('are you shure?')?window.location.href='cc.php?act=push&id=<?=$row['表单序列'];?>':null;">停止发布</button>
			 			 			<?php
			 			 		endif;
			 			 			?>
									<button class="btn btn-danger" onclick="confirm('are you shure?')?window.location.href='cc.php?act=delt&id=<?=$row['表单序列'];?>':null;">删除</button>
			 			 		</td>
							</tr>
			 			 	<?php endwhile;?>
						</tbody>
					</table>
					<div style="margin-bottom: 15px;"><a href="addf_core.php?tar=form"><button id="reg" class="btn btn-primary" >创建表单</button></a></div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="class">
					<table class="table">
						<tr>
			 				<th>班级序列</th>
			 				<th>年级序列</th>
			 				<th>班级名称</th>
			 				<th>操作</th>
						</tr>
						<tbody>
							<?php 
								while($row = mysqli_fetch_assoc($res_class)):
							 ?>
							<tr>
			 					 <td><?=$row['class_id'];?></td>
			 					 <td><?=$row['grade'];?></td>
			 					 <td><?=$row['class_name'];?></td>
			 					 <td>
									<button class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="right" title="请确保班级内已经没有学生" onclick="confirm('are you shure?')?window.location.href='cc.php?act=delc&id=<?=$row['class_id'];?>':null;">del</button>
			 			 		</td>
							</tr>
			 			 	<?php endwhile;?>
						</tbody>
					</table>
					<div style="margin-bottom: 15px;"><a href="addf_core.php?tar=class"><button class="btn btn-primary"id="reg" >创建班级</button></a></div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="course">
					<table class="table">
						<tr>
			 				<th>课程序列</th>
			 				<th>课程名称</th>
			 				<th>操作</th>
						</tr>
						<tbody>
							<?php 
								while($row = mysqli_fetch_assoc($res_course)):
							 ?>
							<tr>
			 					 <td><?=$row['course_id'];?></td>
			 					 <td><?=$row['course_name'];?></td>
			 					 <td>
									<button class="btn btn-danger" onclick="confirm('are you shure?')?window.location.href='cc.php?act=dels&id=<?=$row['course_id'];?>':null;">删除</button>
			 			 		</td>
							</tr>
			 			 	<?php endwhile;?>
						</tbody>
					</table>
					<div style="margin-bottom: 15px;"><a href="addf_core.php?tar=course"><button class="btn btn-primary" id="reg" >创建课程</button></a></div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
	var tooltipTriggerList = Array.prototype.slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
	var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
 			return new bootstrap.Tooltip(tooltipTriggerEl)
	})
</script>
</html>