<?php

class TweetRepo{

	private $connexion;

	public static function exists(int $id){
		$statement = StaticRepo::getConnexion()->prepare("SELECT * FROM tweet WHERE ID = :id");
		$ret = $statement->exec(array(':id' => $id));
		$tab = $ret->fetch();
		return isset($tab['ID']);
	}

	public static function add($lien, $contenu, $nbfav, $nbRT, $localisation, $langue, $auteur){
		$statement = StaticRepo::getConnexion()->prepare("INSERT INTO `tweet`(`LIEN`, `CONTENU`, `NB_FAVORIS`, `NB_RT`, `LOCALISATION`, `LANGUE`, `AUTHOR`)
								 VALUES (':lien', ':contenu', ':nbfav', :nbRT, ':localisation', ':langue', :auteur);");
		$ret = $statement->exec(array(	'lien' => ));
		//On teste l'existance de l'auteur du tweet dans la bdd
		if (AuthorRepo::exists()){
			//On teste l'existence de la localisation aussi
			if(LocalisationRepo::exists()){
				
			}
			else { //sinon... on crée la localisation
				LocalisationRepo::add();
			}
		}
		else { // sinon on crée l'auteur
			AuthorRepo::add();
		}
	}

}

?>