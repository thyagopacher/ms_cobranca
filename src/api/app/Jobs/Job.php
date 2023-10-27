<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

abstract class Job implements ShouldQueue
{
    /*
    |--------------------------------------------------------------------------
    | Queueable Jobs
    |--------------------------------------------------------------------------
    |
    | This job base class provides a central location to place any logic that
    | is shared across all of your jobs. The trait included with the class
    | provides access to the "queueOn" and "delay" queue helper methods.
    |
    */

    use InteractsWithQueue, Queueable, SerializesModels;
    
    public function failed(\Throwable $th){
        $arrLog = [
            'File' => $th->getFile(),
            'Line' => $th->getLine(),
            'Code' => $th->getCode(),
            'Message' => $th->getMessage(),
        ];
        LOG::info('Job::failed - Error:'. json_encode($arrLog));
    }
}
