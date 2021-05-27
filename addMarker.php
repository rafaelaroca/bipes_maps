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

if(!isset($_GET["name"])) 
	exit;

if(!isset($_GET["session"])) 
	exit;



echo "Variaves OK <br>";

if(!is_numeric($_GET["session"])) 
	exit;


$lat = $_GET["lat"];
$long = $_GET["long"];
$name = $_GET["name"];
$session = $_GET["session"];
$info = $_GET["info"];
$icon = $_GET["icon"];

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$IP = get_client_ip_server();
echo "IP = $IP <BR>";

//Unsafe
/*
$sql = "INSERT INTO viaturas(nome,longitude,latitude,session) VALUES(\"$name\", $long, $lat, $session)";

if (mysqli_query($con, $sql)) {
    echo "<BR>Sucesso!";
} else {
    echo "<BR>Error: " . $sql . "<br>" . mysqli_error($conn);
}
 */


//Safe
$qry = "INSERT INTO viaturas(nome,longitude,latitude,session,info,logotipo) VALUES(?,?,?,?,?,?)";
$userStatement = mysqli_prepare($con, $qry);
mysqli_stmt_bind_param($userStatement, 'ssssss', $name,$long, $lat, $session, $info, $icon);
mysqli_stmt_execute($userStatement);
$result = mysqli_stmt_get_result($userStatement);

echo "<BR>R: $result";

mysqli_close($con);
?>
