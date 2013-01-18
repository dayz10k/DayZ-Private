// Credits for the map functions and crs go to the developers at http://www.dayzdb.com/map, Krunch and Crosire

function fromCoordToGps(e) {
	var e = Math.abs(e), b = (1E3 * e).toString();
	return b = 0.1 > e?"000":1 > e?"00" + b.substr(0,1):10 > e?"0" + b.substr(0,2):100 > e?b.substr(0,3):"999"
}

function fromGpsToCoord(e) {
	return 0.1 * parseInt(e, 10)
}

function fromLatLngToGps(e) {
	return fromCoordToGps(e.lng) + " " + fromCoordToGps(e.lat)
}

function getData(id) {
	$.getJSON('http://localhost:78/dayz/js/map.php?id=' + id + '&callback=?', function(data) {
		if ("error" in data) {
			if ($('#page-error').length == 0) { $('#map').before(data.error); }
		} else {
			$('#page-error').remove();
			for (i = 0; i < plotlayers.length; i++) { map.removeLayer(plotlayers[i]); }
			plotlayers = [];
			for (i = 0; i < data.length; i++) {
				var pos = new L.LatLng(data[i].lat, data[i].lng);
				var plotmark = new L.marker(pos, { icon: eval(data[i].icon), title: data[i].title });
				map.addLayer(plotmark);
				plotmark.bindPopup(data[i].description);
				plotlayers.push(plotmark);	
			}
		}
	});
}