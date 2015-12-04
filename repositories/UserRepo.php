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
            $request->execute(array( ':id_user' => $id_user ));
            
            return StaticRepo::delNumeric( $resquest->fetchAll() );
        }

        // Récupère les IDS d'utilisateur d'un profil donné
        public function selectUserProfil(string_profil) {
            $request = $this->connexion->prepare("SELECT ID
                FROM USER
                WHERE U.PROFIL LIKE :string_profil");
            $request->execute(array( ':string_profil' => $string_profil ));
            
            return StaticRepo::delNumeric( $resquest->fetchAll() );
        }

        // Récupère les coordonnées de la dernière connexion d'un utilisateur (donné par son ID)
        public function selectCoordonnees(id_user) {
            $request = $this->connexion->prepare("SELECT COORD.LONGITUDE, COORD.LATITUDE
                FROM COORDONNEES COORD, USER U
                WHERE U.ID_LAST_POS = COORD.ID
                AND U.ID = :id_user");
            $request->execute(array( ':id_user' => $id_user ));
            
            return StaticRepo::delNumeric( $resquest->fetchAll() );
        }

        // Récupère les coordonnées du domicile d'un utilisateur (donné par son ID)
        public function selectCoordonnees(id_user) {
            $request = $this->connexion->prepare("SELECT COORD.LONGITUDE, COORD.LATITUDE
                FROM COORDONNEES COORD, USER U
                WHERE U.ID_HOME = COORD.ID
                AND U.ID = :id_user");
            $request->execute(array( ':id_user' => $id_user ));
            
            return StaticRepo::delNumeric( $resquest->fetchAll() );
        }

        // Récupère les IDS des évènements en cours triés par la proximité par rapport à la dernière position connue de l'utilisateur (donné par son ID)
        public function selectCoordonnees(id_user) {
            $request = $this->connexion->prepare("SELECT EVT.ID
                FROM EVENT EVT, USER U, COORDONNEES COORD
                WHERE EVT.CURRENT = 1";
            $request->execute(array( ':id_user' => $id_user ));
            
            return StaticRepo::delNumeric( $resquest->fetchAll() );
        }

        // Retourne la distance entre les dernières coordonnées connues de l'utilisateur
        // donné par son ID et celles de l'évènement défini par son ID
        public function getProximity(id_user, id_event) { 

            // Coords User
            $lonU = this.selectCoordonnees(id_user)[0];
            $latU = this.selectCoordonnees(id_user)[1];

            // Coords Event
            $lonE = EventRepo.selectCoordonnees(id_event)[0];
            $latE = EventRepo.selectCoordonnees(id_event)[1];

            // Rayon de la Terre en mètres
            $rayon = 6371,0*1000;

            // Calcul de la distance entre le centre de l'évènement et la dernière position connue de l'utilisateur
            $dist =  $rayon*acos(cos($latU)*cos($latE)*cos($lonU-$lonE)+sin($latU)*sin($latE));

            // Retrait du rayon de l'évènement
            $dist = $dist - EventRepo.selectRayon(id_event)[0];

            return $dist;

        }

    }

?>
