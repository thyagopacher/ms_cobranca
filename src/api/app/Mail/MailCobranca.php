<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * MailCobranca
 *
 * classe template para email de cobrança
 * 
 * @author Thyago H. Pacher <thyago.pacher@gmail.com>
 */
class MailCobranca extends Mailable{

    use Queueable, SerializesModels;

    private string $fromMail;
    private string $froName;

    private string $toMail;
    private string $subjectMail;
    private string $bodyMail;
    private array $dados;

    public function __construct(string $toMail, string $subjectMail, string $bodyMail, array $dados){
        $this->toMail = $toMail;
        $this->subjectMail = $subjectMail;
        $this->bodyMail = $bodyMail;
        $this->dados = $dados;
    }

    public function build(){
        return $this->to($this->toMail)
            ->from($this->fromMail, $this->fromMail)
            ->subject($this->subjectMail)
            ->view('mails.cobranca', $this->dados);
    }

}