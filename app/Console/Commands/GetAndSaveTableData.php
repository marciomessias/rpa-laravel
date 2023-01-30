<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\RPA\GetAndSaveTableDataController;

class GetAndSaveTableData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rpa:table-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Buscar e salvar dados da tabela no banco de dados';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        (new GetAndSaveTableDataController())->init();
    }
}
