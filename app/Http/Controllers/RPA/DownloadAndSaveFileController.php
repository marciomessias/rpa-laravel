<?php

namespace App\Http\Controllers\RPA;

use App\Http\Controllers\DriverController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Facebook\WebDriver\WebDriverBy;

class DownloadAndSaveFileController extends DriverController
{
    private $seleniumPath;

    public function __construct()
    {
        parent::__construct();
        $this->seleniumPath = Storage::path('selenium/');
    }

    public function init()
    {
        try {

            $this->callFirstPage();

            sleep(3);

            Storage::copy("selenium/{$this->getLastFile()}", 'downloaded/Teste TKS');

            Log::info('DownloadAndSaveFile.init - RPA executado com sucesso!');

        } catch(\Exception $e) {

            Log::error("DownloadAndSaveFile.init - {$e->getMessage()}");
        }
    }

    private function callFirstPage()
    {
        $this->driver->get('https://testpages.herokuapp.com/styled/download/download.html');

        $this->driver->findElement(WebDriverBy::id('direct-download'))->click();
    }

    private function getLastFile()
    {
        $timestamp = null;
        $lastFile = null;

        $directory = new \DirectoryIterator($this->seleniumPath);
        foreach ($directory as $info) {
            if (!$info->isDot() && $info->getMTime() > $timestamp) {
                $lastFile = $info->getFilename();
                $timestamp = $info->getMTime();
            }
        }

        return $lastFile;
    }
}
