<?php

$db = new PDO("sqlsrv:Server=rcvw-db-server.database.windows.net;Database=rcvw-db", "dba", "B@ttelle");

$crossingID = $_GET["crossingID"];
$status = $_GET["status"];
$crossingField = $_GET["field"];

$sql = "SELECT [HRI_ID] FROM [HRI_CROSSING_HEADER] WHERE [CrossingID] = '" . $crossingID . "'";

$row = $db -> query($sql) -> fetch();

$sql = "UPDATE [HRI_ACTIVATION_STATUS] SET [" . $crossingField . "] = '" . $status . "' WHERE [HRI_ID] = '" . $row[0] . "'";

$db -> exec($sql);

echo $sql;

?>