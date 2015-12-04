<?php

/*
 * fonction d'autoloading : prend en paramètre le nom de la classe et s'occupe d'inclure les fichiers correspondant aux classes
 */

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

function autoloader($class) {

    //si on charge le StaticRepo
    if(strpos($class, 'StaticRepo') !== FALSE){
        require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'repositories'.DIRECTORY_SEPARATOR.$class . '.php';
    }
    //si on charge un Repo
    elseif(strpos($class, 'Repo') !== FALSE){
        require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'repositories'.DIRECTORY_SEPARATOR.'repos'.DIRECTORY_SEPARATOR.$class . '.php';

        //cas particuliers pas identifiable par nom de classe
    }else{
        //si on charge un manager
        if(is_file(dirname(__FILE__).DIRECTORY_SEPARATOR.'managers'.DIRECTORY_SEPARATOR.$class . '.class.php')){
            require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'managers'.DIRECTORY_SEPARATOR.$class . '.class.php';
        }elseif(is_file(dirname(__FILE__).DIRECTORY_SEPARATOR.'Libs'.DIRECTORY_SEPARATOR.$class . '.class.php')){
            require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'Libs'.DIRECTORY_SEPARATOR.$class . '.class.php';
        }

    }
}

//enregistrememnt de la fonction tout en bas de la pile pour ne pas casser l'autoloader de phpUnit
spl_autoload_register('autoloader',false,true);


?>
