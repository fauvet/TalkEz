<?php
/**
 * Created by PhpStorm.
 * User: seekdasky
 * Date: 03/12/15
 * Time: 22:17
 */

require_once('autoloader.php');

$tweets = ["Gros tremblement de terre à Paris, quelle catastrophe",
            "Ce nouveau film est un veritable tremblement de terre dans le millieu du cinéma",
            "#Paris #TremblementDeTerre",
            "J'aime le fromage",
            "attentat a Paris, 20 mort",
            "#Attentat au bataclan!"];

$keywords = [["catastrophe",2],
            ["tremblement de terre",5],
            ["attentat",10],
            ["mort",2]];

$parser = new EventParser($tweets,$keywords);

$parser->detectEvents();

foreach($parser->getEvents() as $event){
    if($event->getEntries() == null){
        continue;
    }
    var_dump($event->getWeigth());
    foreach($event->getEntries() as $entry){
        var_dump($entry->getData());
    }
    var_dump($event->getHighImportanceKeyword());
    var_dump($event->getLowImportanceKeyword());
}
