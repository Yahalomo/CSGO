<?php
@include_once('set.php');
$link = urldecode($_GET["link"]);
$steamid = $_GET["steamid"];
echo $link."<br>".$steamid;
mysql_query("UPDATE users SET tradelink='$link' WHERE steamid='$steamid'") or die(logsqlerror(mysql_error()));
Header("Location: /");
exit;
?>