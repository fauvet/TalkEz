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

    public function addEntry(Entry $e) : bool{
        array_push($this->entries,$e);
        $this->weight += $e->getWeight();

        return true;
    }

    public function getEntries(): array{
        return $this->entries;
    }

    public function getWeigth() :int{
        return $this->weight;
    }

}