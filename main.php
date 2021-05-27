<!doctype html>
<head>
<link rel="stylesheet" type="text/css" href="map.css">
<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
</head>

<?php
require('config.php');

if(!isset($_GET["session"]))  {
		echo "<br>Please, specify a valid session. For example: <a href=main.php?session=1>main.php?session=1</a>";
	exit;
}

if(!is_numeric($_GET["session"])) {
		echo "<br>Please, specify a valid session. For example: <a href=main.php?session=1>main.php?session=1</a>";
	exit;
}


$session = $_GET["session"];


$sOutput .= '<div id="index-body">';


if ($con) {
	$query="set names utf8";
	$result=mysqli_query($con,$query);

}

$sOutput .= '</div>';

echo $sOutput;


?>

<script>
function centro(){
	var arizonaCoor = new google.maps.LatLng(-22.02, -47.8912);
	var zoomLevel = 16; //The higher the zoomLevel means zoom in at a higher resolution
	map.setCenter(arizonaCoor, zoomLevel);
	map.setZoom(zoomLevel);
}
function centroG(){
	var arizonaCoor = new google.maps.LatLng(-22.02, -47.8912);
	var zoomLevel = 14; //The higher the zoomLevel means zoom in at a higher resolution
	map.setCenter(arizonaCoor, zoomLevel);
	map.setZoom(zoomLevel);
}
function UFSCar(){
	var arizonaCoor = new google.maps.LatLng(-21.988, -47.8786);
	var zoomLevel = 15; //The higher the zoomLevel means zoom in at a higher resolution
	map.setCenter(arizonaCoor, zoomLevel);
	map.setZoom(zoomLevel);
}
</script>


<input type="checkbox" checked value="viaturas" onchange="toggleCheckboxV(this)">Layer 1 (dynamic markers)
<input type="checkbox" checked value="cameras" onchange="toggleCheckboxC(this)">Layer 2 (static markers)
<input type="checkbox" checked value="sensores" onchange="toggleCheckboxS(this)">Layer 3

| Center map:
<button onclick="centro()">Sao Carlos City Center</button>
<button onclick="UFSCar()">UFSCar</button>

<a href=doc.html>Documentation</a>
|
<a href=/map/crud/index.php/main/static>Static markers</a>
|
<a href=/map/crud/index.php/main/dynamic>Dynamic markers</a>


<script>
function toggleCheckboxV(element)
 {
   if (element.checked)
	myLayers.set('viaturas',map);
   else
	myLayers.set('viaturas',null);

 }

function toggleCheckboxS(element)
 {
   if (element.checked)
	myLayers.set('sensores',map);
   else
	myLayers.set('sensores',null);

 }


function toggleCheckboxC(element)
 {
   if (element.checked)
	myLayers.set('cameras',map);
   else
	myLayers.set('cameras',null);

 }


</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAibRD04Ik3Wzc9YkjUqzq97gfs6dTNioI&region=br&language=pt_br"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.3/jquery.min.js"></script>

<div id="map_canvas" style="border: 2px solid #3872ac; "></div>

<script>


<?php
	require_once "bd.php";

	echo '
	var locations = [';

	$arr = array("sensores", "cameras", "veiculos");

	foreach ($arr as $value) {

		$sql = "SELECT * FROM $value WHERE session=$session AND latitude is not NULL and longitude is not null and latitude <> 0 and longitude <> 0";
		}

		$result = mysqli_query($con, $sql);

		if ($value === "sensores")
			$x=0;
		if ($value === "cameras")
			$x=1;
		if ($value === "veiculos")
			$x=2;


		if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)) {

				$sigla=$row["nome"];
				$lat=$row["latitude"];
				$long=$row["longitude"];
				$siteT=$row["site"];
				$logotipo=$row["logotipo"];
				if (strlen($logotipo) > 4) {
					$logotipo2="$URL/crud/assets/uploads/files/" . $logotipo;
				}
				else {
					$logotipo2="$URL/cam.png";
				}

				if (substr($site,0,4) == "http") {
					$site = $siteT;
				}
				else
					$site = "http://" . $siteT;

				echo "['$sigla','$value','$site',$lat,$long,'$logotipo2','$x'],";
			}
		}


//		var locations = '[
// [\'CMCF-Wall-E\', \'Rio Branco, Acre\', \'blank\', -9.967, -67.821, \'AC\', \'2\'],
// [\'Equipe de garagem: Irobots A\', \'Ourinhos, São Paulo\', \'https://www.facebook.com/EquipeiRobots\', -22.971, -49.864, \'SP\', \'11\'],

