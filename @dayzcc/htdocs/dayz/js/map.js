// Credits for the map crs codes go to the developers at http://www.dayzdb.com/map

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

// The map data function was written by Krunch and Crosire

function getData(id) {
	$.getJSON('js/map.php?id=' + id + '&callback=?', function(data) {
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
				
				if (id == 0 || id == 1 || id == 3 || id == 7) {
					addMarkerToTrackline(data[i].id, pos);
				}
			}
		}
	});
	clearTrackLines();
}

// Player tracking lines were written by Wriley and slightly altered by Crosire

function addMarkerToTrackline(id, pos) {
	if (pos.lng == 0) { return; }

	var found = false;
	tracklines.forEach(function(element) {
		if (element.options.uid == id) {
			found = true;
			if (!element.getLatLngs()[element.getLatLngs().length - 1].equals(pos)) { element.addLatLng(pos); }
		}
	});

	if (!found) {
		var trackMouseOutOptions = { weight: 2, color: '#c00000', opacity: 0.8 }
		var trackMouseOverOptions = { weight: 3, color: '#ff0000', opacity: 1 }
		var line = new trackPolyline([], trackMouseOutOptions);

		line.addLatLng(pos);
		line.options.uid = id;
		line.on('mouseover', function(){
			line.setStyle(trackMouseOverOptions);
		});
		line.on('mouseout', function(){
			line.setStyle(trackMouseOutOptions);
		});

		var startMarker = new trackCircleMarker(pos, { color: '#c00000', fill: true, fillColor: '#c00000', fillOpacity: 1 });
		startMarker.setRadius(3);
		startMarker.options.uid = id;

		tracklines.push(line);
		tracklayers.push(line);
		trackstartlayers.push(startMarker);

		map.addLayer(line);
		map.addLayer(startMarker);
	}
}

function clearTrackLines() {
	for (i = 0; i < tracklines.length; i++) {
		var found = false;
		var uid = tracklines[i].options.uid;
		
		plotlayers.forEach(function(element) {
			if (element.options.uid == uid) { found = true; }
		});

		if (found) {
			while(tracklines[i].getLatLngs().length > 50) { tracklines[i].getLatLngs().removeAt(0); }
		} else {
			map.removeLayer(tracklines[i]);
			if (tracklines.length > 1) {
				tracklines.splice(i, 1);
			} else {
				tracklines = [];
			}

			trackstartlayers.forEach(function(element) {
				if (element.options.uid == uid) { map.removeLayer(element); }
			});
		}
	};
}