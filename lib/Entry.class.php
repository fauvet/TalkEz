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

    /** Calcule le poid d'un message (en fonction de ses mots clé et du poid de ceux-ci, le calcul se fait en fonction du poid du mot clé mais aussi
     * de la taille du message, pour pénaliser les mots clé isolés
     * @return int
     */
    public function calcWeigth() : int{
        $criteria = &$this->criteria;
        $multiplicateur = 1;
        foreach($criteria['keyWord'] as $key){
            $multiplicateur *= 1+0.8*$key[1]*(count($this->criteria['keyWord'])/30);
        }
        return $multiplicateur/(0.01*strlen($this->criteria['data']));
    }

    /**
     * extrait les mots clé et hashtag étant contenu par le message
     */
    private function extractKeyWord(){
        $data = $this->criteria['data'];
        $this->criteria['keyWord'] = [];
        foreach($this->keyWords as $keyword){
            //si notre mot clé peut être identifié tel quel dans la chaine (expression avec espace, etc...)
            if(strpos($data,$keyword[0]) !== false ){
                array_push($this->criteria['keyWord'],$keyword);
                $hashtag = $keyword;
                $hashtag[0] = '#'.str_replace(' ','',$keyword[0]);
                $hashtag[1] *= 3;
                array_push($this->criteria['keyWord'],$hashtag);
                //si c'est un hashtag (plus d'imporance)
            }elseif(strpos($data,'#'.str_replace(' ','',$keyword[0])) !== false){
                $hashtag = $keyword;
                $hashtag[0] = '#'.str_replace(' ','',$keyword[0]);
                $hashtag[1] *= 3;
                array_push($this->criteria['keyWord'],$hashtag);
                //si c'est un mot collé mais toujours identifiable
            }elseif(strpos(str_replace(' ','',$data),$keyword[0]) !== false and strpos($keyword[0],'#') !== false){
                array_push($this->criteria['keyWord'],$keyword);
                $hashtag = $keyword;
                $hashtag[0] = '#'.str_replace(' ','',$keyword[0]);
                $hashtag[1] *= 3;
                array_push($this->criteria['keyWord'],$hashtag);
            }
        }
    }

    /**retourne un poid correspondant aux points commun entre deux entries
     * @param Entry $e
     * @return int
     */
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