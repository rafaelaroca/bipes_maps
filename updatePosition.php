<?php

// Tue Feb 13 19:11:36 -02 2018
// Rafael

// Function to get the client ip address
function get_client_ip_server() {
    $ipaddress = '';
    if ($_SERVER['HTTP_CLIENT_IP'])
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if($_SERVER['HTTP_X_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if($_SERVER['HTTP_X_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if($_SERVER['HTTP_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if($_SERVER['HTTP_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if($_SERVER['REMOTE_ADDR'])
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
 
    return $ipaddress;
}

require('senhas.php');

$con = mysqli_connect($db_host,$db_user,$db_pass);

if (!$con) {
  die('Could not connect: ' . mysqli_error());
}

mysqli_select_db($con, $db_name);

if(!isset($_GET["long"])) 
	exit;

if(!isset($_GET["lat"])) 
	exit;

if(!isset($_GET["id"])) 
	exit;

if(!isset($_GET["session"])) 
	exit;

if(!is_numeric($_GET["id"])) 
	exit;

if(!is_numeric($_GET["session"])) 
	exit;

$lat = $_GET["lat"];
$long = $_GET["long"];
$id = $_GET["id"];
$session = $_GET["session"];

echo "Session = $session <br>";

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$IP = get_client_ip_server();
echo "IP = $IP <BR>";

$qry = "UPDATE viaturas SET session=?, latitude=?, longitude=? WHERE id=?";

$userStatement = mysqli_prepare($con, $qry);
mysqli_stmt_bind_param($userStatement, 'ssss', $session, $lat, $long, $id);
mysqli_stmt_execute($userStatement);
$result = mysqli_stmt_get_result($userStatement);

echo "<BR>R: $result";

mysqli_close($con);

?>


