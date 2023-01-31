<?php

namespace App\Http\Controllers\RPA;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Facebook\WebDriver\WebDriverBy;
use App\Http\Controllers\DriverController;

class DownloadAndSaveFileController extends DriverController
{
    private $seleniumPath;

    public function __construct()
    {
        parent::__construct();
        $this->seleniumPath = Storage::path('selenium/');
    }

    public function main()
    {
        try {

            $this->callFirstPage();

            sleep(3);

            Storage::copy("selenium/{$this->getLastFile()}", 'downloaded/Teste TKS');

            Log::info('DownloadAndSaveFile.main - RPA executado com sucesso!');

        } catch(\Exception $e) {

            Log::error("DownloadAndSaveFile.main - {$e->getMessage()}");
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
