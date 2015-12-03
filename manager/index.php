<?php

//CONFIGURATION: compression de la réponse
$GLOBALS['compression'] = true;
//variable globale pour accéder aux dossiers des managers
$GLOBALS['managers_dir'] = dirname(__FILE__);

session_start();
if($GLOBALS['compression']){
    ob_start("ob_gzhandler");
}else{
    ob_start();
}

//les managers ne renvoient QUE du json, on met donc le header de la réponse a jour
//header('Content-Type: application/json');
//on inclu l'autoloader
include(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'autoloader.php');

$manager = new Manager();

//on récupère la commande et la parse pour être executée
if(isset($_POST['command'])){
    $commands = explode(':',$_POST['command']);
    $managerName = $commands[0];
    $managerCommand = $commands[1];

    //on supprime la commande de la variable globale, les managers n'ont pas a la connaitre et a l'utiliser
    unset($_POST['command']);

    //si on trouve la commande on l'execute
    if($manager->match($managerName,$managerCommand)){
        $manager->dispatch($_POST);
    }else{
        $response = json_encode(['result' => false,
            'message' => "commande inexistante"]);
        $objectResponse = new Response(404);
        $objectResponse->write($response);
        $objectResponse->send();
    }

}
ob_end_clean();
?>
