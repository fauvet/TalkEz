<?php

    require 'StaticRepo.php';

    class EventRepo {
        private $connexion;

        public function __construct() {
            $this->connexion=StaticRepo::getConnexion();
        }

        // Récupère les coordonnées d'un évènement donné, ainsi que son rayon
        public function selectCoordonnees($id_event) {
            $request = $this->connexion->prepare("SELECT COORD.LONGITUDE, COORD.LATITUDE, EVT.RAYON
                FROM COORDONNEES COORD, EVENT EVT
                WHERE EVT.ID_LIEU = COORD.ID
                AND EVT.ID = :id_event");
            $request->execute(array( ':id_event' => $id_event ));
            
            return StaticRepo::delNumeric( $request->fetchAll() );
        }

        // Récupère tous les IDS d'events en cours
        public function selectEnCours() {
            $request = $this->$connexion->prepare("SELECT ID
                FROM EVENT
                WHERE CURRENT = 1");
            $request->execute();

            return StaticRepo::delNumeric( $request->fetchAll() );
        }

        public function selectLibelle($id_event) {
            $request = $this->connexion->prepare("SELECT LIBELLE 
                FROM EVENT
                WHERE ID = :id_event");
            $request->execute(array( ':id_event' => $id_event ));

            return StaticRepo::delNumeric( $request->fetchAll() );
        }

        // Récupère les message et leurs dates liés à un évènement donné par son ID 
        public function selectMessage($id_event) {
            $request = $this->connexion->prepare("SELECT M.CONTENU, M.DATE 
                FROM MESSAGE M, EVENT E 
                WHERE E.ID = M.ID_EVENT 
                AND E.ID = :id_event");
            $request->execute(array( ':id_event' => $id_event ));

            return StaticRepo::delNumeric( $request->fetchAll() );
        }

    }

?>
