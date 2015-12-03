<?php

class View{

    private $Data;

    private $Directory;

    public function __construct($directory){
        $this->Data=array();
        $this->Directory = rtrim($directory, DIRECTORY_SEPARATOR);
    }

    public function clear(){
        $this->Data=array();
    }

    public function getData(){
        return $this->Data;
    }

    public function getTemplatePathname($file)
    {
        return $this->Directory . DIRECTORY_SEPARATOR . ltrim($file, DIRECTORY_SEPARATOR) . '.php';
    }

    public function passData($data){
        if(!is_array($data)){
            return false;
        }elseif(is_array($data)){
            $this->Data = array_merge($this->Data,$data);
            return true;
        }
    }

    public function render($template){
        $templatePathname = $this->getTemplatePathname($template);
        if (!is_file($templatePathname)) {
            return false; //("Impossible de charger le template $template : le fichier n'existe pas");
        }
        extract($this->Data);
        extract(array('View'=>new View($this->Directory)));
        ob_start();
        require $templatePathname;
        return ob_get_clean();

    }

    public function with($template,$data=array()){
        $View = new View($this->Directory);
        $View->passData($data);
        return $View->render($template);
    }
}

?>