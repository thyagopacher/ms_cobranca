<?php

namespace App\Jobs;

use App\Services\CobrancaService;
use Illuminate\Support\Facades\Log;

class ProcessarCobrancaJob extends Job
{


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        LOG::info('ProcessarCobrancaJob::__construct');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(CobrancaService $cobrancaService)
    {
        
        LOG::info('ProcessarCobrancaJob::handle');

        try{
            $cobrancaService->processCobranca();
        }catch(\Exception $e){
            $res = [
                'File' => $e->getMessage(),
                'Line' => $e->getLine(),
                'Code' => $e->getCode()
            ];
            LOG::info('Error: '.json_encode($res));
        }
    }
}
