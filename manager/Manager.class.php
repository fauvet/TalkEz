<?php

class Manager{

    private $listManagers;

    private $managerFound;
    private $commandFound;


    //a la construction, on récupère la liste des managers enregistrés et on les stocke
    public function __construct(){

        $this->listManagers = json_decode(file_get_contents($GLOBALS['managers_dir'].DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'managers.json'),true);
    }

    /**
     *recherche un manager ayant un nom et une commande identique aux paramètres et stocke le résultata dans l'objet
     *pour une execution future
     *@param  String managerName     Nom du manager a appeller
     *@param  String managerCommand  Nom de la commande appellée
     *@return bool   manager         trouvé
     *
     */
    public function match($managerName,$managerCommand){
        foreach($this->listManagers as $cleNom=>$manager){
            if($cleNom == $managerName){
                foreach($manager as $cleCommande=>$command){
                    if($cleCommande == $managerCommand){
                        // ajout du cas de l'authentificateur
                        $this->managerFound = new $managerName();
                        $this->commandFound = $command;
                        return true;
                    }
                }
            }
        }
        return false;
    }

    /**
     * Execute la commande du manager trouvé, attention si la commande a besoin de paramètres, ils seront générés a partir
     * de toutes les données passées en POST et les recherchera par clé, pensez donc a donner le bon nom aux inputs des formulaires
     * pour que la commande trouve bien les variables
     *
     * @param     array params    Tableau de paramètre a passer a la commande
     * @return    json  résultat  rendu par le manager au format json
     */

    public function dispatch($params){
        if(($this->managerFound instanceof Authentification) or (Authentification::checkUser($this->commandFound['role'],$this->commandFound['strict']))){
            if(method_exists($this->managerFound,$this->commandFound['method'])){
                $evalCommand = '$this->managerFound->'.$this->commandFound['method'].'($params)?>';
                eval($evalCommand);
            }else{
                Response::quickResponse(500,json_encode("La méthode: ".$this->commandFound['method'].' n\'est pas présente dans le manager'));
            }
        }else{
            Response::quickResponse(403,json_encode(['message' => 'vous n\'estes pas autorisé a faire cette action' ]));
        }
    }

}
?>
