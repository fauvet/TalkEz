<?php

/**
 * Created by PhpStorm.
 * User: seekdasky
 * Date: 03/12/15
 * Time: 21:21
 */
class Entry
{
    private $weight;

    private $criteria;

    private $keyWords;

    public function __construct(array $criteria,array $words)
    {
        $this->keyWords = $words;
        $this->criteria = $criteria;
        $this->extractKeyWord();

        $this->weight = $this->calcWeigth();
    }

    public function calcWeigth() : int{
        $criteria = &$this->criteria;
        $multiplicateur = 1;
        foreach($criteria['keyWord'] as $key){
            $multiplicateur *= 1+0.8*$key[1];
        }
        foreach($criteria['isRelated'] as $link){
            $multiplicateur *= 1+1.5*$link.getweigth();
        }
        return $multiplicateur/(0.01*strlen($this->criteria['data']));
    }

    private function extractKeyWord(){
        $data = $this->criteria['data'];
        $this->criteria['keyWord'] = [];
        $keywords = explode(' ',$data);
        foreach($this->keyWords as $keyword){
            if(strpos($data,$keyword[0]) !== false){
                array_push($this->criteria['keyWord'],$keyword);
            }
            if(strpos(str_replace(' ','',$data),$keyword[0]) !== false and strpos($keyword[0],'#') !== false and strpos($data,$keyword[0]) == false){
                array_push($this->criteria['keyWord'],$keyword);
            }
        }
    }

    public function getCommonWeight(Entry $e) : int{
        $keywordsA = $e->getKeywords();
        $weigth = 0;
        foreach($keywordsA as $keywordA){
            $keywordA = str_replace(' ','',$keywordA);
            $keywordA = str_replace('#','',$keywordA);
            foreach($this->criteria['keyWord'] as $keywordB){
                $keywordB = str_replace(' ','',$keywordB);
                $keywordB = str_replace('#','',$keywordB);
                if($keywordA[0] == $keywordB[0]){
                    $weigth += $keywordB[1]+$keywordA[1];
                }
            }
        }
        return $weigth;
    }

    public function getKeywords():array{
        return $this->criteria['keyWord'];
    }

    public function getDaya(): string{
        return $this->criteria['data'];
    }

    public function equals(Entry $e): bool{
        return $this->criteria['data'] == $e->getData();
    }

    public function getWeight() :int{
        return $this->weight;
    }

    public function getData():string{
        return $this->criteria['data'];
    }
}