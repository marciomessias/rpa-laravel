<?php

namespace App\Http\Controllers\RPA;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Facebook\WebDriver\Remote\LocalFileDetector;
use Facebook\WebDriver\WebDriverBy;
use App\Http\Controllers\DriverController;

class UploadFileController extends DriverController
{
    private $fileName = 'downloaded/Teste TKS';

    public function main()
    {
        try {

            $this->callFirstPage();

            $this->callSecondPage();

            Log::info('UploadFileController.main - RPA executado com sucesso!');

        } catch(\Exception $e) {

            Log::error("UploadFileController.main - {$e->getMessage()}");
        }
    }

    private function callFirstPage()
    {
        $this->driver->get('https://testpages.herokuapp.com/styled/file-upload-test.html');

        $this->driver->takeScreenshot(Storage::path('img/uploadFile/'.(new \DateTime('now'))->format('Y-m-d::H:i:s:u').'-UploadFileFirstPage.png'));

        $h1UploadForm = $this->driver->findElement(WebDriverBy::cssSelector('.page-body > h1'))->getText();
        if ($h1UploadForm !== 'Upload a File') {
            throw new \Exception('O elemento H1 com o título "Upload a File" não existe');
        }

        $fileInput = $this->driver->findElement(WebDriverBy::id('fileinput'));
        $fileInput->setFileDetector(new LocalFileDetector());
        $fileInput->sendKeys(Storage::path($this->fileName));

        $this->driver->findElement(WebDriverBy::id('itsafile'))->click();

        $this->driver->takeScreenshot(Storage::path('img/uploadFile/'.(new \DateTime('now'))->format('Y-m-d::H:i:s.u').'-UploadFileAfterSendFile.png'));

        $this->driver->findElement(WebDriverBy::name('upload'))->click();
    }

    private function callSecondPage()
    {
        $this->driver->takeScreenshot(Storage::path('img/uploadFile/'.(new \DateTime('now'))->format('Y-m-d::H:i:s:u').'-UploadFileSecondPage.png'));

        $h1UploadedFile = $this->driver->findElement(WebDriverBy::id('uploadedfilename'))->getText();
        if ($h1UploadedFile !== 'Teste TKS') {
            throw new \Exception('Não foi possível enviar o arquivo, o mesmo não apareceu na tela "Uploaded File"');
        }
    }
}
