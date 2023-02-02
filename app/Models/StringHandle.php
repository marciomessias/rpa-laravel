<?php

namespace App\Models;

class StringHandle
{
    private $string;

    private $currentStringPage;

    private $arrayData = [];

    public function __construct($string)
    {
        $this->string = $string;
    }

    public function getArrayData()
    {
        return $this->arrayData;
    }

    public function setArrayData(Array $arrayData)
    {
        $this->arrayData = $arrayData;
    }

    protected function getString()
    {
        return $this->string;
    }

    protected function setCurrentStringPage($currentStringPage)
    {
        $this->currentStringPage = $currentStringPage;
    }

    protected function getStringPartFromCoordinates($start = false, $end = false, $indice = 1)
    {
        if($start) {
            $strposStart = strpos($this->currentStringPage, $start);
            $substrStart = substr($this->currentStringPage, $strposStart + strlen($start), 500);
            $strposEnd = $end === false ? 500 : strpos($substrStart, $end);
            $substrString = substr($substrStart, 0, $strposEnd);
            $array = explode(PHP_EOL, $substrString);
            return trim(substr($array[$indice], 1, strlen($array[1]) - 6)); 
        }

        if($end) {
            $strposEnd = strpos($this->currentStringPage, $end);
            $substrString = substr($this->currentStringPage, 0, $strposEnd);
            $array = array_reverse(explode(PHP_EOL, $substrString));
            return trim(substr($array[$indice], 1, strlen($array[$indice]) - 6));
        }

        return '';
    }

    protected function getFilteredStringByCoordinates($start = false, $end = false, $indice = 0)
    {
        preg_match_all('/\(.*\) Tj/', $this->getStringByCoordinates($start, $end), $extractRows);
        $rows = $start === false ? array_reverse($extractRows[0]) : $extractRows[0];
        return trim(preg_replace('/\(|\) Tj/', '', $rows[$indice]));
    }

    private function getStringByCoordinates($start = false, $end = false)
    {
        $substrString = '';

        if($start) {
            $strposStart = strpos($this->currentTextPage, $start);
            $substrStart = substr($this->currentTextPage, $strposStart + strlen($start), 500);
            $strposEnd = $end === false ? 500 : strpos($substrStart, $end);
            $substrString = substr($substrStart, 0, $strposEnd);
        }

        if(!$start && $end) {
            $strposEnd = strpos($this->currentTextPage, $end);
            $substrString = substr($this->currentTextPage, 0, $strposEnd);
        }

        return $substrString;
    }
}
