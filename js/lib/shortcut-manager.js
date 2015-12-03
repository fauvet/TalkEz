/**************/
/* PRÉ-REQUIS */
/**************/
/* Retourne le keyCode correspondant à la chaîne donnée
* 
* @param str 			enchaînement de touches sous forme de string
* 
* 
* return keyCode 		le code de la touche correspondante

*/
function strToKeyCode(keyString){
	// on enregistre le keyCode du premier caractère
	var keyCode = keyString.toUpperCase().charCodeAt(0); 

	// s'il s'agit d'un caractère uniquement (entre "a" et "z" ou entre "0" et "9")
	if( keyString.length == 1 && ((keyCode >= 65 && keyCode <= 90) || (keyCode >= 49 && keyCode <= 57)) )
		return keyCode; // on retourne le keyCode associé
	else
		switch( keyString ){ // sinon, on récupère l'ascii spécifiquement
			case 'ctrl':  return 17; break;
			case 'maj':   return 16; break;
			case 'alt':   return 18; break;
			case 'tab':   return  9; break;
			case 'left':  return 37; break;
			case 'top':   return 38; break;
			case 'right': return 39; break;
			case 'down':  return 40; break;
		}

	return null;
}







/**********/
/* CLASSE */
/**********/
function ShortcutManager(){};

ShortcutManager.prototype = {
	pressed:   [], // contiendra les touches pressées (en cours)
	shortcuts: [], // contiendra tous les raccourcis
	// progress:  [], // contiendra l'avancée des raccourcis
	handlers:  [], // contiendra tous les handlers (fonctions à éxécuter)
	/* tmp */
	lastKeyCode: [], // contiendra des "reminder" pour les évènements

	/* ajout d'un nouveau raccourcis clavier */
	append: function(keyRow, handler){
		/* [1] On découpe la chaîne (en minuscule) par "+"
		=======================================================*/
		var keyStore = keyRow.toLowerCase().split('+');

		/* [2] On récupère les keyCodes correspondant aux codes/lettres
		=======================================================*/
		for( var i = 0 ; i < keyStore.length ; i++ ){
			keyStore[i] = strToKeyCode( keyStore[i] );

			// si on a une erreur, on retourne NULL
			if( keyStore[i] == null ) return null;
		} 

		/* [3] On enregistre dans l'objet (shortcuts, progress, handler)
		=======================================================*/
		var index               = this.shortcuts.push( keyStore ) - 1;
		// this.progress[index]    = 0;                   // le progrès est l'index d'avancement
		this.handlers[index]    = handler;             // handler (function qui s'éxécutera lors de l'activation)
		this.lastKeyCode[index] = null;                //
	},

	/* démarre l'écoute (active les évènements) */
	listen: function(){

		/* [1] On créé l'évènement d'appui de touche pour chaque élément
		=======================================================*/
		var pointer = this;
		
		// on initialise/créer l'évènement
		window.addEventListener('keydown', function(e){

			// on ajoute la touche si elle n'y est pas
			if( pointer.pressed.indexOf(e.keyCode) < 0 ) pointer.pressed.push(e.keyCode);

			for( var i = 0 ; i < pointer.shortcuts.length ; i++ ){

				var complete = pointer.shortcuts[i].length; // taille du shortcut en question
				// on vérifie que l'ensemble des touches pressées remplissent le shortcut
				for( var k = 0 ; k < pointer.pressed.length ; k++ )
					if( pointer.shortcuts[i].indexOf( pointer.pressed[k] ) > -1 ) // si la touche est dans le shortcut, on décrémente compteur (complete)
						complete -= 1;


				// si le compteur est à 0, on a terminé la combinaison de touches, on remet le compteur à 0 + on exécute le handler
				if( complete == 0 )
					pointer.handlers[i](e);
			}

		}, false);




		// si on lâche une touche, on l'enlève de "pressed"
		window.addEventListener('keyup', function(e){
			var index = pointer.pressed.indexOf(e.keyCode);
			pointer.pressed = pointer.pressed.slice(0,index).concat( pointer.pressed.slice(index+1) );
		}, false);
	}
};



