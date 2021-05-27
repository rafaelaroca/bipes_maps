<?php

require('senhas.php');

$con = mysqli_connect($db_host,$db_user,$db_pass);

if (!$con) {
  die('Could not connect: ' . mysqli_error());
}

mysqli_select_db($con, $db_name);

if(!isset($_GET["session"])) {
	echo "Must specify session";
	exit;
}

if(!is_numeric($_GET["session"])) {
	echo "Must specify numeric session";
	exit;
}

$session = $_GET["session"];

echo "Session = $session <br>";

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$qry = "DELETE FROM viaturas WHERE session = ?";
$userStatement = mysqli_prepare($con, $qry);
mysqli_stmt_bind_param($userStatement, 'i', $session);
mysqli_stmt_execute($userStatement);
$result = mysqli_stmt_get_result($userStatement);

echo "<BR>Done<br>";

mysqli_close($con);
?>
