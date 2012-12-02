<?php
include "config.php";
$con = mysql_connect("localhost",$username,$password);
mysql_select_db("draw", $con);


$query = mysql_query("select * from `lines` where sessions_id =" . $_GET["id"]);
if(!$query) echo mysql_error();

$lines = null;
	while($row = mysql_fetch_assoc($query))
		$lines[] = $row;

	print_r(json_encode($lines));
?>