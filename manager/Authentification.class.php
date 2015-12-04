<?php

class Authentification{

    private $users;

    public function __construct(){
        $this->users = json_decode(file_get_contents($GLOBALS['managers_dir'].DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'users.json'),true);
    }

    /**
     * méthode d'authentification, utilise param['identifiant'] et param['mdp'] et les comparent à
     * nos utilisateurs enregistrés puis créer une session securisée par token
     * @param  array $param contiens les infomations de connection
     * @return json         json contenant le résultat de l'authentification (true si authentification correcte, sinon non)
     */
    public function authentification($user,$mdp){
        foreach($this->users as $utilisateur=>$infos){
            if($utilisateur == $user and $infos['password'] == $mdp){
                $this->createSecureSession($user,$infos['role']);
                return true;
            }
        }
        return false;
    }

    /**
     * déconnecte l'utilisateur en détruisant la session et le cookie
     * @return  json renvoie true, il n'y aucune raison que ça foire
     */
    public function deconnection(){
        $this->destroySecureSession();
        Response::quickResponse(200,json_encode(['result' => true]));
    }

    /**
     * créer une session sécurisé , protégé du vol de session par identification de l'utilisateur par navigateur/ip/cookie
     * @param  String $user nom d'utilisateur
     * @param  String $role role de l'utilisateur (0=administrateur, 1= prof, 2=scolarité,3=élève)
     * @return void
     */
    private function createSecureSession($user,$role){
        $id = uniqid();
        $_SESSION['id'] = $id;
        $_SESSION['token'] = sha1($_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR'].$id);
        session_regenerate_id();

        $_SESSION['user'] = $user;
        $_SESSION['role'] = $role;

    }

    /**
     * Détruit une session
     * @return void
     */
    private function destroySecureSession(){
        session_destroy();
        setcookie('token',time()-1);
    }

    /**
     * Vérifie qu'un utilisateur donné a les droits demandés (passés en paramètres)
     * @param  int $role   role minimum
     * @param  boolean $strict si strict vaut true, seul les utilisateurs avec le role précis seront acceptés, sinon tout les utilisateurs
     * avec un role superieur le seront
     * @return boolean
     */
    public static function checkUser($role, $strict=false){
        if($role == -1){return true;}
        if(isset($_SESSION['token'])){
            foreach($_SESSION['role'] as $roleUser){
                if(($strict and $roleUser == $role) or (!$strict and  $roleUser<= $role)){
                    if($_SESSION['token'] == sha1($_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR'].$_SESSION['id'])){
                        session_regenerate_id();
                        return true;
                    };
                }
            }
        }
        return false;
    }

    public static function getCurrentUser(){
        return $_SESSION['user'];
    }
}
?>
