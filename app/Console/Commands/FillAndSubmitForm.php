<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\RPA\FillAndSubmitFormController;

class FillAndSubmitForm extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rpa:form';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Preencher formulário e submeter dados';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        (new FillAndSubmitFormController)->init();
    }
}
