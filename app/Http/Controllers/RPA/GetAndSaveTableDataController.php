<?php

namespace App\Http\Controllers\RPA;

use Illuminate\Support\Facades\Log;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverBy;
use App\Http\Controllers\Controller;
use App\Models\RpaTableData;

class GetAndSaveTableDataController extends Controller
{
    private const NAME = '0';
    private const AMOUNT = '1';

    public function init()
    {
        $driver = RemoteWebDriver::create(env('SERVER_SELENIUM'), DesiredCapabilities::chrome());

        try {

            $driver->get('https://testpages.herokuapp.com/styled/tag/table.html');

            $trs = $driver->findElements(WebDriverBy::cssSelector('#mytable tr'));

            array_shift($trs);

            foreach($trs as $tr) {

                $tds = $tr->findElements(WebDriverBy::cssSelector('td'));

                RpaTableData::create([
                    'name' => $tds[self::NAME]->getText(),
                    'amount' => $tds[self::AMOUNT]->getText()
                ]);
            }

            Log::info('GetAndSaveTableDataController.init - RPA executado com sucesso!');

        } catch(\Exception $e) {

            Log::error("GetAndSaveTableDataController.init {$e->getMessage()}");
        }

        $driver->quit();

    }
}
