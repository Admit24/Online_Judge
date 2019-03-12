<?php
$cache_time = 30;

$OJ_CACHE_SHARE = true;

require_once('./include/cache_start.php');
require_once('./include/db_info.inc.php');
require_once('./include/memcache.php');
require_once('./include/setlang.php');

$view_title = "Welcome To Online Judge";

$result = false;

if (isset($OJ_ON_SITE_CONTEST_ID)) {
    header("location:contest.php?cid=" . $OJ_ON_SITE_CONTEST_ID);
    exit();
}

/* Main */
if (isset($OJ_ON_SITE_CONTEST_ID)) {
    header("location:contest.php?cid=" . $OJ_ON_SITE_CONTEST_ID);
    exit();
}

$view_news = "";
$sql = "select * "
    . "FROM `news` "
    . "WHERE `defunct`!='Y'"
    . "ORDER BY `importance` ASC,`time` DESC "
    . "LIMIT 50";
$result = mysql_query_cache($sql);//mysql_escape_string($sql));

if (!$result) {
    $view_news = "<h3>No News Now!</h3>";
} else {
    $view_news .= "<table width=96% style='text-align:center'>";
    if (count($result) <= 5) {
        foreach ($result as $row) {
            $view_news .= "<tr><td><td><big><b>" . "<a id='" . $row['news_id'] . "' onclick='
							 js_method(this.id);' href='viewnews.php?nid=" . $row['news_id'] . "'>" . $row['title'] . "</a>" . "</b></big>" . "</tr>";//-<small>.$row['user_id']."]-"."</small>".$row['time']
            //$view_news.= "<tr><td><td>".$row['time']."</tr>";
        }
        $view_news .= "</table>";
    } else {
        $step = 1;
        foreach ($result as $row) {
            if ($step > 5) {
                break;
            }
            $view_news .= "<tr><td><td><big><b>" . "<a id='" . $row['news_id'] . "' onclick='
							 js_method(this.id);' href='viewnews.php?nid=" . $row['news_id'] . "'>" . $row['title'] . "</a>" . "</b></big><small>" . "</tr>";//[".$row['user_id']."]-"."</small>".$row['time']
            //$view_news.= "<tr><td><td>".$row['time']."</tr>";
            $step++;
        }
        $view_news .= "<tr><a href='viewnews.php' class='font_01'>更多新闻</a></tr>";
        $view_news .= "</table>";
    }
}
$view_apc_info = "";

$sql = "SELECT UNIX_TIMESTAMP(date(in_date))*1000 md,count(1) c FROM (select * from solution order by solution_id desc limit 8000) solution  where result<13 group by md order by md desc limit 200";
$result = mysql_query_cache($sql);//mysql_escape_string($sql));
$chart_data_all = array();
//echo $sql;

foreach ($result as $row) {
    array_push($chart_data_all, array($row['md'], $row['c']));
}

$sql = "SELECT UNIX_TIMESTAMP(date(in_date))*1000 md,count(1) c FROM  (select * from solution order by solution_id desc limit 8000) solution where result=4 group by md order by md desc limit 200";
$result = mysql_query_cache($sql);//mysql_escape_string($sql));
$chart_data_ac = array();
//echo $sql;

foreach ($result as $row) {
    array_push($chart_data_ac, array($row['md'], $row['c']));
}
if (isset($_SESSION[$OJ_NAME . '_' . 'administrator'])) {
    $sql = "select avg(sp) sp from (select  count(1) sp,judgetime from solution where result>3 and judgetime>convert(now()-100,DATETIME)  group by judgetime order by sp) tt;";
    $result = mysql_query_cache($sql);
    $speed = $result[0][0];
} else {
    $speed = $chart_data_all[0][1];
}


/////////////////////////Template
require("template/" . $OJ_TEMPLATE . "/index.php");
/////////////////////////Common foot
if (file_exists('./include/cache_end.php'))
    require_once('./include/cache_end.php');
?>