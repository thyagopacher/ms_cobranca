<?php

namespace App\Jobs;

use App\Services\EmailService;
use Illuminate\Support\Facades\Log;

class EnviarEmailJob extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        LOG::info('EnviarEmailJob::__construct');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(EmailService $emailService)
    {
        LOG::info('EnviarEmailJob::handle');

        try{

            $resJob = $emailService->sendEmailCobranca();
            $sitJob = $resJob ? "Rodou com sucesso" : "Problema ao rodar JOB";
            LOG::info($sitJob);

        }catch(\Exception $e){
            $res = [
                'File' => $e->getMessage(),
                'Line' => $e->getLine(),
                'Code' => $e->getCode()
            ];
            LOG::error('Error: '.json_encode($res));
        }

    }
}
