<?php
include 'adodb5/adodb.inc.php';
$db = newADOConnection('mysqli');
$db->connect('localhost', 'root', 'bigthinker', 'feeltree');
$db->Execute('SET NAMES UTF8');

$starttime=mktime(0, 0, 0, 4, 29, 2017) * 1000;
//echo "start=".$starttime;
//echo "<br>";

$endtime=mktime(0, 0, 0, 5, 1, 2017) * 1000;
//echo "end=".$endtime;
//echo "<br>";

$nowtime=time()*1000;
//echo "now=".$nowtime;
//echo "<br>";

$url="http://weather.tp.edu.tw/Ajax/jsonp/alltables.ashx?callback=weatherselected&weather=%E6%9C%80%E5%A4%A7%E9%A2%A8%E9%80%9F&by=hour&start=".$starttime."&end=".$endtime."&_=".$nowtime;
//echo $url;

$json=file_get_contents($url);

//echo $json;

$json = str_replace("weatherselected(","",$json);
$json = str_replace(");","",$json);

//echo $json;

$jsonarr=json_decode($json);

//print_r($jsonarr->{'result'});

foreach($jsonarr->{'result'} as $obj)
{
	foreach($obj as $value) 
	{
	
		if(!empty($value->{'value'})) {
			
			$sql="SELECT * FROM wind WHERE schoolid=".$db->Quote($value->{'id'});
			$sql.=" AND start=".$db->Quote(date("Y-m-d H:00:00",$value->{'start'}/1000));
			//echo $sql."\n";
			$rs=$db->Execute($sql);
			
			if($rs->RecordCount()==0)
			{
				$record=array();
				$record["schoolid"] = $value->{'id'};
				$record["school"] = $value->{'school'};
				$record["name"] = $value->{'name'};
				$record["value2"] = $value->{'value'};
				$record["start"] = $value->{'start'}/1000;
				$record["end"] = $value->{'end'}/1000;
				 
				$db->AutoExecute("wind",$record,'INSERT');

				print $value->{'id'};
				echo ",";
				print $value->{'school'};
				echo ",";
				print $value->{'name'};
				echo ",";
				print $value->{'value'};
				echo ",";
				print $value->{'start'};
				echo ",";
				print $value->{'end'};
				echo "\n";

			}

		}
		
	}
}

?>