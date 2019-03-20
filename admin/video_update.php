<html>
<head>
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta http-equiv="Content-Language" content="zh-cn">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>New Problem</title>
</head>
<body leftmargin="30">
<div class="container">
    <?php
    require_once("admin-header.php");
    if (!(isset($_SESSION[$OJ_NAME . '_' . 'administrator']) || isset($_SESSION[$OJ_NAME . '_' . 'video_editor']))) {
        echo "<a href='../loginpage.php'>Please Login First!</a>";
        exit(1);
    }
    ?>
    video update
    <?php

    $id = $_GET["video_id"];
    $flag = $_GET["flag"];
    echo "id: " . $id . "</br>";
    echo "flag: " . $flag . "</br>";

    if ($flag == "del") {
        //echo "进行删除操作:</br>";
        //echo "name: ".$name."</br>";
        $sql = "select video_address from video where video_id=?";
        $data = pdo_query($sql, $id);
        $address = $data[0]['video_address'];
        echo "address:" . $address;

        $delete_video = "delete from video where video_id=?";
        $delete_video_result = pdo_query($delete_video, $id);
        //echo "delete result: ".$res;
        if ($delete_video_result) {
            unlink($address);
            ?>
            <script>
                alert("删除成功");
                window.location.href = "video_update_page.php";
            </script>
        <?php

        }
        else
        {
        ?>
            <script>
                alert("删除失败");
                //window.location.href="video_update_page.php";
            </script>
            <?php
        }

    }
    if ($flag == "update") {
        $sql = "select video_address,video_name,video_describe,video_framer,video_source,video_privilege from video where video_id=?";
        $video_result = pdo_query($sql, $id);
        $address = $video_result[0]['video_address'];
        //echo "address:".$address;
        $name = $video_result[0]['video_name'];
        //name
        $describe = $video_result[0]['video_describe'];
        //echo $describe;
        $framer = $video_result[0]['video_framer'];
        // echo $framer;
        $source = $video_result[0]['video_source'];
        //echo $source;
        $privilege = $video_result[0]['video_privilege'];
        //echo $privilege;
        ?>
        <h2 align="center" style="color:#F00"> 修改<?php echo $name ?>的信息： </h2>
        <form method=POST action="video_update.php?flag=upd&id=<?php echo $id; ?>&oldname=<?php echo $address; ?>"
              enctype="multipart/form-data">
            <table border="2" bordercolor="#000000" width="500" align="center" height="250">
                <tr>
                    <td><p>视频名：</p></td>
                    <td><input type="text" value="<?php echo $name ?>" name="v_name"></td>
                </tr>
                <tr>
                    <td><p>视频描述：</p></td>
                    <td><!--<input type="text" value="<?php echo $describe ?>" name="v_describe">-->
                        <?php
                        //搜索数据库找标签
                        $select_video_describe = "select tag_video_describe from tag_video_describe";
                        $video_describe_res = pdo_query($select_video_describe);
                        /*$rows = mysql_affected_rows($link_video_update);//获取行数
                        $colums = mysql_num_fields($link_video_update);//获取列数*/

                        ?>
                        <select name="v_describe">
                            <?php

                            foreach ($video_describe_res as $row) {
                                ?>
                                <option <?php if ($row[0] == $describe) {
                                    echo("selected");
                                } ?> value="<?php echo $row[0]; ?>"><?php echo $row[0]; ?></option>
                                <?php
                            }

                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><p>视频发布者：</p></td>
                    <td><!--<input type="text" value="<?php echo $framer ?>" name="v_farmer">-->
                        <?php
                        //搜索数据库找标签
                        $select_video_framer = "select tag_video_framer from tag_video_framer";
                        $video_framer_res = pdo_query($select_video_framer);
                        /*$rows = mysql_affected_rows($link_video_update);//获取行数
                        $colums = mysql_num_fields($link_video_update);//获取列数*/

                        ?>
                        <select name="v_farmer">
                            <?php
                            foreach ($video_framer_res as $row) {
                                ?>
                                <option <?php if ($row[0] == $framer) {
                                    echo("selected");
                                } ?> value="<?php echo $row[0]; ?>"><?php echo $row[0]; ?></option>
                                <?php
                            }

                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><p>视频来源</p></td>
                    <td><!--<input type="text" value="<?php echo $source ?>" name="v_source">-->
                        <?php
                        //搜索数据库找标签
                        $select_video_source = "select tag_video_source from tag_video_source";
                        $video_source_res = pdo_query($select_video_source);
                        /*$rows = mysql_affected_rows($link_video_update);//获取行数
                        $colums = mysql_num_fields($link_video_update);//获取列数*/

                        ?>
                        <select name="v_source">
                            <?php

                            foreach ($video_source_res as $row) {
                                ?>
                                <option <?php if ($row[0] == $source) {
                                    echo("selected");
                                } ?> value="<?php echo $row[0]; ?>"><?php echo $row[0]; ?></option>
                                <?php
                            }

                            ?>
                        </select>

                    </td>
                </tr>
                <tr>
                    <td><p>视频权限：</p></td>
                    <td><!--<input type="text" value="<?php echo $privilege ?>" name="v_describe">-->
                        <?php
                        //搜索数据库找标签
                        $select_video_privilege = "select tag_privilege_name from tag_privilege";
                        $video_privilege_res = pdo_query($select_video_privilege);
                        /*$rows = mysql_affected_rows($link_video_update);//获取行数
                        $colums = mysql_num_fields($link_video_update);//获取列数*/

                        ?>
                        <select name="v_privilege">
                            <?php

                            foreach ($video_privilege_res as $row) {
                                ?>
                                <option <?php if ($row[0] == $privilege) {
                                    echo("selected");
                                } ?> value="<?php echo $row[0]; ?>"><?php echo $row[0]; ?></option>
                                <?php
                            }

                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><input type="button" value="返回" onClick="back()"></td>
                    <td><input type="submit" value="修改"></td>
                </tr>
            </table>
        </form>
        <?php
    }
    if ($flag == "upd") {
        echo "修改操作";
        $id_upd = $_GET["id"];
        $oldname = $_GET["oldname"];
        $v_name = $_POST["v_name"];
        $v_describe = $_POST["v_describe"];
        $v_farmer = $_POST["v_farmer"];
        $v_source = $_POST["v_source"];
        $v_privilege = $_POST["v_privilege"];
        echo "newname:" . $v_name . "</br>";
        echo "oldname:" . $oldname . "</br>";
        echo "discribe:" . $v_describe . "</br>";
        echo "framer:" . $v_farmer . "</br>";
        echo "source:" . $v_source . "</br>";
        //newname
        echo "url:" . dirname($oldname) . "</br>";
        $newname = dirname($oldname) . "/" . $v_name;
        echo "newname:" . $newname . "</br>";
        echo "id:" . $id_upd . "</br>";

        /*$select_video_id="select video_id from video where video_name='$v_name'";
        $select_video_id_result=mysql_query($select_video_id,$link_video_update);
        $id=mysql_result($select_video_id_result,0);*/


        $update_video = "update video set video_name=?,video_describe=?,video_framer=?,video_source=?,video_address=?,video_privilege=? where video_id=?";
        $update_video_result = pdo_query($update_video, $v_name, $v_describe, $v_farmer, $v_source, $newname, $v_privilege, $id_upd);
        if (rename($oldname, $newname)) {
            echo "成功重命名";
        }
        if ($update_video_result) {
            ?>
            <script>
                alert("修改成功");
                window.location.href = "video_update_page.php";
            </script>
        <?php

        }
        else
        {
        ?>
            <script>
                alert("修改失败");
                //window.location.href="video_update_page.php";
            </script>
            <?php
        }
    }


    ?>
</div>
<script>
    function back() {
        window.location.href = 'video_update_page.php';
    }

    //function update()
    //	{
    //		var flagup="upd";
    //		window.location.href='video_update.php?flag='+flagup;
    //	}
</script>
</body>
</html>
