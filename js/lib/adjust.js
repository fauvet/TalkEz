/* on redéfinit indexOf pour les tableaux d'éléments */
NodeList.prototype.indexOf = HTMLCollection.prototype.indexOf = function(pElement){
	for( var i = 0 ; i < this.length ; i++ ) // pour chaque élément de la collection
		if( this[i] == pElement ) return i;  // si on trouve, on retourne le rang

	return -1; // sinon -1
}