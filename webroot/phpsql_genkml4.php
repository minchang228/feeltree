<?php
include 'adodb5/adodb.inc.php';
$db = newADOConnection('mysqli');
$db->connect('localhost', 'root', 'bigthinker', 'feeltree');
$db->Execute('SET NAMES UTF8');

// Creates the Document.
$dom = new DOMDocument('1.0', 'UTF-8');

// Creates the root KML element and appends it to the root document.
$node = $dom->createElementNS('http://earth.google.com/kml/2.1', 'kml');
$parNode = $dom->appendChild($node);

// Creates a KML Document element and append it to the KML element.
$dnode = $dom->createElement('Document');
$docNode = $parNode->appendChild($dnode);

// Creates the two Style elements, one for restaurant and one for bar, and append the elements to the Document element.
$restStyleNode = $dom->createElement('Style');
$restStyleNode->setAttribute('id', 'restaurantStyle');
$restIconstyleNode = $dom->createElement('IconStyle');
$restIconstyleNode->setAttribute('id', 'restaurantIcon');
$restIconNode = $dom->createElement('Icon');
$restHref = $dom->createElement('href', 'http://www.big-thinker.co/image/tree.png');
$restIconNode->appendChild($restHref);
$restIconstyleNode->appendChild($restIconNode);
$restStyleNode->appendChild($restIconstyleNode);
$docNode->appendChild($restStyleNode);

$restStyleNode = $dom->createElement('Style');
$restStyleNode->setAttribute('id', 'restaurant0Style');
$restIconstyleNode = $dom->createElement('IconStyle');
$restIconstyleNode->setAttribute('id', 'restaurant0Icon');
$restIconNode = $dom->createElement('Icon');
$restHref = $dom->createElement('href', 'http://www.big-thinker.co/image/tree0.png');
$restIconNode->appendChild($restHref);
$restIconstyleNode->appendChild($restIconNode);
$restStyleNode->appendChild($restIconstyleNode);
$docNode->appendChild($restStyleNode);

$restStyleNode = $dom->createElement('Style');
$restStyleNode->setAttribute('id', 'restaurant1Style');
$restIconstyleNode = $dom->createElement('IconStyle');
$restIconstyleNode->setAttribute('id', 'restaurant1Icon');
$restIconNode = $dom->createElement('Icon');
$restHref = $dom->createElement('href', 'http://www.big-thinker.co/image/tree1.png');
$restIconNode->appendChild($restHref);
$restIconstyleNode->appendChild($restIconNode);
$restStyleNode->appendChild($restIconstyleNode);
$docNode->appendChild($restStyleNode);

$restStyleNode = $dom->createElement('Style');
$restStyleNode->setAttribute('id', 'restaurant2Style');
$restIconstyleNode = $dom->createElement('IconStyle');
$restIconstyleNode->setAttribute('id', 'restaurant2Icon');
$restIconNode = $dom->createElement('Icon');
$restHref = $dom->createElement('href', 'http://www.big-thinker.co/image/tree2.png');
$restIconNode->appendChild($restHref);
$restIconstyleNode->appendChild($restIconNode);
$restStyleNode->appendChild($restIconstyleNode);
$docNode->appendChild($restStyleNode);

$restStyleNode = $dom->createElement('Style');
$restStyleNode->setAttribute('id', 'restaurant3Style');
$restIconstyleNode = $dom->createElement('IconStyle');
$restIconstyleNode->setAttribute('id', 'restaurant3Icon');
$restIconNode = $dom->createElement('Icon');
$restHref = $dom->createElement('href', 'http://www.big-thinker.co/image/tree3.png');
$restIconNode->appendChild($restHref);
$restIconstyleNode->appendChild($restIconNode);
$restStyleNode->appendChild($restIconstyleNode);
$docNode->appendChild($restStyleNode);

$restStyleNode = $dom->createElement('Style');
$restStyleNode->setAttribute('id', 'restaurant4Style');
$restIconstyleNode = $dom->createElement('IconStyle');
$restIconstyleNode->setAttribute('id', 'restaurant4Icon');
$restIconNode = $dom->createElement('Icon');
$restHref = $dom->createElement('href', 'http://www.big-thinker.co/image/tree4.png');
$restIconNode->appendChild($restHref);
$restIconstyleNode->appendChild($restIconNode);
$restStyleNode->appendChild($restIconstyleNode);
$docNode->appendChild($restStyleNode);

