<?php
require_once("phpchart/conf.php");
include 'adodb5/adodb.inc.php';
$db = newADOConnection('mysqli');
$db->connect('localhost', 'root', 'bigthinker', 'feeltree');
$db->Execute('SET NAMES UTF8');

$sql="SELECT yaw,pitch,roll from treedata WHERE sensorid=1 ORDER BY id";
$rs=$db->Execute($sql);
$rows=$rs->getRows();

$yaw=array();
$pitch=array();
$roll=array();
foreach($rows as $value)
{
	$yaw[]=$value['yaw']*100;
	$pitch[]=abs($value['pitch']*100);
	$roll[]=abs($value['roll']*100);
}

//print_r($yaw);

?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>phpChart - Basic Chart</title>
</head>
<body>
    
<?php
$pc = new C_PhpChartX(array($yaw,$pitch,$roll),'basic_chart');
$pc->draw();
?>

</body>
</html>