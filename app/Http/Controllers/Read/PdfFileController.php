<?php

namespace App\Http\Controllers\Read;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Read\PdfFile;

class PdfFileController
{
    private $pdfFile;

    public function main()
    {
        try {

            $this->pdfFile = new PdfFile();

            $this->pdfFile->setPdfToText();

            $this->pdfFile->buildFieldsAndValues();

            $this->createCsvFile();

            Log::info('PdfFileController.main - Extração dos dados do pdf para CSV realizado com sucesso!');

        } catch(\Exception $e) {

            Log::error("PdfFileController.main - {$e->getMessage()}");
        }
    }

    private function createCsvFile()
    {
        $list = [
            $this->pdfFile->getFields(),
            $this->pdfFile->getValues()
        ];

        $fopen = fopen(Storage::path('public/demonstrativo.csv'), 'w');

        foreach ($list as $fields) {
            fputcsv($fopen, $fields);
        }

        fclose($fopen);
    }
}
