<?php

namespace App\Http\Controllers\RPA;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverBy;
// use Facebook\WebDriver\Chrome\ChromeOptions;

class DownloadAndSaveFileController extends Controller
{
    public function init()
    {
        // $options = new ChromeOptions();
        // $prefs = array('download.default_directory' => env('DOWNLOAD_SELENIUM'));
        // $options->setExperimentalOption('prefs', $prefs);
        // $capabilities = DesiredCapabilities::chrome();
        // $capabilities->setCapability(ChromeOptions::CAPABILITY, $options);
        $driver = RemoteWebDriver::create(env('SERVER_SELENIUM'), DesiredCapabilities::chrome());

        try {

            $driver->manage()->timeouts()->implicitlyWait = 10;

            $driver->get('https://testpages.herokuapp.com/styled/download/download.html');

            $directDownloadId = $driver->findElement(WebDriverBy::id('direct-download'))->click();



            // $driver->takeScreenshot(Storage::path('img/'.(new \DateTime('now'))->format('Y-m-d|H:i:s.u').'-DownloadAndSaveFile.png'));

            Log::info('DownloadAndSaveFile.init - RPA executado com sucesso!');

        } catch(\Exception $e) {

            Log::error("DownloadAndSaveFile.init - {$e->getMessage()}");
        }

        // $driver->quit();
    }
}
