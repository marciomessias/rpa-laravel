<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Read\PdfFileController;

class ReadPdfFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'read:pdf-file';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Realizar a leitura de um arquivo pdf e salvar em csv';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        (new PdfFileController())->main();
    }
}
