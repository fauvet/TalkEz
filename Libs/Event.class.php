<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: seekdasky
 * Date: 03/12/15
 * Time: 21:21
 */
class Event
{
    private $entries;

    private $weight;

    public function __construct()
    {
        $this->entries = [];
        $this->weight = 0;
    }

    /**
     * @param Entry ajoute une entrée a un évenement $e
     * @return bool
     */
    public function addEntry(Entry $e) : bool{
        array_push($this->entries,$e);
        $this->weight += $e->getWeight();

        return true;
    }

    /**
     * @return mixed
     */
    public function getEntries(): array{
        return $this->entries;
    }

    /**
     * @return int
     */
    public function getWeigth() :int{
        return $this->weight;
    }

    /**
     * @return mixed
     */
    public function getHighImportanceKeyword():array{
        $keywords = [];
        //parcours tout les mots clé de toutes les entries et les met dans un tableau
        foreach($this->entries as $entry){
            foreach($entry->getKeywords() as $keyword){
                array_push($keywords,$keyword[0]);
            }
        }
        //compte le nombre d'occurence de chaque mot clé
        $keywords = array_count_values($keywords);
        //tri
        arsort($keywords);
        //retourne le premier mot clé (et son hashtag)
        return array_slice($keywords,0,2);
    }

    /**
     * @return mixed
     */
    public function getLowImportanceKeyword():array{
        $keywords = [];
        //parcours tout les mots clé de toutes les entries et les met dans un tableau
        foreach($this->entries as $entry){
            foreach($entry->getKeywords() as $keyword){
                array_push($keywords,$keyword[0]);
            }
        }
        //compte le nombre d'occurence de chaque mot clé
        $keywords = array_count_values($keywords);
        //tri
        asort($keywords);
        //retourne le premier mot clé (et son hashtag)
        return array_slice($keywords,0,2);
    }

}