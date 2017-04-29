<?php
include 'adodb5/adodb.inc.php';
$db = newADOConnection('mysqli');
$db->connect('localhost', 'root', 'bigthinker', 'feeltree');
$db->Execute('SET NAMES UTF8');

$record=array();
$record["sensorid"] = $_GET['sensorid'];
$record["yaw"] = $_GET['yaw'];
$record["pitch"] = $_GET['pitch'];
$record["roll"] = $_GET['roll'];
$record["cdate"] = time();

$db->AutoExecute("treedata",$record,'INSERT');

// http://www.big-thinker.co/getdata.php?sensorid=1&yaw=1.11&pitch=-2.22&roll=3.33
?>