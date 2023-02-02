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

    protected function getFilteredStringByCoordinates($start = false, $end = false, $indice = 0)
    {
        preg_match_all('/\(.*\) Tj/', $this->getStringByCoordinates($start, $end), $extractRows);

        if (count($extractRows[0]) > 0) {
            $rows = $start === false ? array_reverse($extractRows[0]) : $extractRows[0];
            return trim(preg_replace('/\(|\) Tj/', '', $rows[$indice]));
        }

        return '';
    }

    protected function getStringByCoordinates($start = false, $end = false)
    {
        if($start) {
            $strposStart = strpos($this->currentStringPage, $start);
            $substrStart = substr($this->currentStringPage, $strposStart + strlen($start), 500);
            $strposEnd = $end === false ? 500 : strpos($substrStart, $end);
            return substr($substrStart, 0, $strposEnd);
        }

        if(!$start && $end) {
            $strposEnd = strpos($this->currentStringPage, $end);
            return substr($this->currentStringPage, 0, $strposEnd);
        }

        return '';
    }
}
