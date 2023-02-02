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

    protected function getStringPartFromCoordinates($start, $end)
    {
        $strposStart = strpos($this->currentTextPage, $start);
        $substrStart = substr($this->currentTextPage, $strposStart + strlen($start), 100);
        $strposEnd = strpos($substrStart, $end);
        $substrString = substr($substrStart, 0, $strposEnd);
        $string = explode(PHP_EOL, $substrString);
        return substr($string[1], 1, strlen($string[1]) - 6);
    }
}
