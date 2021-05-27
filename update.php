<?php
	require_once "bd.php";

	if(!isset($_GET["session"])) 
		exit;

	if(!is_numeric($_GET["session"])) 
		exit;

	$session = $_GET["session"];

	$sql = "SELECT * FROM viaturas WHERE latitude is not NULL and longitude is not null and latitude <> 0 and longitude <> 0 AND session=$session";
	$result = mysqli_query($con, $sql);

	$array=array();

	while ($user=mysqli_fetch_assoc($result)) {
		// for testing update lat ,lng manually
		$id=$user['id'];
		$nome=$user['nome'];
		$lat=$user['latitude'];
		$lon=$user['longitude'];
		$info=$user['info'];
		$tipo=$user['tipo'];
		$s1=$user['s2'];
		$logotipo=$user['logotipo'];

		$array[$user['id']]['id']=$id;
		$array[$user['id']]['info']=$nome;
		//$array[$user['id']]['info']=$info . ' (' . $nome . ')';// . '\r' . $info; //'<b>'.$nome.'</b>';
		$array[$user['id']]['nome']=$nome;
		$array[$user['id']]['info2']=$info;
		$array[$user['id']]['lat']=$user['latitude'];
		$array[$user['id']]['lng']=$user['longitude'];
		$array[$user['id']]['icon']=$logotipo;

		if ($tipo == 2) {
			$sql = "SELECT * FROM viaturas WHERE session=$session AND id=$id";
			$result2 = mysqli_query($con, $sql);

			$x=0;
			while ($row2=mysqli_fetch_assoc($result2)) {
				$x=$row2['altura_sensor_cm'];
			}


			$sql = "SELECT * FROM sensors WHERE session=$session AND id_local=$id ORDER BY ts DESC LIMIT 1";
			$result2 = mysqli_query($con, $sql);

			$s1=-1;
			while ($row2=mysqli_fetch_assoc($result2)) {
				$y=$row2['s2'];
				$s1=$x-$y;
				if ($s1 < 0)
					$s1 = 0;
				$ts=$row2['ts'];
			}
			$array[$user['id']]['info']=$info;
			//$array[$user['id']]['info']=$s1 . ' / ' . $info . ' (' . $nome . " $ts )";// . '\r' . $info; //'<b>'.$nome.'</b>';

			if ($s1 >= 100) { 
				$array[$user['id']]['tipo']=3;
				$array[$user['id']]['info']= " )";
			}
			else
				$array[$user['id']]['tipo']=$user['tipo'];
		} else
			$array[$user['id']]['tipo']=$user['tipo'];
}
echo json_encode($array); //result return in json form
exit;

echo '
{
    "1": {
        "info": "Info1",
        "lat": "-22.0399",
        "lng": "-47.91"
    },
    "2": {
        "info": "Info2",
        "lat": "-22.0201",
        "lng": "-47.9012"
    },
    "3": {
        "info": "Info334",
        "lat": "-22.01",
        "lng": "-47.9"
}}

';
exit;
echo "
{
[1] => Array
(
[info] => <b>user1</b>
[lat] => 22.399304
[lng] => 75.1763525
)
[2] => Array
(
[info] => <b>user2</b>
[lat] => 22.1597120
[lng] => 75.1732723
)
[3] => Array
(
[info] => <b>user3</b>
[lat] => 22.1630125
[lng] => 75.1770120
)}";
       
?>

