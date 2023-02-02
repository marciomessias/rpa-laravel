<?php

namespace App\Models;

class TextToArrayHandle
{
    private $text;

    private $currentTextPage;

    private $arrayData = [];

    public function __construct($text)
    {
        $this->text = $text;
    }

    public function getArraydata()
    {
        return $this->arrayData;
    }

    public function setArraydata(Array $arrayData)
    {
        $this->arrayData = $arrayData;
    }

    protected function getText()
    {
        return $this->text;
    }

    protected function setCurrentTextPage($currentTextPage)
    {
        $this->currentTextPage = $currentTextPage;
    }

    protected function getStringPartFromCoordinates($start = false, $end = false, $indice = 1)
    {
        if($start) {
            $strposStart = strpos($this->currentTextPage, $start);
            $substrStart = substr($this->currentTextPage, $strposStart + strlen($start), 500);
            $strposEnd = $end === false ? 500 : strpos($substrStart, $end);
            $substrString = substr($substrStart, 0, $strposEnd);
            $array = explode(PHP_EOL, $substrString);
            return trim(substr($array[$indice], 1, strlen($array[1]) - 6)); 
        }

        if($end) {
            $strposEnd = strpos($this->currentTextPage, $end);
            $substrString = substr($this->currentTextPage, 0, $strposEnd);
            $array = array_reverse(explode(PHP_EOL, $substrString));
            return trim(substr($array[$indice], 1, strlen($array[$indice]) - 6));
        }

        return '';
    }
}
