<?php

namespace App\Http\Controllers\RPA;

use Illuminate\Support\Facades\Log;
use Facebook\WebDriver\WebDriverBy;
use App\Http\Controllers\DriverController;
use App\Models\RPA\TableData;

class GetAndSaveTableDataController extends DriverController
{
    private const NAME = '0';

    private const AMOUNT = '1';

    public function main()
    {
        try {

            $respTrs = $this->callFirstPage();

            $this->saveTrsData($respTrs);

            Log::info('GetAndSaveTableDataController.main - RPA executado com sucesso!');

        } catch(\Exception $e) {

            Log::error("GetAndSaveTableDataController.main - {$e->getMessage()}");
        }
    }

    private function callFirstPage()
    {
        $this->driver->get('https://testpages.herokuapp.com/styled/tag/table.html');

        $caption = $this->driver->findElement(WebDriverBy::cssSelector('#mytable > caption'))->getText();

        if ($caption !== 'This table has information') {
            throw new \Exception('Tabela "This table has information" não existe');
        }

        $trs = $this->driver->findElements(WebDriverBy::cssSelector('#mytable tr'));

        array_shift($trs);

        return $trs;
    }

    private function saveTrsData($trs)
    {
        foreach($trs as $tr) {

            $tds = $tr->findElements(WebDriverBy::cssSelector('td'));

            TableData::create([
                'name' => $tds[self::NAME]->getText(),
                'amount' => $tds[self::AMOUNT]->getText()
            ]);
        }
    }
}
