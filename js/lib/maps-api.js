function MapsApi(canvas){ this.canvas = canvas; };





MapsApi.prototype = {
	canvas: this.canvas, // le canvas dans lequel afficher la map
	map: null,           // contiendra la map
	element: [],         // les objets de description
	
	append: function(pElement){
		pElement.coord = { lat: pElement.lat, lng: pElement.lng };

		// style du cercle
		switch(pElement.imp){
			case 0: // IMPORTANCE 0
				pElement.circleStyle = {
					strokeColor: '#d6a61f',
					strokeOpacity: 1,
					strokeWeight: 2,
					fillColor: '#d6a61f',
					fillOpacity: .5
				};
				break;
			case 1: // IMPORTANCE 1
				pElement.circleStyle = {
					strokeColor: '#d66c1f',
					strokeOpacity: 1,
					strokeWeight: 2,
					fillColor: '#d66c1f',
					fillOpacity: .5
				};
				break;
			case 2: // IMPORTANCE 2
				pElement.circleStyle = {
					strokeColor: '#d63d1f',
					strokeOpacity: 1,
					strokeWeight: 2,
					fillColor: '#d63d1f',
					fillOpacity: .5
				};
				break;
		}

		this.element.push( pElement );
	},

	generate: function(){

		// initialisation de la map
		this.map = new google.maps.Map(
			this.canvas,
			{
				zoom:      2,
				minZoom:   2,
				center:    new google.maps.LatLng(0, 0),
				mapTypeId: google.maps.MapTypeId.ROADMAP
			}
		);

		var ptr = this;
		
		// on positionne les marqueurs
		for( var i = 0 ; i < this.element.length ; i++ ){
			// on positionne les markers
			this.element[i].marker = new google.maps.Marker({
				position: this.element[i].coord,
				map: this.map,
				icon: '../../src/twitter2.png'
			});

			// on positionne les cercles
			this.element[i].circle = new google.maps.Circle({

				title: this.element[i].nom,
				
				strokeColor: this.element[i].circleStyle.strokeColor,
				strokeOpacity: this.element[i].circleStyle.strokeOpacity,
				strokeWeight: this.element[i].circleStyle.strokeWeight,
				fillColor: this.element[i].circleStyle.fillColor,
				fillOpacity: this.element[i].circleStyle.fillOpacity,

				center: this.element[i].coord,
				radius: this.element[i].rad*50000,
				map: this.map
			});

			// on créé les zones de texte
			this.element[i].infoBox = new google.maps.InfoWindow({
				content: '<h4 id="firstHeading" class="firstHeading">'+this.element[i].nom+'</h4>'+this.element[i].msg
			});

			this.element[i].marker.addListener('click', function(e, f){
				var coord = e.latLng;
				for( var x = 0 ; x < ptr.element.length ; x++ ){
					console.log( ptr.element[x].coord );
					if( ptr.element[x].lat == coord.lat() && ptr.element[x].lng == coord.lng() )
						ptr.element[x].infoBox.open(ptr.map, ptr.element[x].marker);
				}
			});
		}


	}	

}
