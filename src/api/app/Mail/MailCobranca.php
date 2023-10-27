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

    public function __construct(string $toMail, string $subjectMail, string $bodyMail){
        $this->toMail = $toMail;
        $this->subjectMail = $subjectMail;
        $this->bodyMail = $bodyMail;

        $this->fromMail = 'teste@mail.com';
        $this->froName = '';
    }

    public function build(){
        $dadosMsg['mensagem'] = $this->bodyMail;
        return $this->to($this->toMail)
            ->from($this->fromMail, $this->froName)
            ->subject($this->subjectMail)
            ->view('mails.cobranca', $dadosMsg);
    }

}