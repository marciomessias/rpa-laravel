<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\NotreDame\DemostrativoPdfToCsvController;

class NotreDamePdfToCsv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notredame:demostrativo-pdf-to-csv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Realizar a leitura de um pdf "DEMONSTRATIVO DE ANÁLISE DE CONTA" da operadora Notre Dame e salvar em csv';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        (new DemostrativoPdfToCsvController())->main();
    }
}
