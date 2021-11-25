<?php 
	include_once('core.php');
	include_once('dbc.php');
	session_start();
	$dbc = new dbc;
	$core = new core;
	$link = $core->Linkdb();
	$res = $dbc->listsessions($link);
 ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1.0">
 	<link rel="stylesheet" href="css/base.css">
 	<link rel="stylesheet" href="css/bootstrap.css">
 	<title>Document</title>
 </head>
 <body>
 	<div class="container" style="margin: 10% auto;border: 1px solid black;">
 		<?php echo "hey,".$_SESSION['userid']; ?>
 		<table class="table table-hover">
 			<tr>
 				<?php 
 					if($_SESSION['uid'] == "1" ):
 				 ?>
 				<th>教师</th>
 				<th>班级</th>
 				<th>课程</th>
 				<th>发布状态</th>
 				<th>操作</th>
 				<?php
 					elseif ($_SESSION['uid'] == "2"):
 				?>
 				<th>教师</th>
 				<th>班级</th>
 				<th>课程</th>
 				<th>操作</th>
 				<?php endif; ?>
 			</tr>
 			<tbody>
 				<?php 
 				while ($row = mysqli_fetch_assoc($res)):
 					?>
 					<tr>
 						<?php 
 							if($_SESSION['uid'] == "1" ):
 								if($dbc->listcheck($link,$row['表单序列'],$_SESSION['userid']) == 0) continue;
 						 ?>
 						 <td><?=$row['教师'];?></td>
 						 <td><?=$row['班级'];?></td>
 						 <td><?=$row['课程'];?></td>
 						 <td><?=$row['发布状态']=="yes"?"是":"否";?></td>
 						 <td>
 						 	<?php if($row['发布状态'] == 'yes'): ?>
 						 	<a href="session_show.php?id=<?=$row['表单序列'];?>&course=<?=$row['课程']?>"><button class="btn btn-info">查看</button></a>
 						 	<?php else: ?>
 						 		<button class="btn btn-secondary" disabled>暂未开放</button>
 						 	<?php endif; ?>
 						 </td>
 						 <?php elseif ($_SESSION['uid'] == "2"):
 						 	if($row['发布状态'] == 'no') continue;
 						 	if($dbc->checkClass($link,$row['表单序列'],$_SESSION['userid']) == 0) continue;
 						 	?>
 						 <td><?=$row['教师'];?></td>
 						 <td><?=$row['班级'];?></td>
 						 <td><?=$row['课程'];?></td>
 						 <td>
 						 	<?php 
 						 	if ($dbc->checkInsert($link,$row['表单序列'],$_SESSION['userid']) == '0'):
 						 	 ?>
 						 	<a href="session_edit.php?id=<?=$row['表单序列']?>"><button class="btn btn-primary">edit</button></a>
 						 <?php else: ?>
 						 	<button class="btn btn-secondary" disabled>已经填写</button>
 						 </td>
 						 <?php 
 						endif;
 						endif;
 					endwhile;
 						  ?>
 					</tr>
 			</tbody>
 		</table>
 	</div>
 </body>
 </html>