<?php

    class UserRepo {
        private $connexion;

        public function __construct() {
            $this->connexion=StaticRepo::getConnnexion();
        }

        // Récupère les IDS évènements auxquels l'utilisateur (donné par son ID) est abonné
        public function selectAbonnements(id_user) {
            $request = $this->connexion->prepare("SELECT EVT.ID
                FROM EVENT EVT, USER U, ABONNEMNT ABN
                WHERE U.ID = ABN.USER_ID
                AND ABN.EVENT_ID = EVT.ID
                AND U.ID = :id_user");
            $request->execute(array( ':id_event' => $id_event ));
            
            return StaticRepo::delNumeric( $resquest->fetchAll() );
        }
             
    }

?>
