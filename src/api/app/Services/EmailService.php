<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

/**
 * EmailService
 *
 * @author Thyago H. Pacher <thyago.pacher@gmail.com>
 */
class EmailService{

    public function __construct()
    {
        
    }

    public function sendEmail($to, $subject, $message){
        LOG::info('EmailService::sendEmail');
        return true;
    }
}