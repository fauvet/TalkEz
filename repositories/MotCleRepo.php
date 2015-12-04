<?php

	class MotCleRepo {

		private $connexion;

        public function __construct() {
            $this->connexion=StaticRepo::getConnnexion();
        }

        // Récupère tous les mots-clés avec leurs poids
        public function selectMotsCles() {
            $request = $this->connexion->prepare("SELECT LIBELLE, POIDS 
            	FROM MOT_CLE");
            $request->execute();
            
            return StaticRepo::delNumeric( $resquest->fetchAll() );
        }

        // Modifie le poids du mot-clé donné par son ID
        public function newPoids(id_motcle, poids) {
        	$request = $this->connexion->prepare("UPDATE MOT_CLE
        		SET POIDS = :poids
        		WHERE ID = :id_motcle");
            $request->execute(array( ':id_motcle' => $id_motcle, ':poids' => $poids ));
            
            return StaticRepo::delNumeric( $resquest->fetchAll() );
        }

	}

?>