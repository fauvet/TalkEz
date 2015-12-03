<?php

/*
 * La classe Response permet de gérer la réponse envoyée au client (status, contenu, type, encodage)
 * son utilitée principale est de pouvoir d'envoyer un pseudo-flux de donnée au client et permettre ainsi de suivre le déroulement
 * d'une opération côté serveur par exemple. Son second aventage est qu'une fois la réponse envoyée et féermée, le script PHP peut continuer de s'executer
 * permettant ainsi une sensation de vitesse au niveau du client (inutile d'attendre la fin des insertions en base de donnée pour avoir la réponse par exemple)
 */

class Response{

    private $status;
    private $headers = [];
    private $config = [];

    private $response = "";

    private $Messages = array(
        //Informational 1xx
        100 => '100 Continue',
        101 => '101 Switching Protocols',
        //Successful 2xx
        200 => '200 OK',
        201 => '201 Created',
        202 => '202 Accepted',
        203 => '203 Non-Authoritative Information',
        204 => '204 No Content',
        205 => '205 Reset Content',
        206 => '206 Partial Content',
        226 => '226 IM Used',
        //Redirection 3xx
        300 => '300 Multiple Choices',
        301 => '301 Moved Permanently',
        302 => '302 Found',
        303 => '303 See Other',
        304 => '304 Not Modified',
        305 => '305 Use Proxy',
        306 => '306 (Unused)',
        307 => '307 Temporary Redirect',
        //Client Error 4xx
        400 => '400 Bad Request',
        401 => '401 Unauthorized',
        402 => '402 Payment Required',
        403 => '403 Forbidden',
        404 => '404 Not Found',
        405 => '405 Method Not Allowed',
        406 => '406 Not Acceptable',
        407 => '407 Proxy Authentication Required',
        408 => '408 Request Timeout',
        409 => '409 Conflict',
        410 => '410 Gone',
        411 => '411 Length Required',
        412 => '412 Precondition Failed',
        413 => '413 Request Entity Too Large',
        414 => '414 Request-URI Too Long',
        415 => '415 Unsupported Media Type',
        416 => '416 Requested Range Not Satisfiable',
        417 => '417 Expectation Failed',
        418 => '418 I\'m a teapot',
        422 => '422 Unprocessable Entity',
        423 => '423 Locked',
        426 => '426 Upgrade Required',
        428 => '428 Precondition Required',
        429 => '429 Too Many Requests',
        431 => '431 Request Header Fields Too Large',
        //Server Error 5xx
        500 => '500 Internal Server Error',
        501 => '501 Not Implemented',
        502 => '502 Bad Gateway',
        503 => '503 Service Unavailable',
        504 => '504 Gateway Timeout',
        505 => '505 HTTP Version Not Supported',
        506 => '506 Variant Also Negotiates',
        510 => '510 Not Extended',
        511 => '511 Network Authentication Required'
    );

    /**
     * Constructeur de la Response
     * @param int $status status HTTP de la réponse (404,200,500, etc)
     * @param bool|false $stream Si la réponse est un stream (avtive/désactive les méthodes send/stream()
     * @param string $type type HTTP des données de retour
     * @param bool|true $clearBuffer si activé, vide le buffer avant chaque envoi de donnée (a pour effet de ne pas afficher les echo/printf)
     */
    public function __construct($status = 200,$stream = false,$type = 'application/json', $clearBuffer = false)
    {
        $this->status = $status;
        array_push($this->headers,['Content-Type',$type]);

        $this->config['clearBuffer'] = $clearBuffer;
        $this->config['stream'] = $stream;
    }

    /** Ajoute du contenu a la réponse qui sera envoyé (par stream() ou par send() )
     * @param $content contenu a ajouter a la réponse
     */
    public function write($content){
        $this->response .= $content;
    }

    /** Envoie une partie de réponse au client (doit être récupéré en ajax, aucun intéret sinon), chaque bloc de donéne envoyé est séparé par
     * un délimiteur ("//Block//" par défaut).ATTENTION: stream() vide la réponse (si on write() puis stream(), la réponse qu'il restera dans l'objet sera vide)
     * @param string $content contenu a envoyer (optionnel car on peut utiliser la méthode write pour le faire)
     * @throws Exception si la réponse n'est pas un stream
     */
    public function stream($content="",$delimiter = "//Block//"){
        //vérification que la réponse est un stream
        if(!$this->config['stream']){
            throw new Exception("Stream d'une réponse synchrone");
        }
        //si les headers ne sont pas encore envoyés, on le fait
        if(!headers_sent()){
            $this->sendHeader();
        }
        //si demandé, on clear le buffer avant d'envoyer
        if($this->config['clearBuffer']){
            ob_end_clean();
            if($GLOBALS['compression']){
                ob_start("ob_gzhandler");
            }else{
                ob_start();
            }
        }
        //on envoi le contenu de response et la variable content
        if($this->response!=""){
            echo $delimiter.$this->response;
        }if($content != ""){
            echo $delimiter.$content;
        }
        ob_flush();flush();
        $this->response = '';
    }

    /**
     * Envoi les headers de la réponse (status et ceux potentiellement défnini par l'utilisateur)
     */
    public function sendHeader(){
        //envoie le status de la requete (petit trick suivant l'architecture de PHP)
        if (strpos(PHP_SAPI, 'cgi') === 0) {
            header(sprintf('Status: %s', $this->Messages[$this->status]));
        } else {
            header(sprintf('HTTP/1.1 %s', $this->Messages[$this->status]));
        }
        //les autres headers
        foreach($this->headers as $header){
            header(sprintf('%s: %s',$header[0],$header[1]));
        }
    }

    /**
     * Défini un header qui sera envoyé
     * @param $header Nom du header
     * @param $value Valeur du header
     */
    public function setHeader($header,$value){
        array_push($this->headers,[$header,$value]);
    }

    /** Envoi la réponse et ferme la communication
     * @throws Exception si la réponse est un stream
     */
    public function send(){
        //vérification que la réponse n'est pas un stream
        if($this->config['stream']){
            throw new Exception("Envoi synchrone d'une réponse stream");
        }
        //si les headers ne sont pas encore envoyés, on le fait
        if(!headers_sent()){
            $this->sendHeader();
        }
        //si demandé, on clear le buffer avant d'envoyer
        if($this->config['clearBuffer']){
            ob_end_clean();
            if($GLOBALS['compression']){
                ob_start("ob_gzhandler");
            }else{
                ob_start();
            }
        }
        //envoi de la réponse
        echo $this->response;
        //fermeture de la communication
        header('Connection: close');
        header('Content-Length: '.ob_get_length());
        ob_end_flush();
        ob_flush();
        flush();
        //permet au reste du script de s'executer même si la réponse a été envoyé et que l'utilisateur interromp le script (changement de page, etc...)
        ignore_user_abort(true);
    }

    /**
     * @param int $status status HTTP de la réponse (404,200,500, etc)
     * @param $content
     * @param string $type
     */
    public static function quickResponse($status,$content,$type = 'application/json'){
        $response = new Response($status,false,$type);
        $response->write($content);
        $response->send();
    }
}
