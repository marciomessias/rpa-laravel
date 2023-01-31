<?php

namespace App\Http\Controllers\RPA;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Facebook\WebDriver\Remote\LocalFileDetector;
use Facebook\WebDriver\WebDriverBy;
use App\Http\Controllers\DriverController;

class FillAndSubmitFormController extends DriverController
{
    private $userName = 'marciomessias';
    private $password = 'pwdfillteste';
    private $comments = 'Comentario TextArea basic form test';
    private $fileName = 'doc/fillAndSubmitForm.txt';

    public function main()
    {
        try {

            $this->callFirstPage();

            $this->callSecondPage();

            Log::info('FillAndSubmitFormController.main - RPA executado com sucesso!');

        } catch(\Exception $e) {

            Log::error("FillAndSubmitFormController.main - {$e->getMessage()}");
        }
    }

    private function callFirstPage()
    {
        $this->driver->get('https://testpages.herokuapp.com/styled/basic-html-form-test.html');

        $this->driver->takeScreenshot(Storage::path('img/'.(new \DateTime('now'))->format('Y-m-d::H:i:s:u').'-fillAndSubmitFormFirstPage.png'));

        $h1BasicForm = $this->driver->findElement(WebDriverBy::cssSelector('.page-body > h1'))->getText();
        if ($h1BasicForm !== 'Basic HTML Form Example') {
            throw new \Exception('O elemento H1 com o título "Basic HTML Form Example" não existe');
        }

        #Username
        $this->driver->findElement(WebDriverBy::name('username'))->clear();
        $this->driver->findElement(WebDriverBy::name('username'))->click();
        $this->driver->getKeyboard()->sendKeys($this->userName);

        #Password
        $this->driver->findElement(WebDriverBy::name('password'))->clear();
        $this->driver->findElement(WebDriverBy::name('password'))->click();
        $this->driver->getKeyboard()->sendKeys($this->password);

        #TextArea Comment
        $this->driver->findElement(WebDriverBy::name('comments'))->clear();
        $this->driver->findElement(WebDriverBy::name('comments'))->click();
        $this->driver->getKeyboard()->sendKeys($this->comments);

        #criar arquivo de teste para o formulário
        Storage::disk('local')->put($this->fileName, 'Arquivo de teste - fill and submit form');

        #Filename
        $fileInput = $this->driver->findElement(WebDriverBy::name('filename'));
        $fileInput->setFileDetector(new LocalFileDetector());
        $fileInput->sendKeys(Storage::path($this->fileName));

        #Checkbox Items
        $isSelectedCb3 = $this->driver->findElement(WebDriverBy::cssSelector('input[value=cb3]'))->isSelected();
        if(!$isSelectedCb3) {
            $this->driver->findElement(WebDriverBy::cssSelector('input[value=cb3]'))->click();
        }
        $isSelectedCb1 = $this->driver->findElement(WebDriverBy::cssSelector('input[value=cb1]'))->isSelected();
        if(!$isSelectedCb1) {
            $this->driver->findElement(WebDriverBy::cssSelector('input[value=cb1]'))->click();
        }

        #Radio Items
        $this->driver->findElement(WebDriverBy::cssSelector('input[value=rd1]'))->click();

        #Multiple Select Values
        $isSelectedMs2 = $this->driver->findElement(WebDriverBy::cssSelector('select > option[value=ms2]'))->isSelected();
        if(!$isSelectedMs2) {
            $this->driver->findElement(WebDriverBy::cssSelector('select > option[value=ms2]'))->click();
        }
        $isSelectedMs4 = $this->driver->findElement(WebDriverBy::cssSelector('select > option[value=ms4]'))->isSelected();
        if(!$isSelectedMs4) {
            $this->driver->findElement(WebDriverBy::cssSelector('select > option[value=ms4]'))->click();
        }

        $this->driver->takeScreenshot(Storage::path('img/'.(new \DateTime('now'))->format('Y-m-d::H:i:s.u').'-fillAndSubmitFilledForm.png'));

        #Dropdown
        $this->driver->findElement(WebDriverBy::cssSelector('select > option[value=dd1]'))->click();

        #submit
        $this->driver->findElement(WebDriverBy::cssSelector('input[type=submit]'))->click();
    }

    private function callSecondPage()
    {
        $this->driver->takeScreenshot(Storage::path('img/'.(new \DateTime('now'))->format('Y-m-d::H:i:s:u').'-fillAndSubmitAfterSubmit.png'));

        #verificar se a tela seguinte ao submit tem o título 'Processed Form Details'
        $h1ProcessForm = $this->driver->findElement(WebDriverBy::cssSelector('.page-body > h1'))->getText();
        if ($h1ProcessForm !== 'Processed Form Details') {
            throw new \Exception('Não foi possível submeter o formulário, o elemento H1 com o título "Processed Form Details" não existe');
        }
    }
}
