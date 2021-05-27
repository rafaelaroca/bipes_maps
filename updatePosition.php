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



echo ".";
//Uso
//https://ain.ufscar.br/map/sensors/envio.php?id=1&leitura=1

if(!isset($_GET["long"])) 
	exit;

if(!isset($_GET["lat"])) 
	exit;

if(!isset($_GET["id"])) 
	exit;

if(!isset($_GET["session"])) 
	exit;



echo "Variaves OK <br>";

if(!is_numeric($_GET["id"])) 
	exit;

if(!is_numeric($_GET["session"])) 
	exit;



$lat = $_GET["lat"];
$long = $_GET["long"];
$id = $_GET["id"];
$session = $_GET["session"];

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

echo "IP = $IP <BR>";
$sql = "UPDATE viaturas SET session=$session, latitude=$lat, longitude=$long WHERE id=$id";
//echo $sql;

if (mysqli_query($con, $sql)) {
    echo "Sucesso!";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($con);
?>
