<?php

namespace App\Http\Controllers\RPA;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverBy;

class DownloadAndSaveFileController extends Controller
{
    private $seleniumPath;
    private $downloadedPath;

    public function __construction()
    {
        $this->seleniumPath = Storage::path('selenium/');
        $this->downloadedPath = Storage::path('downloaded/');
    }

    public function init()
    {
        $driver = RemoteWebDriver::create(env('SERVER_SELENIUM'), DesiredCapabilities::chrome());

        try {

            $driver->manage()->timeouts()->implicitlyWait = 10;

            $driver->get('https://testpages.herokuapp.com/styled/download/download.html');

            $directDownloadId = $driver->findElement(WebDriverBy::id('direct-download'))->click();

            sleep(3);

            // \File::move($this->seleniumPath.$this->getLastFile(), $this->downloadedPath.$this->getLastFile());

            Storage::move($this->seleniumPath.$this->getLastFile(), "{$this->downloadedPath}Teste TKS}");

            Log::info('DownloadAndSaveFile.init - RPA executado com sucesso!');

        } catch(\Exception $e) {

            Log::error("DownloadAndSaveFile.init - {$e->getMessage()}");
        }

        $driver->quit();
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
