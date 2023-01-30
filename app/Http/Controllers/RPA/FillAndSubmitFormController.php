<?php

namespace App\Http\Controllers\RPA;

use Illuminate\Support\Facades\Log;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverBy;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FillAndSubmitFormController extends Controller
{
    private $userName = 'marciomessias';
    private $password = 'pwdfillteste';
    private $comments = 'Comentario TextArea basic form test';

    public function init()
    {
        $driver = RemoteWebDriver::create(env('SERVER_SELENIUM'), DesiredCapabilities::chrome());

        try {

            $driver->get('https://testpages.herokuapp.com/styled/basic-html-form-test.html');

            $driver->manage()->window()->maximize();

            $h1BasicForm = $driver->findElement(WebDriverBy::cssSelector('.page-body > h1'))->getText();
            if (strcmp($h1BasicForm, 'Basic HTML Form Example')) {
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

            #Dropdown
            $driver->findElement(WebDriverBy::cssSelector('select > option[value=dd1]'))->click();

            #submit
            $driver->findElement(WebDriverBy::cssSelector('input[type=submit]'))->click();

            #verificar se a tela seguinte ao submit tem o título 'Processed Form Details'
            $h1ProcessForm = $driver->findElement(WebDriverBy::cssSelector('.page-body > h1'))->getText();
            if (strcmp($h1ProcessForm, 'Processed Form Details')) {
                throw new \Exception('Não foi possível submeter o formulário, o elemento H1 com o título "Processed Form Details" não existe');
            }

            Log::info('FillAndSubmitFormController.init - RPA executado com sucesso!');

        } catch(\Exception $e) {

            Log::error("FillAndSubmitFormController.init - {$e->getMessage()}");

        }

        $driver->quit();

    }
}
