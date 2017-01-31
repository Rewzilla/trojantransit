
var position = {lat: 0, lng: 0};

function onGeoSuccess(pos) {
	position.lat = pos.coords.latitude;
	position.lng = pos.coords.longitude;
}

function updateLatLng(callback) {
	return navigator.geolocation.getCurrentPosition(onGeoSuccess);
}

setInterval('updateLatLng();', 2000);