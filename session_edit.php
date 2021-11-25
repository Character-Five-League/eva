<?php 
    include_once('core.php');
    include_once('dbc.php');
    session_start();
    $core = new core;
    $dbc = new dbc;
    $link = $core->Linkdb();
    $_SESSION['editor'] = "session_edit";
    $chk = false;
    $sel = '';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(empty($_POST['work_attitude'])){
            $sel = "所有项目都是必填项哦";
            $chk = true;
        }
        if(empty($_POST['teaching_level'])){
            $sel = "所有项目都是必填项哦";
            $chk = true;
        }
        if(empty($_POST['answer_attitude'])){
            $sel = "所有项目都是必填项哦";
            $chk = true;
        }
        if(empty($_POST['course_atmosphere'])){
            $sel = "所有项目都是必填项哦";
            $chk = true;
        }
        if ($chk == false) {
            $_SESSION['work_attitude'] = $_POST['work_attitude'];
            $_SESSION['teaching_level'] = $_POST['teaching_level'];
            $_SESSION['answer_attitude'] = $_POST['answer_attitude'];
            $_SESSION['course_atmosphere'] = $_POST['course_atmosphere'];
            $_SESSION['id'] = $_GET['id'];
            $core->SRoute("editor","session_edit","cc.php");
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
    <title>Edit sessions</title>
</head>
<body>
    <div class="container" style="text-align: center; margin-top: 10%; border: 1px solid black;">
        <div id="header">
            <h1>编辑界面</h1>
        </div>
        <div>
            <form  role="form" method="post" onkeydown="if(event.keyCode==13)return false;">
                <table class="table">
                    <tr>
                        <th>课程序列</th>
                        <th>评价项目</th>
                        <th>满意情况</th>
                    </tr>
                    <tbody>
                        <tr>
                            <td><?=$_GET['id']?></td>
                            <td>工作态度</td>
                            <td>
                                <input class="form-check-input" type="radio" name="work_attitude" value="很满意">很满意
                                <input class="form-check-input" type="radio" name="work_attitude" value="满意">满意
                                <input class="form-check-input" type="radio" name="work_attitude" value="不满意">不满意
                                <input class="form-check-input" type="radio" name="work_attitude" value="很不满意">很不满意
                            </td>
                        </tr>
                        <tr>
                            <td><?=$_GET['id']?></td>
                            <td>教学水平</td>
                            <td>
                                <input class="form-check-input" type="radio" name="teaching_level" value="很满意">很满意
                                <input class="form-check-input" type="radio" name="teaching_level" value="满意">满意
                                <input class="form-check-input" type="radio" name="teaching_level" value="不满意">不满意
                                <input class="form-check-input" type="radio" name="teaching_level" value="很不满意">很不满意
                            </td>
                        </tr>
                        <tr>
                            <td><?=$_GET['id']?></td>
                            <td>答疑态度</td>
                            <td>
                                <input class="form-check-input" type="radio" name="answer_attitude" value="很满意">很满意
                                <input class="form-check-input" type="radio" name="answer_attitude" value="满意">满意
                                <input class="form-check-input" type="radio" name="answer_attitude" value="不满意">不满意
                                <input class="form-check-input" type="radio" name="answer_attitude" value="很不满意">很不满意
                            </td>
                        </tr>
                        <tr>
                            <td><?=$_GET['id']?></td>
                            <td>课堂氛围</td>
                            <td>
                                <input class="form-check-input" type="radio" name="course_atmosphere" value="很满意">很满意
                                <input class="form-check-input" type="radio" name="course_atmosphere" value="满意">满意
                                <input class="form-check-input" type="radio" name="course_atmosphere" value="不满意">不满意
                                <input class="form-check-input" type="radio" name="course_atmosphere" value="很不满意">很不满意
                            </td>
                        </tr>
                    </tbody>
                </table>
                <span class="alert-danger"><?=$sel?></span><br>
                <input class="btn btn-primary" type="reset" name="reset">
                <input class="btn btn-primary" type="submit" name="submit">
            </form>
        </div>
    </div>
</body>
</html>