<?php

    class EventRepo {
        private $connexion;

        public function __construct() {
            $this->connexion=StaticRepo::getConnnexion();
        }

        // Récupère les coordonnées d'un évènement donné, ainsi que son rayon
        public function selectCoordonnees(id_event) {
            $request = $this->connexion->prepare("SELECT COORD.LONGITUDE, COORD.LATITUDE, EVT.RAYON
                FROM COORDONNEES COORD, EVENT EVT
                WHERE EVT.ID_LIEU = COORD.ID
                AND EVT.ID = :id_event");
            $request->execute(array( ':id_event' => $id_event ));
            
            return StaticRepo::delNumeric( $resquest->fetchAll() );
        }

        public function selectRayon(id_event) { 
            $request = $this->connexion->prepare("SELECT RAYON
                FROM EVENT
                WHERE ID = :id_event");
            $request->execute(array( 'id_event' => $id_event ));
        }

    }

?>
