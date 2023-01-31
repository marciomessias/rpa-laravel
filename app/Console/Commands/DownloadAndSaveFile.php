<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\RPA\DownloadAndSaveFileController;

class DownloadAndSaveFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rpa:file-download';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Baixar e salvar em disco arquivo alterando seu nome';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        (new DownloadAndSaveFileController)->init();
    }
}
