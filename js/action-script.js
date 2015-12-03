/*
*   PLAN DU FICHIER
* 
*
* [1] Variables globales
* [2] Fonctions génériques
* [3] Gestion des librairies
* [4] Gestion des sections (liens)
*
*
*
*
*
*
* 
*/



/* [1] Variables globales
=======================================*/
var DOM = {
	BODY: document.body,
	HEADER:    document.querySelector('body > #HEADER'),
	MENU:      document.querySelector('body > #MENU'),
	CONTAINER: document.querySelector('body > #CONTAINER')
};





/* [2] Fonctions génériques
=======================================*/
function addClass(pElement, pClass){
	if( pElement == null ) return;

	var classTab = pElement.className.split(' ');

	if( classTab.indexOf(pClass) < 0 ){                 // si la classe n'est pas présente
		classTab.push(pClass);                          // on ajoute la classe
		pElement.className = classTab.join(' ').trim(); // on attribue la nouvelle class à l'élément
	}

}


function remClass(pElement, pClass){
	if( pElement == null ) return;

	var classTab = pElement.className.split(' ');

	if( classTab.indexOf(pClass) > -1 ){                                      // si la classe est déjà présente
		var index = classTab.indexOf(pClass);
		classTab = classTab.slice(0,index).concat( classTab.slice(index+1) ); // on ajoute la classe
		pElement.className = classTab.join(' ').trim();                       // on attribue la nouvelle class à l'élément
	}

}


/* [3] Gestion des librairies
=======================================*/
var pageM = new pageManager();

// initialisation de pageManager()
pageM.setPage(null, 'view', DOM.CONTAINER, ['home', 'news', 'worldmap', 'contact']);


/* [4] Gestion des sections
=======================================*/
var mainLinks = document.querySelectorAll('#MENU > span[data-link]');
for( var i = 0 ; i < mainLinks.length ; i++ ){

	mainLinks[i].addEventListener('click', function(e){

		remClass( document.querySelector('#MENU > span[data-link].active'), 'active');
		addClass( e.target, 'active'                                                );

		pageM.setPage( e.target.dataset.link );

	}, false);

}