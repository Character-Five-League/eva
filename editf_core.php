<?php 
    include_once('core.php');
    include_once('dbc.php');
    session_start();
    $_SESSION['editor'] = "editf";
    $core = new core;
    $dbc = new dbc;
    $link = $core->Linkdb();
    $user_data = $dbc->getUserInfo($link,$_GET['id']);
    $chk = false;
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $_SESSION['e_user_id'] = $_GET['id'];
        if(empty($_POST['password'])){
            $_SESSION['pc'] = "0";
        }else{
            $_SESSION['password'] = $_POST['password'];
            $_SESSION['pc'] = "1";
        }
        $res = mysqli_fetch_assoc($user_data);
        if($res['uid'] == 'tea'){
            if(empty($_POST['user_name'])){
             $_SESSION['user_name'] = "匿名教师";
            }else{
             $_SESSION['user_name'] = $_POST['user_name'];
            }
            if(empty($_POST['user_phone'])){
             $_SESSION['user_phone'] = "phone";
            }else{
             $_SESSION['user_phone'] = $_POST['user_phone'];
            }
            if(empty($_POST['user_email'])){
             $_SESSION['user_email'] = "user@email";
            }else{
             $_SESSION['user_email'] = $_POST['user_email'];
            }
            $core->SRoute("euid","tea","cc.php");
        }elseif($res['uid'] == 'stu'){
            if(empty($_POST['user_name'])){
             $_SESSION['user_name'] = "匿名学生";
            }else{
             $_SESSION['user_name'] = $_POST['user_name'];
            }
            if(empty($_POST['class_id'])){
                $_SESSION['cp'] = "0";
            }else{
             $_SESSION['class_id'] = $_POST['class_id'];
                $_SESSION['cp'] = "1";
            }
            $core->SRoute("euid","stu","cc.php");
        }else{
            echo "Has error: form has error..";
        }
    }
 ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/bootstrap.css">
     <title>edit</title>
 </head>
 <body>
    <div class="container">
        <div class="jumbotron" style="text-align: center; margin: 10% 25% 10% 25%; border: 1px solid black;">
            <h1>编辑</h1>
            <form method="post">
                <?php while($row = mysqli_fetch_assoc($user_data)): ?>
                    <p><span>用户序列:</span><?=$row['user_id']?></p>
                    <p><span>用户身份:</span><?=$row['uid'] == "tea"?"教师":"学生" ?></p>
                    <p><span>密码:</span><input type="text" name="password" placeholder="(不做更改)"></p>
                <?php if($row['uid'] == 'tea'):
                    $teacher_data = $dbc->getTeaInfo($link,$_GET['id']);
                    while($row = mysqli_fetch_assoc($teacher_data)):
                ?>
                <div>
                    <p><span>用户名:</span><input type="text" name="user_name" value="<?=$row['user_name'];?>"></p>
                    <p><span>手机:</span><input type="phone" name="user_phone" value="<?=$row['user_phone'];?>"></p>
                    <p>电子邮箱<input type="email" name="user_email" value="<?=$row['user_email'];?>"></p>
                </div>
                <?php 
                    endwhile;
                    elseif($row['uid'] == 'stu'):
                    $student_data = $dbc->getStuInfo($link,$_GET['id']);
                    while($row = mysqli_fetch_assoc($student_data)):
                ?>
                    <p>username:<input type="text" name="user_name" value="<?=$row['user_name'];?>"></p>
                    <p>class<input type="text" name="class_id" value="<?=$row['class_id'];?>" placeholder="(不做更改)"></p>
                <?php endwhile;endif;endwhile; ?>
                <input class="btn btn-primary" type="reset" name="reset">
                <input class="btn btn-primary" type="submit" name="submit">
            </form>
        </div>
    </div>
 </body>
 </html>