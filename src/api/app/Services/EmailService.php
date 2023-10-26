<?php

namespace App\Services;

use App\Mail\MailCobranca;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * EmailService
 *
 * @author Thyago H. Pacher <thyago.pacher@gmail.com>
 */
class EmailService{

    public function __construct(CobrancaService $cobrancaService)
    {
        
    }

    public function sendEmailCobranca(){

    }

    public function sendEmail($to, $subject, $message, $dadosCobranca){
        LOG::info('EmailService::sendEmail');
        Mail::send(new MailCobranca($to, $subject, $message, $dadosCobranca));
        return true;
    }
}