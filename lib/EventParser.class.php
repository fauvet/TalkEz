<?php

/**
 * Created by PhpStorm.
 * User: seekdasky
 * Date: 03/12/15
 * Time: 22:32
 */
class EventParser
{
    private $items;

    private $events;

    private $keyword = [];

    /**
     * EventParser constructor.: a besoin d'une liste de message et d'une liste de mot clé avec leur poid
     * @param array $items
     * @param array $keywords
     */
    public function __construct(array $items,array $keywords){
        $this->items = $items;

        $this->keyword = $keywords;
    }

    /** Parse tout les messages et les tris dans des évenements
     * @return bool
     */
    public function detectEvents(): bool{
        $returned = [];
        $entries = [];
        //on passe tout en minuscule par sécurité
        foreach($this->items as $item){
            $entry = new Entry(['data' => strtolower($item)],$this->keyword);
            array_push($entries,$entry);
        }
        $commons=[[]];
        $alreadyDone = [];
        $size = 0;
        //on parcours tout les messages
        foreach($entries as $entry){

            //vérification anti-doublon
            $stop = false;
            foreach($alreadyDone as $done){
                if($done->equals($entry)){
                    $stop =true;
                }
            }
            if($stop){
                continue;
            }

            //on parcours les autres messages
            foreach($entries as $entryTarget){

                //vérification anti-doublon
                $stop = false;
                foreach($alreadyDone as $done){
                    if($done->equals($entryTarget)){
                        $stop =true;
                    }
                }
                if($stop){
                    continue;
                }


                //on compare les messages et détecte un seuil de similarité pour savoir lesquels sont en rapport
                $found = false;
                foreach($commons as $key => $common){
                    //on parcours nos evenements pour trouver si un évenement peut être en rapport avec notre message
                    foreach($common as $entryIn){
                        //calcul du seuil
                        if($entryTarget->getCommonWeight($entryIn) > $entryTarget->getWeight()/30){
                            $found = true;
                            array_push($commons[$key],$entryTarget);
                            array_push($alreadyDone,$entryTarget);
                            break;
                        }
                        if($found){
                            break;
                        }
                    }
                }
                //si le message n'a pas d'évenement qui lui conviens, on en créer un
                if(!$found){
                    $size++;
                    $commons[$size] = [];
                    array_push($alreadyDone,$entry);
                    array_push($commons[$size],$entry);
                    break;
                }


            }
        }

        //on range tout comme il faut
        foreach($commons as $common){
            $event = new Event();
            foreach($common as $entry){
                $event->addEntry($entry);
            }
            array_push($returned,$event);
        }

        //et c'est parti mon kiki
        $this->events = $returned;
        return true;
    }

    /**
     * @return mixed
     */
    public function getEvents() :array{
        return $this->events;
    }

}