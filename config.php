<?php

//URL onde o sistema esta instalado
global $URL;
$URL = "https://bipes.net.br/map";

require('senhas.php');

global $con;
$con = mysqli_connect($db_host, $db_user, $db_pass) or trigger_error("Erro ao acessar o Banco de Dados: " . mysqli_error($con));

mysqli_select_db($con, $db_name) or trigger_error("Erro ao acessar o banco de dados: " . mysqli_error($con));

//mysqli_set_charset(con, "utf-8");


// default the error variable to empty.
$_SESSION['error'] = "";

// declare $sOutput so we do not have to do this on each page.
$sOutput="";

$page=basename($_SERVER['PHP_SELF']);


