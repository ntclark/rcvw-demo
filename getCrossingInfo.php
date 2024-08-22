<?php

$db = new PDO("sqlsrv:Server=rcvw-db-server.database.windows.net;Database=rcvw-db", "dba", "B@ttelle");

$answerText = "[";

$row = $db -> query("SELECT * FROM [HRI_CROSSINGS] WHERE [CrossingID] = '$_GET[crossingID]'") -> fetch();

$answerText .= '["CrossingID","' .$row["CrossingID"] . '"],';
$answerText .= '["CityName","' . $row["CityName"] . '"],';
$answerText .= '["CountyName","' . $row["CountyName"] . '"],';
$answerText .= '["Street","' . $row["Street"] . '"],';
$answerText .= '["Highway","' . $row["Highway"] . '"],';
$answerText .= '["RailroadCode","' . $row["RailroadCode"] . '"],';

if ( $row['PreemptionStatus'] == '1' )
    $answerText .= '["PreemptionStatus","Active",1],';
else
    if ( $row['PreemptionStatus'] == '' )
        $answerText .= '["PreemptionStatus","unknown",-1],';
    else
        $answerText .= '["PreemptionStatus","Not Active",0],';

if ( $row['RBSOperational'] == '1' )
    $answerText .= '["RBSOperational","Operational",1],';
else
    if ( $row['RBSOperational'] == '' )
        $answerText .= '["RBSOperational","unknown",-1],';
    else
        $answerText .= '["RBSOperational","Not Operational",0],';

$answerText .= '["PolCont","' .$row["PolCont"] . '"],';
$answerText .= '["RrCont","' . $row["RrCont"] . '"],';
$answerText .= '["Latitude","' . number_format($row["Latitude"],4) . '"],';
$answerText .= '["Longitude","' . number_format($row["Longitude"],4) . '"],';
$answerText .= '["LrsMilePost","' . $row["LrsMilePost"] . '"],';
$answerText .= '["HwynDist","' . $row["HwynDist"] . '"],';
$answerText .= '["HwySpeed","' . $row["HwySpeed"] . '"],';

$crossingAngle = $row["XAngle"];

$angleText = "";

if ( "1" == $crossingAngle )
    $angleText = "0 - 29 deg";
else if ( "2" == $crossingAngle )
    $angleText = "30 - 59 deg";
else if ( "3" == $crossingAngle )
    $angleText = "69 - 90 deg";
else 
    $angleText = "unknown";

$answerText .= '["Crossing Angle","' . $angleText . '"],';

$crossingPosition = $row["PosXing"];

$anglePos = "";

if ( "1" == $crossingPosition )
    $anglePos = "At Grade";
else if ( "2" == $crossingPosition )
    $anglePos = "Under Railroad";
else if ( "3" == $crossingPosition )
    $anglePos = "Over Railroad";
else 
    $anglePos = "unknown";

$answerText .= '["Crossing Position","' . $anglePos . '"],';

$flashText = "";
if ( '' == $row["FlashOth"] || empty($row["FlashOth"]) )
    $flashText = "None";
else if ( 0 < $row["FlashOth"] )
   $flashText = $row["FlashOth"];

$answerText .= '["GateConf","' . ('' == $row["GateConf"] ? "No" : "Yes") . '"],';
$answerText .= '["FlashPost","' .('' == $row["FlashPost"] ? "No" : "Yes") . '"],';
$answerText .= '["FlashOth","' . $flashText . '"],';

$answerText = substr($answerText,0,strlen($answerText) - 1);

echo $answerText . ']';

?>