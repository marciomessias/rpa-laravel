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

    protected function getIntervalPartFromText($start, $end, $direction = false)
    {
        $strlenStart = strlen($start);
        $strposStart = strpos($this->currentTextPage, $start);

        if (is_numeric($end)) {
            if ($direction == 'inverse') {
                $substrStart = trim(substr($this->currentTextPage, $strposStart - $end));
                $substrString = trim(substr($substrStart, 0, $end));
            } else {
                $substrStart = trim(substr($this->currentTextPage, $strposStart + $strlenStart));
                $substrString = trim(substr($substrStart, 0, $end));
            }
        } else {
            $substrStart = trim(substr($this->currentTextPage, $strposStart + $strlenStart));
            $strposEnd = strpos($substrStart, $end);
            $substrString = trim(substr($substrStart, 0, $strposEnd));
        }

        return $substrString;
    }
}
