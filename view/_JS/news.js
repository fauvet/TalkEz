
/* BOUTON POUR RÉCUPÉRER LES COORDONNÉES
=====================================================*/
var geolocBtns = document.querySelectorAll('[data-geolocation]');

for( var i = 0 ; i < geolocBtns.length ; i++ ){

	geolocBtns[i].addEventListener('click', function(e){
		if( navigator.geolocation ){
			navigator.geolocation.getCurrentPosition(function(e){ geoLoc = e; });
		}
	});

}



/* GESTION DU DÉROULEMENT DES POSTS
=====================================================*/
var postTab = document.querySelectorAll('#CONTAINER > .post');

// clic sur le #CONTAINER
for( var i = 0 ; i < postTab.length ; i++ ){

	postTab[i].addEventListener('click', function(e){
		if( postTab.indexOf(e.target) >= 0 ){ // si c'est un post (référencé)
			remClass( document.querySelector('#CONTAINER > .post.active'), 'active' );
			addClass( e.target, 'active' );
		}else if( postTab.indexOf(e.target.parentNode) >= 0 ){ // si c'est un post (référencé)
			remClass( document.querySelector('#CONTAINER > .post.active'), 'active' );
			addClass( e.target.parentNode, 'active' );
		}
	}, false);

}