//];';
echo '];';

        
?>


//Rafael - 30/11 - Viaturas
var locations2 = {}; //A repository for markers (and the data from which they were contructed).
//initial data set for markers
//
var locs = {
1: {
info: 'vtr1',
lat: -21.9879,
lng: -47.88
},
2: {
info: 'vtr2',
lat: -22.7149,
lng: -47.8432
},
3: {
info: 'vtr3',
lat: -22.7190,
lng: -47.8972
}
};


//Fim Rafael - 30/11 - Viaturas




var map;
var myLayers;
var bounds = new google.maps.LatLngBounds();

function initialize() {
  map = new google.maps.Map(
    document.getElementById("map_canvas"), {
      center: new google.maps.LatLng(37.4419, -122.1419),
      zoom: 13,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

	myLayers=new google.maps.MVCObject();
	myLayers.setValues({cameras:map,sensores:null,viaturas:null});
	myLayers.setValues({cameras:map,sensores:map,viaturas:map});

  for (i = 0; i < locations.length; i++) {


    geocodeAddress(locations, i);
  }

//}


//google.maps.event.addDomListener(window, "load", initialize);

//Rafael ----------------------------------



function setMarkers(locObj) {
	$.each(locObj, function (key, loc) {
		if (!locations2[key] && loc.lat !== undefined && loc.lng !== undefined) {
		//alert("set" + loc.lat);
		//Marker has not yet been made (and there's enough data to create one).
		//Create marker
		
		var iconeA = {
		    url: 'car.png',
		    scaledSize: new google.maps.Size(50,50), // scaled size
		    origin: new google.maps.Point(0,0), // origin
		    labelOrigin: new google.maps.Point(22,50), // origin
		    anchor: new google.maps.Point(0, 0) // anchor
		};


		loc.marker = new google.maps.Marker({
		position: new google.maps.LatLng(loc.lat, loc.lng),
		icon: iconeA, //Marker icon).
		map: map,
		title: loc.info,
		label: loc.info,
		animation: google.maps.Animation.DROP
		});

   loc.marker.bindTo('map',myLayers,'viaturas');


	bounds.extend(loc.marker.getPosition());
        map.fitBounds(bounds);


		//alert(loc.lat + " / " + loc.lng);


		var infowindow = new google.maps.InfoWindow();
		infowindow.setContent('<span style="color:#EA2E49;font-weight:bold">'+loc.info+'<br><a href=#>LINK 1</a><br><br><a href=>LINK 2</a>');
		//infowindow.open(map, loc.marker);
		//Attach click listener to marker
		google.maps.event.addListener(loc.marker, 'click', (function (key) {
		return function () {
		infowindow.setContent('<b><center>' + locations2[key].nome +'</b><br>' + locations2[key].info2 + '</center><br><a href=#>LINK 1</a><br><br><a href=#&id=' + locations2[key].id + ' target=_blank>LINK 2</a>');
		infowindow.open(map, locations2[key].marker);
		}
		})(key));

		//Remember loc in the `locations` so its info can be displayed and so its marker can be deleted.
		locations2[key] = loc;
		} else if (locations2[key] && loc.remove) {
		//Remove marker from map
		if (locations2[key].marker) {
		locations2[key].marker.setMap(null);
		}
		//Remove element from 'locations'
		delete locations2[key];
		} else if (locations2[key]) {
		//Update the previous data object with the latest data.
		$.extend(locations2[key], loc);
		if (loc.lat !== undefined && loc.lng !== undefined) {

		//Update marker position (maybe not necessary but doesn't hurt).
		locations2[key].marker.setPosition(
			new google.maps.LatLng(loc.lat, loc.lng));
		}
		locations2[key].marker.setLabel(loc.info);

		var iconeA = {
		    url: loc.icon,
		    scaledSize: new google.maps.Size(50,50), // scaled size
		    origin: new google.maps.Point(0,0), // origin
		    labelOrigin: new google.maps.Point(22,50), // origin
		    anchor: new google.maps.Point(0, 0) // anchor
		};

		if (loc.tipo == 1)
			iconeA.url = 'car.png';
		if (loc.tipo == 2)
			iconeA.url = 'rio.png';
		if (loc.tipo == 3)
			iconeA.url = 'alert.gif';
		if (loc.icon == null) {
			iconeA.url = 'car.png';
}
		else
			iconeA.url = 'https://bipes.net.br/map/crud/assets/uploads/files/' + loc.icon;

		iconeA.url = loc.icon;
		//iconeA.url = 'https://static.thenounproject.com/png/268826-200.png';

		locations2[key].marker.setIcon(iconeA);

		//locations[key].info looks after itself.
		}
		});
	}

var ajaxObj = { //Object to save cluttering the namespace.
	options: {
	url: "update.php?session=<?php echo $session;?>", //The resource that delivers loc data.
	dataType: "json" //The type of data tp be returned by the server.
	},
	delay: 1000, //(milliseconds) the interval between successive gets.
	errorCount: 0, //running total of ajax errors.
	errorThreshold: 5, //the number of ajax errors beyond which the get cycle should cease.
	ticker: null, //setTimeout reference - allows the get cycle to be cancelled with clearTimeout(ajaxObj.ticker);
	get: function () { //a function which initiates
	if (ajaxObj.errorCount < ajaxObj.errorThreshold) {
	ajaxObj.ticker = setTimeout(getMarkerData, ajaxObj.delay);
	}
	},
	fail: function (jqXHR, textStatus, errorThrown) {
		console.log(errorThrown);
		ajaxObj.errorCount++;
	}
	};

//Ajax master routine
function getMarkerData() {
	$.ajax(ajaxObj.options)
	.done(setMarkers) //fires when ajax returns successfully
	.fail(ajaxObj.fail) //fires when an ajax error occurs
	.always(ajaxObj.get); //fires after ajax success or ajax error
}

//setMarkers(locs); //Create markers from the initial data set served with the document.
ajaxObj.get(); //Start the get cycle.


}


google.maps.event.addDomListener(window, "load", initialize);



//Fim rafael ----------------------------

function geocodeAddress(locations, i) {
  var title = locations[i][0];
  var address = locations[i][1];
  var url = locations[i][2];
  var nivel = locations[i][6];
  var iconeC = locations[i][5];

	k = isNaN(locations[i][3]);
	if (k) return;
	m = isNaN(locations[i][4]);
	if (m) return;

	var p = new google.maps.LatLng(locations[i][3], locations[i][4]);
   

        if (iconeC.length > 2)
		icone = iconeC;
	else
		icone = 'rio.png'; 


var iconeA = {
    url: icone,
    scaledSize: new google.maps.Size(50, 30), // scaled size
    origin: new google.maps.Point(0,0), // origin
    anchor: new google.maps.Point(0, 0) // anchor
};



        var marker = new google.maps.Marker({
          icon: iconeA,
          map: map,
          position: p,
          title: title,
          animation: google.maps.Animation.DROP,
          address: address,
	  nivel: nivel,
	  //label: "Rio Gregorio: 5m",
          url: url
        })
        infoWindow(marker, map, title, address, url, locations[i][3], locations[i][4], locations[i][5], nivel);

    if (nivel == 0) 
	   marker.bindTo('map',myLayers,'sensores');
    if (nivel == 1) 
		marker.bindTo('map',myLayers,'cameras');
        bounds.extend(marker.getPosition());
        map.fitBounds(bounds);

}

var lastInfoWindow

function infoWindow(marker, map, title, address, url,latitude,longitude,estado, nivel) {

  google.maps.event.addListener(marker, 'click', function openInfoWindowAndClose() {



    lastInfoWindow && lastInfoWindow.close()



    var html = "<div> <img src=" + estado + " width=50><h3>" +

               title + "</h3><p>" +


               address +

               "<br></div><a href='" + url + "' target=popup onclick=\"window.open('" + url + "', 'popup','width=600,height=600'); return false;\">Link</a></p><p>Latitude:" +
		       //"<br></div><a href='" + url + "' target=_blank>Link </a></p><p>Latitude:" +

               latitude + "<br>Longitude: " + longitude + " </div>";



    if (url == 'blank') {

      html = "<div><h3>" + title + "</h3><p>" + address +

             "<br></div>P&aacute;gina  n&atilde;o cadastrada.</p>><p>Latitude: " +

             latitude + "<br>Longitude: " + longitude + "<br><br><a href=#" +

             estado + " target=_blank>#</a> </div>";

    }



    

    var iw = lastInfoWindow = new google.maps.InfoWindow({

      content: html,

      maxWidth: 350

    });

      

    iw.open(map, marker);

  });

}


</script>

<html>
<br>

</body>
</html>



