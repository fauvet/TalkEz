<?php

    class UserRepo {
        private $connexion;

        public function __construct() {
            $this->connexion=StaticRepo::getConnnexion();
        }

        public function selectTweets(id_event) {
            $request = $this->connexion->prepare("SELECT TWEET.LIEN
                FROM EVENT EVT, TWEET TWT, DESIGNER DSG
                WHERE EVT.ID = DSG.EVENT_ID
                where e.id = d.event_id
                and d.tweet_id = tw.id
                and e.id = :id_event");
            $request->execute(array( ':id_event' => $id_event ));
            
            return StaticRepo::delNumeric( $resquest->fetchAll() );
        }
    }

?>
