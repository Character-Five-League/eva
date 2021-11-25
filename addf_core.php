<?php 
    include_once('core.php');
    include_once('dbc.php');
    session_start();
    $core = new core;
    $dbc = new dbc;
    $link = $core->Linkdb();
    $_SESSION['editor'] = "addf";
    $tea = $dbc->listUsers($link,'tea');
    $class = $dbc->listClass($link);
    $course = $dbc->listCourse($link);
    //this way only use for add form,class and course
 ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>editor</title>
     <link rel="stylesheet" href="css/base.css">
     <link rel="stylesheet" href="css/bootstrap.css">
     <link rel="stylesheet" href="css/bootstrap-reboot.css">
     <script type="text/javascript" src="js/jquery.js"></script>
 </head>
 <body>
    <div class="container" style="margin: 10% auto; border: 1px solid black;text-align: center;">
        <?php if($_GET['tar'] == "form"): ?>
            <h1>表单创建</h1>
        <?php elseif($_GET['tar'] == "class"): ?>
            <h1>班级创建</h1>
        <?php elseif($_GET['tar'] == "course"): ?>
            <h1>课程创建</h1>
        <?php endif; ?>
     <form action="cc.php?tar=<?=$_GET['tar'];?>" method="post" onkeydown="if(event.keyCode==13)return false;">
         <table class="table">
            <tr>
                <?php if($_GET['tar'] == "form"): ?>
                    <th>教师</th>
                    <th>班级</th>
                    <th>课程</th>
                    <th>创建时的状态</th>
                <?php elseif($_GET['tar'] == "class"): ?>
                    <th>班级序列</th>
                    <th>年级</th>
                    <th>班级名称</th>
                <?php elseif($_GET['tar'] == "course"): ?>
                    <th>课程名称</th>
                <?php endif; ?>
            </tr>
             <tbody>
                 <tr>
                    <?php if($_GET['tar'] == "form"): ?>
                         <td>
                             <select class="form-select selectpicker" name="teacher_id">
                                <?php while ($row = mysqli_fetch_assoc($tea)):?>
                                    <option value="<?=$row['用户序列']?>"><?=$row['教师名']?></option>
                                <?php endwhile; ?>
                             </select>
                         </td>
                         <td>
                             <select class="form-select selectpicker" name="class_id">
                                <?php while ($row = mysqli_fetch_assoc($class)):?>
                                    <option value="<?=$row['class_id']?>"><?=$row['class_name']?></option>
                                <?php endwhile; ?>
                             </select>
                         </td>
                         <td>
                             <select class="form-select selectpicker" name="course_id">
                                <?php while ($row = mysqli_fetch_assoc($course)):?>
                                    <option value="<?=$row['course_id']?>"><?=$row['course_name']?></option>
                                <?php endwhile; ?>
                             </select>
                         </td>
                         <td>
                             <select class="form-select selectpicker" name="status_post">
                                <option value="yes">发布</option>
                                <option value="no">不发布</option>
                             </select>
                         </td>
                    <?php elseif($_GET['tar'] == "class"): ?>
                         <td><input type="text" name="class_id" onkeyup="this.value=this.value.replace(/\D/g,'')"></td>
                         <td>
                             <select class="form-select selectpicker" name="grade">
                                 <option value="g1">一年级</option>
                                 <option value="g2">二年级</option>
                                 <option value="g3">三年级</option>
                             </select>
                         </td>
                         <td><input type="text" name="class_name"></td>
                    <?php elseif($_GET['tar'] == "course"): ?>
                         <td><input type="text" name="course_name"></td>
                    <?php endif; ?>
                </tr>
             </tbody>
         </table>
         <input class="btn btn-primary" type="submit" name="submit">
     </form>
    </div>
 </body>
 </html>