$restStyleNode = $dom->createElement('Style');
$restStyleNode->setAttribute('id', 'restaurant5Style');
$restIconstyleNode = $dom->createElement('IconStyle');
$restIconstyleNode->setAttribute('id', 'restaurant5Icon');
$restIconNode = $dom->createElement('Icon');
$restHref = $dom->createElement('href', 'http://www.big-thinker.co/image/tree5.png');
$restIconNode->appendChild($restHref);
$restIconstyleNode->appendChild($restIconNode);
$restStyleNode->appendChild($restIconstyleNode);
$docNode->appendChild($restStyleNode);

$restStyleNode = $dom->createElement('Style');
$restStyleNode->setAttribute('id', 'restaurant6Style');
$restIconstyleNode = $dom->createElement('IconStyle');
$restIconstyleNode->setAttribute('id', 'restaurant6Icon');
$restIconNode = $dom->createElement('Icon');
$restHref = $dom->createElement('href', 'http://www.big-thinker.co/image/tree6.png');
$restIconNode->appendChild($restHref);
$restIconstyleNode->appendChild($restIconNode);
$restStyleNode->appendChild($restIconstyleNode);
$docNode->appendChild($restStyleNode);

$restStyleNode = $dom->createElement('Style');
$restStyleNode->setAttribute('id', 'restaurant7Style');
$restIconstyleNode = $dom->createElement('IconStyle');
$restIconstyleNode->setAttribute('id', 'restaurant7Icon');
$restIconNode = $dom->createElement('Icon');
$restHref = $dom->createElement('href', 'http://www.big-thinker.co/image/tree7.png');
$restIconNode->appendChild($restHref);
$restIconstyleNode->appendChild($restIconNode);
$restStyleNode->appendChild($restIconstyleNode);
$docNode->appendChild($restStyleNode);

$barStyleNode = $dom->createElement('Style');
$barStyleNode->setAttribute('id', 'barStyle');
$barIconstyleNode = $dom->createElement('IconStyle');
$barIconstyleNode->setAttribute('id', 'barIcon');
$barIconNode = $dom->createElement('Icon');
$barHref = $dom->createElement('href', 'http://maps.google.com/mapfiles/kml/pal2/icon27.png');
$barIconNode->appendChild($barHref);
$barIconstyleNode->appendChild($barIconNode);
$barStyleNode->appendChild($barIconstyleNode);
$docNode->appendChild($barStyleNode);

$sql="SELECT id,schoolname,lat,lng FROM school";
$rs=$db->Execute($sql);
$rows=$rs->getRows();

foreach($rows as $key=>$value) 
{
	$sql="SELECT wind.value2,wind.start FROM wind";
	$sql.=" WHERE school=".$db->Quote($value['schoolname']);
	$sql.=" ORDER BY wind.start DESC";
	$sql.=" LIMIT 0,1";
	$rs=$db->Execute($sql);
	$row=$rs->fetchRow();
	$rows[$key]['value2']=$row['value2'];
	$rows[$key]['start']=$row['start'];

}

// Iterates through the MySQL results, creating one Placemark for each row.
foreach ($rows as $row)
{
	$row['type']="restaurant".floor($row['value2']);
  // Creates a Placemark and append it to the Document.

  $node = $dom->createElement('Placemark');
  $placeNode = $docNode->appendChild($node);

  // Creates an id attribute and assign it the value of id column.
  $placeNode->setAttribute('id', 'placemark' . $row['id']);

  // Create name, and description elements and assigns them the values of the name and address columns from the results.
  $nameNode = $dom->createElement('name',htmlentities($row['schoolname']));
  $placeNode->appendChild($nameNode);
  $descNode = $dom->createElement('description', "最大風速: ".$row['value2']." m/s\n"."時間: ".$row['start']);
  $placeNode->appendChild($descNode);
  $styleUrl = $dom->createElement('styleUrl', '#' . $row['type'] . 'Style');
  $placeNode->appendChild($styleUrl);

  // Creates a Point element.
  $pointNode = $dom->createElement('Point');
  $placeNode->appendChild($pointNode);

  // Creates a coordinates element and gives it the value of the lng and lat columns from the results.
  $coorStr = $row['lng'] . ','  . $row['lat'];
  $coorNode = $dom->createElement('coordinates', $coorStr);
  $pointNode->appendChild($coorNode);
}

$kmlOutput = $dom->saveXML();
header('Content-type: application/vnd.google-earth.kml+xml');
echo $kmlOutput;

?>