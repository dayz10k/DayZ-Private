var map;

function InitFallujah() {
	// Set up the map
	map = new L.Map('map');

	// Create the tile layer
	var tilesUrl = 'http://static.dayzdb.com/tiles/fallujah/{z}/{x}_{y}.png';
	var tilesAttrib = '&copy; Crosire, Fallujah map data from <a href="http://dayzdb.com/map">DayZDB</a>';
	var tiles = new L.TileLayer(tilesUrl, {minZoom: 2, maxZoom: 6, attribution: tilesAttrib, continuousWorld: true, noWrap: true});		

	map.setView(new L.LatLng(0, 0), 2);
	map.addLayer(tiles);
}