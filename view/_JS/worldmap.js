
// var map = null,
// 	trace = null,
// 	coordPath = [];

// function initMap(){

// 	// initialisation de la map
// 	map = new google.maps.Map(
// 		document.getElementById('map'),
// 		{
// 			zoom:      2,
// 			center:    new google.maps.LatLng(50,1),
// 			mapTypeId: google.maps.MapTypeId.ROADMAP
// 		}
// 	);

// 	// on positionne les marqueurs
// 	for( var i = 0 ; i < coordData.length ; i++ ){
// 		coordData[i].marker = new google.maps.Marker({
// 			position: coordData[i].coord,
// 			label: String.fromCharCode(65+i),
// 			map: map
// 		});

// 		coordPath.push( coordData[i].coord ); // on ajoute les coordonnées à la liste des points de la polyline
// 	}

// 	// on initialise le tracé entre les marqueurs
// 	trace = new google.maps.Polyline({
// 		path: coordPath,
// 		geodesic: true,
// 		strokeColor: '#2593D8',
// 		strokeOpacity: 0.7,
// 		strokeWeight: 2.8
// 	});

// 	trace.setMap(map);

// }

// initMap();




var map = new MapsApi( document.getElementById('live-map') );
map.append({
	nom: 'Séïsme Tahiti',
	msg: 'Ce séisme a début le 230/32239 à 19:90<br>Il a fait au total 879 morts',
	lat: 28,
	lng: 29,
	rad: 4,
	imp: 0
});

map.append({
	nom: 'Tournade France',
	msg: 'Ce tournade fut débuta le 230/32239 à 19:90<br>Il eu fume au total 879 morts',
	lat: 10,
	lng: 29,
	rad: 2,
	imp: 1
});

map.append({
	nom: 'Tournade France',
	msg: 'Ce Tourna2 fut débuta le 230/32239 à 19:90<br>Il eu fume au total 879 morts',
	lat: 30,
	lng: 10,
	rad: 10,
	imp: 2
});


map.append({
	nom: 'Nuit de lInfo',
	msg: 'Ce Tourna2 fut débuta le 230/32239 à 19:90<br>Il eu fume au total 879 morts',
	lat: 43.8,
	lng: 1.04,
	rad: 1,
	imp: 2
});


map.generate();