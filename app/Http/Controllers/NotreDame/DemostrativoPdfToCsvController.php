<?php

namespace App\Http\Controllers\NotreDame;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\NotreDame\Demostrativo;

class DemostrativoPdfToCsvController
{
    private $demostrativo;

    public function main()
    {
        try {

            $text = Storage::get('public/Leitura PDF.pdf');

            $this->demostrativo = new Demostrativo($text);

            $this->demostrativo->extractInfoFromText();

            $this->createCsvFile();

            Log::info('DemostrativoPdfToCsvController.main - Extração dos dados do pdf para CSV realizado com sucesso!');

        } catch(\Exception $e) {

            Log::error("DemostrativoPdfToCsvController.main - {$e->getMessage()}");
        }
    }

    private function createCsvFile()
    {
        $fopen = fopen(Storage::path('public/demonstrativo.csv'), 'w');

        foreach ($this->demostrativo->getArraydata() as $row) {
            fputcsv($fopen, $row);
        }

        fclose($fopen);
    }
}
