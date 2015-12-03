function pageManager(){};

var ptrPageManager;  // pointeur global pour l'utilisation de fonctions de fonctions

pageManager.prototype = {
	depJS: null,     // la dépendance javascript
	depCSS: null,    // la dépendance css
	xhr: [],         // tableau d'objets pour les requêtes ajax
	page: null,      // l'indice de la page courante dans pagelist
	vars: [],        // les variables suivant le nom de la page dans l'URL
	path: '',        // le chemin du dossier contenant les pages (.php)
	pagelist: null,  // la liste des pages pouvant être chargées
	container: null, // élément DOM qui contiendra le contenu des pages à charger
	/* =======================================================================
		Cette fonction effectue une requête Ajax (compatible à partir de IE5)
		PARAMETRES:
		- pLink<string>      le lien à charger
		- pHandler<function> une fonction qui s'éxécutera avec la réponse de la requête passée en paramètre (voir exemples dessous pour pHandler)
		- pMethod<string>    type de méthode, vaut 'POST' ou 'GET' et vaut 'POST' par défaut ou s'il n'est pas renseigné
		- pForm<FormData>    formulaire de type FormData() contenant les données à envoyer (uniquement en POST), si pForm vaut GET les données doivent être passées dans l'URL
	========================================================================== */
	ajax: function(pLink, pHandler, pMethod, pForm){
		// on efface les requêtes qui sont terminées et on push une nouvelle
		for( var i = 0 ; i < this.xhr.length ; i++ ){
			// if( this.xhr[i].readyState == 4 ) // si terminée
				this.xhr = this.xhr.slice(0,i-1).concat(this.xhr.slice(i,this.xhr.length-1)); // suppression entrée
		}

		var index;

		if(window.XMLHttpRequest)            // IE7+, Firefox, Chrome, Opera, Safari
			index = this.xhr.push( new XMLHttpRequest() ) -1;
		else                                 // IE5, IE6 
			index = this.xhr.push( new ActiveXObject('Microsoft.XMLHttpRequest') ) -1;

		var ptrPageManager = this;
		this.xhr[index].onreadystatechange = function(){
			if( ptrPageManager.xhr[index].readyState == 4 ) // si la requête est terminée
				if( [0,200].indexOf(ptrPageManager.xhr[index].status) > -1 ) // si fichier existe et reçu
					pHandler(ptrPageManager.xhr[index].responseText);
				else // si code d'erreur retourne null
					pHandler();
		}

		// gestion de la méthode
		var method = ( typeof pMethod == 'string' && /^POST|GET$/i.test(pMethod) ) ? pMethod.toUpperCase() : 'POST';

		// gestion du formulaire si la méthode est POST
		var form = ( method == 'POST' && typeof pForm == 'object' && pForm instanceof FormData ) ? pForm : null;

		this.xhr[index].open( method, pLink, true );
		this.xhr[index].send( form );
	},
	/***************************************************** [APPLICATION] Ajax() ******************************************************/
	// EXEMPLES DE FONCTIONS POUR pHandler //
	//   1. var a = function(param){ alert(param); }        // les deux notations 1 et 2 sont équivalents
	//   2. function a(param){ alert(param); }              // les deux notations 1 et 2 sont équivalents

	// ajax( 'index.php', a );		              	        // utilisation d'une fonction définie

	// ajax( 'index.php', alert );              	        // utilisation d'une fonction prédéfinie
	// ajax( 'index.php', alert, 'GET' );       	        // utilisation de méthode

	// var fd = new FormData();                    	        // création d'un formulaire
	// fd.append('var', 100);	                  	        // ajout de la variable VAR qui vaut 100
		
	// ajax( 'index.php', alert, null, fd );    	        // saut de paramètre avec null + envoi formulaire
	// ajax( 'index.php?var=10', alert, 'GET' );      	    // envoi formulaire en GET (dans l'url)
	// ajax( 'index.php?var=10', alert, 'POST', fd );      	// envoi formulaire en GET (dans l'url) + en POST via le formulaire FD


	/* =======================================================================
		Cette fonction effectue une décomposition de l'URL sur le shéma spécifié dessous
		Renvoie pour http://www.exemple.com/dirA/dirB/#/NOMPAGE/VARPAGE
			- null si la page n'est pas référencée dans le tableau PAGELIST
			- null si le lien ne contient pas /#/NOMPAGE à la fin
			- null si NOMPAGE ne contient pas uniquement : lettres, chiffres, underscore
			- null si VARPAGE ne contient pas uniquement : lettres, chiffres, underscore
			- un objet contenant {page: valeur, var: valeur}
	========================================================================== */
	explodeURL: function(url_data){
		url_data = (arguments.length >= 1) ? url_data : document.URL;
		// si pageList est correct et que l'URL correspond à un schéma de page => continue [sinon] return null
		if( this.pagelist != null && /^(?:.+)\/#\/([a-z0-9_]+)\/?(?:\/((?:.+\/)+)\/?)?$/i.test(url_data) ){
			// si la page récupérée dans l'url est dans la liste => renvoi de l'objet [sinon] null
			var vars = RegExp.$2.split('/');
			while( vars[vars.length-1] == '' ) // on supprime les dernières entrées vides
				vars.pop();

			return ( this.pagelist.indexOf(RegExp.$1) > -1 ) ? {page: RegExp.$1, var: vars} : null;
		}else
			return null;
	},
	/* =======================================================================
		Cette fonction ajoute des dépendances (un js et un css) situés dans le répertoire des pages.
		pageDir/
			_JS/
				page1.js
				page2.js
			_CSS/
				page1.css
				page2.css
	========================================================================== */
	loadDependencies: function(){
		// si depCSS est un élément du DOM c'est à dire qu'il contient le fichier de la page précédente et qu'il est enfant de <head>, on le détruit
		if( typeof this.depCSS == 'object' && this.depCSS instanceof Element && this.depCSS.parentNode == document.head )
			document.head.removeChild( this.depCSS );

		// si depJS est un élément du DOM c'est à dire qu'il contient le fichier de la page précédente, on le détruit
		if( typeof this.depJS == 'object' && this.depJS instanceof Element && this.depJS.parentNode == document.head )
			document.head.removeChild( this.depJS );

		ptrPageManager = this;
		// si le fichier css existe
		this.ajax(this.path+'/'+'_CSS'+'/'+this.page+'.css', function(e){
			if( e != null ){ // on charge la dépendance CSS si le fichier existe
				ptrPageManager.depCSS = document.createElement('link');
				ptrPageManager.depCSS.rel = 'stylesheet';
				ptrPageManager.depCSS.type = 'text/css';
				ptrPageManager.depCSS.href = ptrPageManager.path+'/_CSS/'+ptrPageManager.page+'.css';
				document.head.appendChild(ptrPageManager.depCSS);
			}else
				console.log('[loadDependencies_Error] - ('+ptrPageManager.path+'/_CSS/'+ptrPageManager.page+'.css)');
		});

		// si le fichier js existe
		this.ajax(this.path+'/'+'_JS'+'/'+this.page+'.js', function(e){
			if( e != null ){ // on charge la dépendance JS si le fichier existe
				ptrPageManager.depJS = document.createElement('script');
				ptrPageManager.depJS.type = 'text/javascript';
				ptrPageManager.depJS.src = ptrPageManager.path+'/_JS/'+ptrPageManager.page+'.js';
				document.head.appendChild(ptrPageManager.depJS);
			}else
				console.log('[loadDependencies_Error] - ('+ptrPageManager.path+'/_JS/'+ptrPageManager.page+'.js)');
		});
	},

	/* =======================================================================
		Met à jour l'URL de la page en fonction de la page chargée et des 
		variables associées (ne recharge aucune ressource)
	======================================================================= */
	updateURL: function(){
		if( this.vars.length > 0 ) // si il y a des variables
			window.history.pushState(this.page, this.page, '#/'+this.page+'/'+this.vars.join('/')+'/');
		else // s'il n'y en a pas
			window.history.pushState(this.page, this.page, '#/'+this.page+'/');

		// on peut récupérer le nom de la page (quand on fait retour en arrière de l'historique)
		// dans la variable : window.history.state
	},

	/* =======================================================================
		Cette fonction est celle qui gère les 2 autres et celle que l'utilisateur utilisera
		PARAMETRES:
		- pName<string>            le nom de la page à charger (lettres, chiffres, underscore) (*)
		- pPath<string>            chemin (relatif ou absolu) du dossier contenant les pages de même nom de fichier que le nom (extension .php)
		- pContainer<Element>      l'élément du DOM qui contiendra la page chargée (**)
		- pPageList<Array<string>> tableau contenant la liste des pages sous forme de chaînes de caractères (**) (***)
		*      Le chemin du dossier sans le '/' final si c'est le dossier actuel le chemin est une chaîne vide
		       Si le dossier est 'page' et que l'on cherche la page 'accUe1l', la requête sera vers 'page/accUe1l.php'
		       le nom de la page est sensible à la casse
		**  1. pPageList et pContainer doivent être mis en paramètres uniquement à la première utilisation
		       et la première utilisation doit se faire au chargement de la page car elle permetra
		       de mettre l'URL à jour et/ou charger la page de l'URL
		***    la première page du tableau est la page par défaut (qui est chargée si l'URL ne contient
		       pas la page ou si la page de l'URL ne correspond à aucune page de la liste)
	========================================================================== */
	setPage: function(pName, pPath, pContainer, pPageList){

		// liste de pages si c'est un tableau
		var pageList = ( typeof pPageList == 'object' && pPageList instanceof Array ) ? pPageList : null; // si this.pagelist n'est pas overwrite il vaut null

		if( pageList != null ){                             // si c'est un tableau
			for( var i = 0 ; i < pageList.length ; i++ ){   // on parcourt tout les éléments pour vérifier que chaque élément ne contient que : lettres, chiffres, underscore [non]> pageList = null
				pageList = ( typeof pageList[i] == 'string' && /^[a-z0-9_]+$/i.test(pageList[i]) ) ? pageList : null;
				if( pageList == null ) break;               // si le tableau est null stoppe la boucle
			}
		}
		/* on attribue la variable temporaire pageList à l'attribut de l'objet si la variable pageList temporaire n'est pas nulle */
		this.pagelist = ( pageList != null ) ? pageList : this.pagelist;
		// affecte à l'attribut page la page par défaut (premier élément de pagelist)
		this.page = this.pagelist[0];
		// affecte pPath à l'attribut path s'il est renseigné
		this.path = ( typeof pPath == 'string' ) ? pPath : this.path;
		/* on attribue le paramètre pContainer à l'attribut si il est spécifié */
		this.container = ( typeof pContainer == 'object' && pContainer instanceof Element ) ? pContainer : this.container;

		// si this.pagelist && this.container ne sont pas null && 
		if( this.pagelist != null && this.container != null ){
			// si le pName est renseigné et qu'il est dans pagelist
			if( typeof pName == 'string' && this.pagelist.indexOf(pName) > -1 ){
				// affecte pName à l'attribut page
				this.page = pName;

				// charge le contenu de la page dans le container
				var ptrPageManager = this;

				// formulaire POST
				var fd = new FormData();
				for( var i = 0 ; i < this.vars.length ; i++ )
					fd.append(this.vars[i], null);
				
				this.ajax(this.path+'/'+this.page+'.php', function(e){
					ptrPageManager.container.innerHTML = e;
					ptrPageManager.loadDependencies(); 
				}, 'POST', fd);

				// change l'URL en conséquences(stateObj, titre, url)
				this.updateURL();
		
			}else{ // si la page n'est pas spécifiée ou qu'elle n'est pas dans la liste des pages
				var urlGet = this.explodeURL();

				// si on a récupéré le numéro de la page dans l'URL et qu'elle fait partie de la liste des pages
				if( urlGet != null ){
					this.page = urlGet.page;
					// charge le contenu de la page dans le container
					var ptrThis = this;

					// formulaire POST
					var fd = new FormData();
					this.vars.length = 0;

					for( var i = 0 ; i < urlGet.var.length ; i++ ){ // replacing object variables with explodeURL variables
						this.vars[i] = urlGet.var[i];
						fd.append(this.vars[i], null);
					}

					this.ajax(this.path+'/'+this.page+'.php', function(e){
						ptrThis.container.innerHTML = e;
						ptrThis.loadDependencies(); 
					}, 'POST', fd);

					// change l'URL en conséquences(stateObj, titre, url)
					this.updateURL();
					
				}else // si l'url ne contient rien, on charge la page par défaut
					this.setPage(this.pagelist[0]);
			}
		}else
			console.log('pagelist et container manquant');
	}

}