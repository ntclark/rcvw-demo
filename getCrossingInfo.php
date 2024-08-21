<?php

$db = new PDO("sqlsrv:Server=rcvw-db-server.database.windows.net;Database=rcvw-db", "dba", "B@ttelle");

$answerText = "[";

$row = $db -> query("SELECT * FROM [HRI_CROSSINGS] WHERE [CrossingID] = '$_GET[crossingID]'") -> fetch();

$answerText .= '["CrossingID","' .$row["CrossingID"] . '"],';
$answerText .= '["StateName","' . $row["StateName"] . '"],';
$answerText .= '["CountyName","' . $row["CountyName"] . '"],';
$answerText .= '["CityName","' . $row["CityName"] . '"],';
$answerText .= '["Street","' . $row["Street"] . '"],';
$answerText .= '["Railroad","' . $row["Railroad"] . '"],';

if ( $row['PreemptionStatus'] == '1' )
    $answerText .= '["Status","Active"],';
else
    $answerText .= '["Status","Not Active"],';

if ( $row['RBSOperational'] == '1' )
    $answerText .= '["Comms","Operational"]';
else
    $answerText .= '["Comms","Not Operational"]';

echo $answerText . ']';

?>