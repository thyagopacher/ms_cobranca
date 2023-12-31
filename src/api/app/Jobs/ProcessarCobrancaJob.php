<?php

namespace App\Jobs;

use App\Services\CobrancaService;
use Illuminate\Support\Facades\Log;

class ProcessarCobrancaJob extends Job
{

    public $tries = 200;

    public $timeout = 21600;

    private $idImportacaoSalva;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $idImportacaoSalva)
    {
        LOG::info('ProcessarCobrancaJob::__construct');
        $this->idImportacaoSalva  = $idImportacaoSalva;
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

            $resJob = $cobrancaService->processCobranca($this->idImportacaoSalva);
            
            $sitJob = $resJob ? "Rodou com sucesso" : "Problema ao rodar JOB";
            LOG::info($sitJob);

        }catch(\Exception $e){
            $res = [
                'File' => $e->getFile(),
                'Msg' => $e->getMessage(),
                'Line' => $e->getLine(),
                'Code' => $e->getCode()
            ];
            LOG::error('Error: '.json_encode($res));
        }
    }
}
