# bipes_maps
Open source geographical information system (GIS) / mapping platform to use with BIPES that allows easy manipulation of static and dynamic markers based on PHP, MySQL and Google Maps API.

BIPES Mapping Documentation
Mon May 24 09:39:25 -03 2021

BIPES Maps
Static markers on Google Map
Static markers are loaded when the page loads and their position are not updated any more.

Add, update and manage here: https://bipes.net.br/map/crud/index.php/main/static
Dynamic markers on Google Map
Dynamic markers are loaded on map initializaton and can any atribute can be dynamically modified: position, icon, text, session, layer, etc.
Add, update and manage here: https://bipes.net.br/map/crud/index.php/main/dynamic/
Webservice to add a new marker
https://bipes.net.br/map/addMarker.php?name=test&lat=-11&long=-5&session=5

Will return the created ID!
Webservice to clear session
Deletes all information / markers related to one session.

https://bipes.net.br/map/clearSession.php?session=10
Webservice to delete specific maker
Deletes a specific marker

https://bipes.net.br/map/deleteMarker.php?session=10&id=99
Webservice to update marker position

https://bipes.net.br/map/updatePosition.php?id=13&lat=-22&long=-5&session=5

Shell script example:
for i in `seq 1 20`; 
do 
	lynx -dump "https://bipes.net.br/map/updatePosition.php?id=13&lat=-1$i&long=-5&session=5"; 
	sleep 1; 
done
