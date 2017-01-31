
// https://plainjs.com/javascript/ajax/send-ajax-get-and-post-requests-47/
function postAjax(url, data, success) {
	var params = typeof data == 'string' ? data : Object.keys(data).map(
			function(k){ return encodeURIComponent(k) + '=' + encodeURIComponent(data[k]) }
		).join('&');
	var xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
	xhr.open('POST', url);
	xhr.onreadystatechange = function() {
		if (xhr.readyState>3 && xhr.status==200) { success(xhr.responseText); }
	};
	xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xhr.send(params);
	return xhr;
}

function postLatLng() {
	postAjax("/update", position, function(data){ /* */ });
}

var markers = [];
var map;
function initMap() {
	map = new google.maps.Map(document.getElementById("map"), {
		center: {lat: 44.0055304, lng: -97.1131104},
		zoom: 14
	});
}

var pickup_marker;
function initPickupMarker() {

	// EWWWWWWWWWWWW, TODO FIND A BETTER WAY
	if(position.lat==0 || position.lng==0) {
		setTimeout('initPickupMarker();', 500);
		return;
	}

	pickup_marker = new google.maps.Marker({
		position: position,
		map: map,
		title: "pickup",
		draggable: true,
		icon: {
			url: "images/pickup.png",
			scaledSize: new google.maps.Size(25, 31),
		}
	});

	var infowindow = new google.maps.InfoWindow({
		content: '<button type="submit" name="submit" class="btn btn-lg btn-primary">Pick me up here</button>'
	});

	pickup_marker.addListener('click', function() {
		infowindow.open(map, pickup_marker);
	});

	pickup_marker.addListener('dragend', function () {
		//console.log('lat: ' + pickup_marker.getPosition().lat() + ', lng: ' + pickup_marker.getPosition().lng());
		pickup_marker.position.lat = pickup_marker.getPosition().lat;
		pickup_marker.position.lng = pickup_marker.getPosition().lng;
	});

}

var drivers;
function updateDrivers() {
	var xhr = new XMLHttpRequest();
	xhr.open("GET", "/api/drivers", true);
	xhr.send();
	xhr.onreadystatechange = function() {
		if(xhr.readyState == 4 && xhr.status == 200) {
			drivers = JSON.parse(xhr.responseText);
			for(i=0; i<drivers.length; i++) {
				//console.log("Driver#" + i + ": " + drivers[i].first + " " + drivers[i].last);
				if(markers[drivers[i].phone])
					markers[drivers[i].phone].setMap(null);
				markers[drivers[i].phone] = new google.maps.Marker({
					position: {lat: drivers[i].lat, lng: drivers[i].lng},
					map: map,
					title: drivers[i].first + " " + drivers[i].last,
					icon: {
						url: "images/driver.png",
						scaledSize: new google.maps.Size(25, 31)
					}
				});
			}
		}
	}
}

var pickups;
function updatePickups() {

	var xhr = new XMLHttpRequest();
	xhr.open("GET", "/api/pickups", true);
	xhr.send();
	xhr.onreadystatechange = function() {
		if(xhr.readyState == 4 && xhr.status == 200) {
			pickups = JSON.parse(xhr.responseText);
			for(i=0; i<pickups.length; i++) {
				//console.log("Pickup#" + i + ": " + pickups[i].first + " " + pickups[i].last);
				if(markers[pickups[i].phone])
					markers[pickups[i].phone].setMap(null);
				markers[pickups[i].phone] = new google.maps.Marker({
					position: {lat: pickups[i].lat, lng: pickups[i].lng},
					map: map,
					title: pickups[i].first + " " + pickups[i].last,
					icon: {
						url: "images/pickup.png",
						scaledSize: new google.maps.Size(25, 31)
					}
				});
			}
		}
	}
}

function fillPickupForm() {

	document.getElementById("lat").value = pickup_marker.getPosition().lat();
	document.getElementById("lng").value = pickup_marker.getPosition().lng();
	//console.log(pickup_marker.getPosition().lat() + "," + pickup_marker.getPosition().lng());

}