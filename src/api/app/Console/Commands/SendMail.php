<?php

namespace App\Console\Commands;

use App\Jobs\EmailJob;
use Illuminate\Console\Command;

/**
 * SendMail
 *
 * @author Thyago H. Pacher <thyago.pacher@gmail.com>
 */
class SendMail extends Command
{

    protected $signature = 'api:sendmail';

    protected $description = 'Envio de e-mail';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(){
        dispatch(new EmailJob());
    }
}