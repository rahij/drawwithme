<?php
include "config.php";
$con = mysql_connect("localhost",$username,$password);
mysql_select_db("draw", $con);

$param = $_POST;
$sessions_id = $param['sessions_id'];
$x1 = $param['x1'];
$x2 = $param['x2'];
$y1 = $param['y1'];
$y2 = $param['y2'];

$query = mysql_query("INSERT INTO `lines` (sessions_id, x1, y1, x2, y2) 
	VALUES ('$sessions_id', '$x1', '$y1', '$x2', '$y2')");
if(!$query) echo mysql_error();
?>