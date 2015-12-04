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

    private $keyword;

    public function __construct(array $items,array $keywords){
        $this->items = $items;

        $this->keyword = $keywords;
    }

    public function detectEvents(): bool{
        $returned = [];
        $entries = [];
        foreach($this->items as $item){
            $entry = new Entry(['data' => strtolower($item),'isRelated' => []],$this->keyword);
            array_push($entries,$entry);
        }
        $commons=[[]];
        $alreadyDone = [];
        $size = 0;
        foreach($entries as $entry){

            $stop = false;
            foreach($alreadyDone as $done){
                if($done->equals($entry)){
                    $stop =true;
                }
            }
            if($stop){
                continue;
            }

            foreach($entries as $entryTarget){

                $stop = false;
                foreach($alreadyDone as $done){
                    if($done->equals($entryTarget)){
                        $stop =true;
                    }
                }
                if($stop){
                    continue;
                }


                $found = false;
                foreach($commons as $key => $common){
                    foreach($common as $entryIn){
                        if($entryTarget->getCommonWeight($entryIn) > $entryIn->getWeight()/20){
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
                if(!$found){
                    $size++;
                    $commons[$size] = [];
                    array_push($alreadyDone,$entry);
                    array_push($commons[$size],$entry);
                    break;
                }


            }
        }

        foreach($commons as $common){
            $event = new Event();
            foreach($common as $entry){
                $event->addEntry($entry);
            }
            array_push($returned,$event);
        }

        $this->events = $returned;
        return true;
    }

    public function getEvents() :array{
        return $this->events;
    }

}