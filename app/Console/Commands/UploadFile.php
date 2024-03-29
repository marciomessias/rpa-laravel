<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\RPA\UploadFileController;

class UploadFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rpa:upload-file';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upload de arquivo salvo em disco local';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        (new UploadFileController)->main();
    }
}
