<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
    <title>
        <?php echo $OJ_NAME ?>
    </title>
    <?php include("template/$OJ_TEMPLATE/css.php"); ?>
    <script language="javascript" type="text/javascript">
        function checkname() {
            var player_name = $("#player_name").val();
            if (player_name == "") {
                $("#div_name").html("<font color=red><strong>&nbsp;&nbsp;&nbsp;&nbsp;名字不能为空!</strong></font>");
                return false;
            }
            else if (player_name.length == 0 || player_name.match(/^\s+$/g)) {
                $("#div_name").html("<font color=red><strong>&nbsp;&nbsp;&nbsp;&nbsp;名字不能为空格或都是空格!</strong></font>");
                return false;
            }
            else {
                $("#div_name").html("<strong>&nbsp;&nbsp;&nbsp;&nbsp;OK</strong>");
                return true;
            }
        }

        function check() {
            if (checkname()) {
                return true;
            }
            else {
                return false;
            }
        }
    </script>
    <script type="text/javascript">
        function preview(obj) {
            var img = document.getElementById("previewimg");
            img.src = window.URL.createObjectURL(obj.files[0]);
        }
    </script>


    <?php
    function br2nl($text)
    {
        return preg_replace('/<br\\s*?\/??>/i', '', $text);
    }

    $id = $_GET["now_team_member_id"];
    $flagup = $_GET["flagup"];
    $flagupdate = $_GET["flagupdate"];


    if ($flagupdate == "upd")
    {

    /*echo "flagadd: ".$flagadd."</br>";
    echo "id: ".$id."</br>";
    echo "flagupdate: ".$flagupdate."</br>";*/
    //echo "flagup: ".$flagup."</br>";
    $sql = "select picture,username,grade,email,professional,college,work,awards,introduce from now_players where user_id=?";
    $result = pdo_query($sql, $id);
    //照片
    $picture = $result[0]['picture'];
    //姓名
    $username = $result[0]['username'];
    //年级
    $grade = $result[0]['grade'];
    //邮箱
    $email = $result[0]['email'];
    //专业
    $professional = $result[0]['professional'];
    //学院
    $college = $result[0]['college'];
    //工作
    $work = $result[0]['work'];
    //奖状
    $awards = $result[0]['awards'];
    //自我介绍
    $introduce = $result[0]['introduce'];
    //处理awards
    //echo $u_awards.'<br />';
    //$arr=explode("\n",$u_awards);
    //print_r($arr);
    //echo count($arr).'<br />';//回车数
    $new_awards = br2nl($awards);//回车换成换行默认函数
    //处理introduce
    //echo $u_introduce.'<br />';
    //$arr=explode("\n",$u_introduce);
    //print_r($arr);
    //echo count($arr).'<br />';
    $new_introduce = br2nl($introduce);

    ?>
</head>

<body>
<div class="container">
    <?php include("template/$OJ_TEMPLATE/nav.php"); ?>
    <!-- Main component for a primary marketing message or call to action -->
    <div class="jumbotron">

        <h2 align="center" style="color:#F00"> 修改<?php echo $username ?>的信息：</h2>
        <form method=POST
              action="update_now_player.php?flagup=up&now_team_member_id=<?php echo $id; ?>&oddaddress=<?php echo $picture; ?>"
              enctype="multipart/form-data">
            <table border="0" bordercolor="#000000" align="center"
                   style="border-spacing:20px; border-collapse: separate;">
                <tr>
                    <td><strong>姓名：</strong></td>
                    <td>
                        <input type="text" value="<?php echo $username ?>" name="u_uname" id="player_name"
                               onBlur="checkname()" style="float:left">
                        <div id="div_name" style="float:left"></div>
                    </td>
                </tr>
                <td><strong>年级：</strong></td>
                <td><!--<input type="text" value="<?php echo $grade ?>" name="u_grade">-->
                    <?php
                    //搜索数据库找标签
                    $select_tag_player_grade = "select tag_player_grade from tag_player_grade";
                    $tag_player_grade_res = pdo_query($select_tag_player_grade);
                    /*$rows = mysql_affected_rows($conn);//获取行数
                    $colums = mysql_num_fields($conn);//获取列数*/

                    ?>
                    <select name="u_grade">
                        <?php

                        foreach ($tag_player_grade_res as $row) {
                            ?>
                            <option <?php if ($row[0] == $grade) {
                                echo("selected");
                            } ?> value="<?php echo $row[0]; ?>"><?php echo $row[0]; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </td>
                </tr>
                <tr>
                    <td><strong>邮箱：</strong></td>
                    <td><input type="text" value="<?php echo $email ?>" name="u_email"></td>
                </tr>
                <tr>
                    <td><strong>专业：</strong></td>
                    <td><!--<input type="text" value="<?php echo $professional ?>" name="u_professional">-->
                        <?php
                        //搜索数据库找标签
                        $select_tag_player_professional = "select tag_player_professional from tag_player_professional";
                        $tag_player_professional_res = pdo_query($select_tag_player_professional);
                        ?>
                        <select name="u_professional">
                            <?php
                            foreach ($tag_player_professional_res as $row) {
                                ?>
                                <option <?php if ($row[0] == $professional) {
                                    echo("selected");
                                } ?> value="<?php echo $row[0]; ?>"><?php echo $row[0]; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><strong>学院：</strong></td>
                    <td><!--<input type="text" value="<?php echo $college ?>" name="u_college">-->
                        <?php
                        //搜索数据库找标签
                        $select_tag_player_college = "select tag_player_college from tag_player_college";
                        $tag_player_college_res = pdo_query($select_tag_player_college);
                        /*$rows = mysql_affected_rows($conn);//获取行数
                        $colums = mysql_num_fields($conn);//获取列数*/
                        ?>
                        <select name="u_college">
                            <?php
                            foreach ($tag_player_college_res as $row) {
                                ?>
                                <option <?php if ($row[0] == $college) {
                                    echo("selected");
                                } ?> value="<?php echo $row[0]; ?>"><?php echo $row[0]; ?></option>
                                <?php
                            }

                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><strong>工作/就读研究上学校：</strong></td>
                    <td><input type="text" value="<?php echo $work ?>" name="u_work"></td>

                </tr>
                <tr>
                    <td><strong>获奖状况：</strong></td>
                    <td><!--<input type="text" value="" name="u_awards">-->
                        <textarea name="u_awards" wrap="hard"
                                  style="width:900px; height:200px;resize:none;overflow:scroll">
			   <?php echo $new_awards ?>
            </textarea>
                    </td>
                </tr>
                <tr>
                    <td><strong>自我介绍：</strong></td>
                    <td><!--<input type="text" value="" name="u_introduce">-->
                        <textarea name="u_introduce" wrap="hard"
                                  style="width:900px; height:200px;resize:none;overflow:scroll">
			   <?php echo $new_introduce ?>
            </textarea>
                    </td>
                </tr>

                <tr>
                    <input type="hidden" name="MAX_FILE_SIZE" value="1000000000"/>
                    <td><strong>选择照片：</strong></td>
                    <td><input type="file" name="upfile" onChange="preview(this)"/>
                        </br>
                        源图片：<img src="<?php echo $picture ?>" width="170px" height="220">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        所选图片：<img src="" id="previewimg" width="170px" height="220"/>
                    </td>
                </tr>
                <tr>
                    <td><input type="button" value="返回" onClick="back()"></td>
                    <td><input type="submit" value="修改"></td>
                </tr>
            </table>
        </form>


    </div><!--jumbotron div结束-->
</div><!--container div结束-->

<!-- /container -->


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<?php } ?>
<?php
if ($flagup == "up") {
    echo "<pre>";
    /* print_r($_FILES);
     echo "修改操作";*/

    if (!empty($_FILES['upfile']['name'])) {
    if ($_FILES['upfile']['error'] > 0) {
        switch ($_FILES['upfile']['error']) {
            case 1:
                $errorMsg = "上传文件超过了php.ini规定的大小！";
                break;
            case 2:
                $errorMsg = "文件大小超过了前台表单规定大小！";
                break;
            case 3:
                $errorMsg = "文件上传不完整！";
                break;
            case 4:
                $errorMsg = "没有上传文件！";
                break;
        }
        echo "<div style='border:solid 8px #dcdcdc; width=500px; height:80px; font-size:14px;'>
	            <div style='border-bottom:solid; font-size:20px; font-weigth:bold'>
		           发上错误！！！！
		        </div>
		        {$errorMsg}
		       </div>
		     ";
    }
    else {

        $dirName = 'image/now_team_member_picture';
        $toFileName = $dirName . '/' . $_FILES['upfile']['name'];
        $upload_toFileName = "../" . $dirName . '/' . $_FILES['upfile']['name'];
        $oddaddress = $_GET["oddaddress"];
        $u_uname = $_POST["u_uname"];
        $u_grade = $_POST["u_grade"];
        $u_email = $_POST["u_email"];
        $u_professional = $_POST["u_professional"];
        $u_college = $_POST["u_college"];
        $u_work = $_POST["u_work"];
        $u_awards = $_POST["u_awards"];
        $u_introduce = $_POST["u_introduce"];
        //echo $u_grade.'<br />';
        //echo $oddaddress.'<br />';
        //echo $u_id.'<br />';
        //echo $u_awards.'<br />';
        //$arr=explode("\n",$u_awards);
        //print_r($arr);
        //echo count($arr).'<br />';//回车数
        $new_u_awards = nl2br($u_awards);//回车换成换行默认函数

        //echo $u_introduce.'<br />';
        //$arr=explode("\n",$u_introduce);
        //print_r($arr);
        //echo count($arr).'<br />';
        $new_u_introduce = nl2br($u_introduce);

        /*echo "dirName:".$dirName."<br>";
        echo "u_uname:".$u_uname."<br>";
        echo "toFileName:".$toFileName."<br>";
        echo "u_id:".$u_id."<br>";
        echo "u_grade:".$u_grade."<br>";
        echo "u_email:".$u_email."<br>";
        echo "u_professional:".$u_professional."<br>";
        echo "u_college:".$u_college."<br>";
        echo "u_work:".$u_work."<br>";
        echo "u_awards:".$u_awards."<br>";
        echo "u_introduce:".$u_introduce."<br>";*/
        $sql10 = "update now_players set picture=?,username=?,grade=?,email=?,professional=?,college=?,work=?,awards=?,introduce=? where user_id=?";
        $res10 = pdo_query($sql10, $upload_toFileName, $u_uname, $u_grade, $u_email, $u_professional, $u_college, $u_work, $new_u_awards, $new_u_introduce, $id);
    if ($res10) {
        unlink($oddaddress);
        ?>
        <script>
            alert("修改成功");
            //window.location.href="now_playerinformation.php";
        </script>
    <?php
    echo "  判断上传是否成功:<br>";
    if (is_uploaded_file($_FILES['upfile']['tmp_name'])) {
        /*echo "<pre>";
        print_r($_FILES);
        echo "name:";
        print_r($_FILES['ufile']['name']);
        echo "tmp_name:";
        print_r($_FILES['upfile']['tmp_name']);
        echo "<br/>";*/


        //echo $toFileName;
        if (move_uploaded_file($_FILES['upfile']['tmp_name'], $toFileName)) {
            chmod($toFileName, 0777);
            echo "<script>
					           alert('上传文件成功！');
					           window.location.href='now_playerinformation.php';
					       </script>";
        } else {
            echo "toFileName:";
            echo $toFileName;
            echo "<br/>";
            echo $oddaddress;
            echo "<br/>";
            echo "tmp_name:";
            echo $_FILES['upfile']['tmp_name'];
            echo "<br/>";
            echo "is_uploaded_file true or false:";
            echo is_uploaded_file($_FILES['upfile']['tmp_name']);
            echo "<script>alert('上传失败');</script>";
        }
    } else {
        echo "<script>alert('错误！不是上传文件');</script>";
    }

    }
    else
    {
    ?>
        <script>
            alert("修改失败");
            <?php /*?>window.location.href="now_playerinformation.php";<?php */?>
        </script>
    <?php
    }

    }
    }
    else
    {
    $u_uname = $_POST["u_uname"];
    $u_grade = $_POST["u_grade"];
    $u_email = $_POST["u_email"];
    $u_professional = $_POST["u_professional"];
    $u_college = $_POST["u_college"];
    $u_work = $_POST["u_work"];
    $u_awards = $_POST["u_awards"];
    $u_introduce = $_POST["u_introduce"];

    echo $$team_member_id . '<br />';
    echo $u_grade . '<br />';
    echo $u_college . '<br />';
    //echo $u_awards.'<br />';
    //$arr=explode("\n",$u_awards);
    //print_r($arr);
    //echo count($arr).'<br />';//回车数
    $new_u_awards = nl2br($u_awards);//回车换成换行默认函数

    //echo $u_introduce.'<br />';
    //$arr=explode("\n",$u_introduce);
    //print_r($arr);
    //echo count($arr).'<br />';
    $new_u_introduce = nl2br($u_introduce);

    /* echo "dirName:".$dirName."<br>";
     echo "u_uname:".$u_uname."<br>";
     echo "toFileName:".$toFileName."<br>";
     echo "u_id:".$u_id."<br>";
     echo "u_grade:".$u_grade."<br>";
     echo "u_email:".$u_email."<br>";
     echo "u_professional:".$u_professional."<br>";
     echo "u_college:".$u_college."<br>";
     echo "u_work:".$u_work."<br>";
     echo "u_awards:".$u_awards."<br>";
     echo "u_introduce:".$u_introduce."<br>";*/
    $sql11 = "update now_players set username=?,grade=?,email=?,professional=?,college=?,work=?,awards=?,introduce=? where user_id=?";
    $res11 = mysql_query($sql11, $u_uname, $u_grade, $u_email, $u_professional, $u_college, $u_work, $new_u_awards, $new_u_introduce, $id);
    if ($res11)
    {
    ?>
        <script>
            alert("修改成功");
            window.location.href = "now_playerinformation.php";
        </script>
    <?php
    }
    else
    {
    ?>
        <script>
            alert("修改失败");
            //window.location.href="now_playerinformation.php.php";
        </script>
        <?php
    }

    }
}

?>
<script>
    function back() {

        window.location.href = 'now_playerinformation.php';
    }
</script>
</body>
</html>