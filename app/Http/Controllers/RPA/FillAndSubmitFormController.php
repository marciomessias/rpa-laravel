<?php

namespace App\Http\Controllers\RPA;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\LocalFileDetector;
use Facebook\WebDriver\WebDriverBy;

class FillAndSubmitFormController extends Controller
{
    private $userName = 'marciomessias';
    private $password = 'pwdfillteste';
    private $comments = 'Comentario TextArea basic form test';
    private $fileName = 'doc/fillAndSubmitForm.txt';

    public function init()
    {
        $driver = RemoteWebDriver::create(env('SERVER_SELENIUM'), DesiredCapabilities::chrome());

        try {

            $driver->manage()->timeouts()->implicitlyWait = 10;

            $driver->get('https://testpages.herokuapp.com/styled/basic-html-form-test.html');

            $driver->manage()->window()->maximize();

            $driver->takeScreenshot(Storage::path('img/'.(new \DateTime('now'))->format('Y-m-d|H:i:s.u').'-fillAndSubmitInicio.png'));

            $h1BasicForm = $driver->findElement(WebDriverBy::cssSelector('.page-body > h1'))->getText();
            if ($h1BasicForm !== 'Basic HTML Form Example') {
                throw new \Exception('O elemento H1 com o título "Basic HTML Form Example" não existe');
            }

            #Username
            $driver->findElement(WebDriverBy::name('username'))->clear();
            $driver->findElement(WebDriverBy::name('username'))->click();
            $driver->getKeyboard()->sendKeys($this->userName);

            #Password
            $driver->findElement(WebDriverBy::name('password'))->clear();
            $driver->findElement(WebDriverBy::name('password'))->click();
            $driver->getKeyboard()->sendKeys($this->password);

            #TextArea Comment
            $driver->findElement(WebDriverBy::name('comments'))->clear();
            $driver->findElement(WebDriverBy::name('comments'))->click();
            $driver->getKeyboard()->sendKeys($this->comments);

            #criar arquivo de teste para o formulário
            Storage::disk('local')->put($this->fileName, 'Arquivo de teste - fill and submit form');

            #Filename
            $fileInput = $driver->findElement(WebDriverBy::name('filename'));
            $fileInput->setFileDetector(new LocalFileDetector());
            $fileInput->sendKeys(Storage::path($this->fileName));

            #Checkbox Items
            $isSelectedCb3 = $driver->findElement(WebDriverBy::cssSelector('input[value=cb3]'))->isSelected();
            if(!$isSelectedCb3) {
                $driver->findElement(WebDriverBy::cssSelector('input[value=cb3]'))->click();
            }
            $isSelectedCb1 = $driver->findElement(WebDriverBy::cssSelector('input[value=cb1]'))->isSelected();
            if(!$isSelectedCb1) {
                $driver->findElement(WebDriverBy::cssSelector('input[value=cb1]'))->click();
            }

            #Radio Items
            $driver->findElement(WebDriverBy::cssSelector('input[value=rd1]'))->click();

            #Multiple Select Values
            $isSelectedMs2 = $driver->findElement(WebDriverBy::cssSelector('select > option[value=ms2]'))->isSelected();
            if(!$isSelectedMs2) {
                $driver->findElement(WebDriverBy::cssSelector('select > option[value=ms2]'))->click();
            }
            $isSelectedMs4 = $driver->findElement(WebDriverBy::cssSelector('select > option[value=ms4]'))->isSelected();
            if(!$isSelectedMs4) {
                $driver->findElement(WebDriverBy::cssSelector('select > option[value=ms4]'))->click();
            }

            $driver->takeScreenshot(Storage::path('img/'.(new \DateTime('now'))->format('Y-m-d|H:i:s.u').'-fillAndSubmitFormularioPreenchido.png'));

            #Dropdown
            $driver->findElement(WebDriverBy::cssSelector('select > option[value=dd1]'))->click();

            #submit
            $driver->findElement(WebDriverBy::cssSelector('input[type=submit]'))->click();

            $driver->takeScreenshot(Storage::path('img/'.(new \DateTime('now'))->format('Y-m-d|H:i:s.u').'-fillAndSubmitAposSubmit.png'));

            #verificar se a tela seguinte ao submit tem o título 'Processed Form Details'
            $h1ProcessForm = $driver->findElement(WebDriverBy::cssSelector('.page-body > h1'))->getText();
            if ($h1ProcessForm !== 'Processed Form Details') {
                throw new \Exception('Não foi possível submeter o formulário, o elemento H1 com o título "Processed Form Details" não existe');
            }

            Log::info('FillAndSubmitFormController.init - RPA executado com sucesso!');

        } catch(\Exception $e) {

            Log::error("FillAndSubmitFormController.init - {$e->getMessage()}");

        }

        $driver->quit();

    }
}
