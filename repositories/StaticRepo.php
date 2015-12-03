<?php

class StaticRepo{

    //contiens l'instance de la Connexion PDO
    private static $connexion;

    //contiens les informations de connexion a la BDD
    private static $config;

    private function __construct(){

    }

    /**
     * @return PDO instance de la connexion a la BDD
     */
    public static function getConnexion(){
        if(static::$config == null){
            static::$config = json_decode(file_get_contents(dirname(__FILE__).DIRECTORY_SEPARATOR.'config.json'),true);
        }
        if(static::$connexion == null){
            static::$connexion = new PDO('mysql:host='.static::$config['host'].';dbname='.static::$config['database'], static::$config['login'], static::$config['password']);
        }
        return static::$connexion;
    }

    /**
     * @return bool test de la Connexion
     */
    public static function testConnexion(){
        return static::getConnexion() instanceof PDO;
    }




    /* SUPPRIME LES VALEURS À CLÉS NUMÉRIQUES DANS UN FETCH D'UNE TABLE DE LA BDD
    *
    * @fetchData<Array>                 le résultat d'une $requeteSQL->fetchAll() / $requeteSQL->fetch()
    *
    * @return newFetchData<Array>       retourne le tableau donné en paramètre mais sans les valeurs à clés numériques  
    *
    */
    public static function delNumeric($fetchData, $oneDimension=false){
	
	// cas où fetch renvoie FALSE
	if( $fetchData === false ) return false;

        /* [1] 2 dimensions
        ===============================================*/
        if( !$oneDimension ){

        // on supprime les doublons des entrées (indice numérique)
        for( $i = 0 ; $i < count($fetchData) ; $i++ ) // pour tout les utilisateurs
            foreach($fetchData[$i] as $col => $val){  // pour toutes les entrées
                
                if( !mb_detect_encoding($val, 'UTF-8') )
                    $fetchData[$i][$col] = utf8_encode($val);
                
                if( is_int($col) )                    // si l'indice est un entier
                    unset( $fetchData[$i][$col] );    // on le supprime
            }

        /* [2] 1 dimensions
        ===============================================*/
        }else{

            // on supprime les doublons des entrées (indice numérique)
            foreach($fetchData as $i=>$val){  // pour toutes les entrées
                
                if( !mb_detect_encoding($val, 'UTF-8') )
                    $fetchData[$i] = utf8_encode($val);

                if( is_int($i) )                    // si l'indice est un entier
                    unset( $fetchData[$i] );    // on le supprime
            }

        }

        return $fetchData;
    }







//     _      _____ ___ _   _ ___ ____  
//    / \    |  ___|_ _| \ | |_ _|  _ \ 
//   / _ \   | |_   | ||  \| || || |_) |
//  / ___ \  |  _|  | || |\  || ||  _ < 
// /_/   \_\ |_|   |___|_| \_|___|_| \_\
                                     

    /* Vérifie le type d'une variable
    *
    * @variable<mixed>              la variable à vérifier          
    * @dbtype<String>               le type correspondant à la vérification
    *
    *
    * @return correct<Boolean>      TRUE si le type est bon / FALSE si le type ne match pas
    *
    */
    public static function checkParam($variable, $dbtype){
        /* [1] on vérifie que $dbtype est un String
        =============================================================*/
        if( !is_string($dbtype) ) return false;


        /* [2] Vérifications
        =============================================================*/
        $checker = true; // contiendra VRAI si la vérification s'avère correcte

        switch($dbtype){
            // [1] 'M' / 'F' 
            case 'Civilité':
                $checker = $checker && is_string($variable) && in_array(array('M', 'F'), $variable);
                break;

            // [2] Nom de patient 
            case 'Nom':
                $checker = $checker && is_string($variable) && in_array(array('M', 'F'), $variable);
                break;


            // [N] Type inconnu
            default: $checker = false; break;
        }


        /* [3] On retourne le résultat de la vérif
        =============================================================*/
        return $checker;

    }


}

?>
