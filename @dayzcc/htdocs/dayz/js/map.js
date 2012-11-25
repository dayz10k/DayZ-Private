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