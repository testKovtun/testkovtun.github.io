<?php
Error_Reporting(E_ALL & ~E_NOTICE);
include('config.inc.php');
if (!extension_loaded("gd")) {
    echo 'не загружен модуль GD';
     exit;
} 
$ip = (isset($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : false;
$date = date("Y-m-d");
$cookie = addslashes($today_hosts);
$referer = addslashes($r);
$screen = addslashes($screen);
$java = addslashes($je);
$browser = addslashes($na);
$page = addslashes($p);
$result = mysql_query("insert into kscount values ('".$ip."', '".$cookie."', 
                '".$referer."', '".$screen."', '".$java."', '".$browser."', 
                '".$page."', '".$date."')");
$result3 = mysql_query("update countall set countall = countall + 1");
$result2 = mysql_query("select countall from countall");
$num_results2 = mysql_num_rows($result2);
for ($i = 0; $i<$num_results2; $i++) {
    $row = mysql_fetch_array($result2);
    $all_hits = htmlspecialchars(stripslashes($row["countall"]));
}
$result4 = mysql_query("select * from kscount where date='$date'");
$today_hits = mysql_num_rows($result4);
$result5 = mysql_query("select distinct usip from kscount where date='$date'");
$today_hosts = mysql_num_rows($result5);
if (strlen($all_hits)>15||!isset($all_hits)) $all_hits = "?";
if (strlen($today_hits)>15||!isset($today_hits)) $today_hits = "?";
if (strlen($today_hosts)>15||!isset($today_hosts)) $today_hosts = "?";
    header("Expires: Mon, 25 Jul 2005 10:00:00 GMT");
    header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Content-type: image/gif\n\n");
$image = ImageCreateFromGIF("./counter.gif");
$color = ImageColorAllocate($image, 0,0,255);
$color2 = ImageColorAllocate($image,255,255,255);
ImageString($image,1,2,2,"$all_hits",$color2);
ImageString($image,1,2,13,"$today_hits",$color);
ImageString($image,1,2,21,"$today_hosts",$color);
ImageGIF($image);
imagedestroy($image);
?>