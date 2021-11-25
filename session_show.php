<?php 
    include_once('core.php');
    include_once('dbc.php');
    session_start();
    $core = new core;
    $dbc = new dbc;
    $link = $core->Linkdb();
    $res = $dbc->together_data($link,$_GET['id']);
    // echo $res['work_attitude']['a'];
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show session</title>
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <script type="text/javascript" src="js/bootstrap.bundle.js"></script>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/echarts.js"></script>
    <style>
        .container div{
            display: flex;
        }
    </style>
</head>
<body>
    <div class="container" style=" text-align: center;margin-top: 5%; border: 1px black solid;">
        <h2>详细数据</h2>
        <table class="table">
            <tr>
                <th>表单号</th>
                <th>课程</th>
                <th>项目</th>
                <th>很满意</th>
                <th>满意</th>
                <th>不满意</th>
                <th>很不满意</th>
            </tr>
            <tbody>
                <tr>
                    <td><?=$_GET['id']?></td>
                    <td><?=$_GET['course']?></td>
                    <td>工作态度</td>
                    <td><?=$res['work_attitude']['a']?></td>
                    <td><?=$res['work_attitude']['b']?></td>
                    <td><?=$res['work_attitude']['c']?></td>
                    <td><?=$res['work_attitude']['d']?></td>
                </tr>
                <tr>
                    <td><?=$_GET['id']?></td>
                    <td><?=$_GET['course']?></td>
                    <td>教学质量</td>
                    <td><?=$res['teaching_level']['a']?></td>
                    <td><?=$res['teaching_level']['b']?></td>
                    <td><?=$res['teaching_level']['c']?></td>
                    <td><?=$res['teaching_level']['d']?></td>
                </tr>
                <tr>
                    <td><?=$_GET['id']?></td>
                    <td><?=$_GET['course']?></td>
                    <td>答疑态度</td>
                    <td><?=$res['answer_attitude']['a']?></td>
                    <td><?=$res['answer_attitude']['b']?></td>
                    <td><?=$res['answer_attitude']['c']?></td>
                    <td><?=$res['answer_attitude']['d']?></td>
                </tr>
                <tr>
                    <td><?=$_GET['id']?></td>
                    <td><?=$_GET['course']?></td>
                    <td>课堂气氛</td>
                    <td><?=$res['course_atmosphere']['a']?></td>
                    <td><?=$res['course_atmosphere']['b']?></td>
                    <td><?=$res['course_atmosphere']['c']?></td>
                    <td><?=$res['course_atmosphere']['d']?></td>
                </tr>
            </tbody>
        </table>
        <div class="container">
            <div id="show1" style="width: 25%;height: 500%;"></div>
            <div id="show2" style="width: 25%;height: 500%;"></div>
            <div id="show3" style="width: 25%;height: 500%;"></div>
            <div id="show4" style="width: 25%;height: 500%;"></div>
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="别卷了，没有排行榜" id="del" >查看排行榜</button>
        <script>
         var tooltipTriggerList = Array.prototype.slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
         var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
             return new bootstrap.Tooltip(tooltipTriggerEl)
         })
        </script>
        <script>
            var chart1 = echarts.init(document.getElementById('show1'));
            var chart2 = echarts.init(document.getElementById('show2'));
            var chart3 = echarts.init(document.getElementById('show3'));
            var chart4 = echarts.init(document.getElementById('show4'));
            var option1 = {
                title:{
                    text:'工作态度的满意度',
                    left:'center',
                },
                  series: [
                    {
                      type: 'pie',
                      stillShowZeroSum: false,
                      data: [
                        {
                          value: <?=$res['work_attitude']['a']?>,
                          name: '很满意'
                        },
                        {
                          value: <?=$res['work_attitude']['b']?>,
                          name: '满意'
                        },
                        {
                          value: <?=$res['work_attitude']['c']?>,
                          name: '不满意'
                        },
                        {
                          value: <?=$res['work_attitude']['d']?>,
                          name: '很不满意'
                        }
                      ],
                    }
                  ]
                };
            var option2 = {
                title:{
                    text:'教学质量的满意度',
                    left:'center',
                },
                  series: [
                    {
                      type: 'pie',
                      stillShowZeroSum: false,
                      data: [
                        {
                          value: <?=$res['teaching_level']['a']?>,
                          name: '很满意'
                        },
                        {
                          value: <?=$res['teaching_level']['b']?>,
                          name: '满意'
                        },
                        {
                          value: <?=$res['teaching_level']['c']?>,
                          name: '不满意'
                        },
                        {
                          value: <?=$res['teaching_level']['d']?>,
                          name: '很不满意'
                        }
                      ],
                    }
                  ]
                };
            var option3 = {
                title:{
                    text:'答疑态度的满意度',
                    left:'center',
                },
                  series: [
                    {
                      type: 'pie',
                      stillShowZeroSum: false,
                      data: [
                        {
                          value: <?=$res['answer_attitude']['a']?>,
                          name: '很满意'
                        },
                        {
                          value: <?=$res['answer_attitude']['b']?>,
                          name: '满意'
                        },
                        {
                          value: <?=$res['answer_attitude']['c']?>,
                          name: '不满意'
                        },
                        {
                          value: <?=$res['answer_attitude']['d']?>,
                          name: '很不满意'
                        }
                      ],
                    }
                  ]
                };
            var option4 = {
                title:{
                    text:'课堂气氛的满意度',
                    left:'center',
                },
                  series: [
                    {
                      type: 'pie',
                      stillShowZeroSum: false,
                      data: [
                        {
                          value: <?=$res['course_atmosphere']['a']?>,
                          name: '很满意'
                        },
                        {
                          value: <?=$res['course_atmosphere']['b']?>,
                          name: '满意'
                        },
                        {
                          value: <?=$res['course_atmosphere']['c']?>,
                          name: '不满意'
                        },
                        {
                          value: <?=$res['course_atmosphere']['d']?>,
                          name: '很不满意'
                        }
                      ],
                    }
                  ]
                };
                chart1.setOption(option1);
                chart2.setOption(option2);
                chart3.setOption(option3);
                chart4.setOption(option4);
    </script>
</body>
</html>