<?php

namespace App\Services;

use App\Contracts\CadastroContract;
use App\Mail\MailCobranca;
use App\Models\EmailCobranca;
use App\Exceptions\ParameterException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * EmailService
 *
 * @author Thyago H. Pacher <thyago.pacher@gmail.com>
 */
class EmailService implements CadastroContract{

    private $cobrancaService;

    public function __construct(CobrancaService $cobrancaService)
    {
        $this->cobrancaService = $cobrancaService;
    }

    public function sendEmailCobranca(){
        $listEmail = $this->cobrancaService->findAll([
            'diaParaEnvioCobranca' => 'S',
            'enviadoCobranca' => 'N',
            'limite' => 1
        ]);
        if(!empty($listEmail)){
            foreach ($listEmail as $key => $email) {

                $vencimentoTitulo = date("d/m/Y", strtotime($email['debtDueDate']));
                $to = $email['email'];
                $subject = 'Cobrança vencendo em alguns dias';
                $message = "Olá {$email['name']} seu titulo esta vencido desde o dia {$vencimentoTitulo} no valor de R$ ".$email['debtAmount'];

                $this->sendEmail($to, $subject, $message);

                $resSave = $this->save(array(
                    'idCobranca' => $email['id'],
                    'assunto' => $subject, 
                    'corpo' => $message, 
                    'dataEnvio' => date("Y-m-d H:i:s")
                ));
                if($resSave == false){
                    throw new \Exception('Erro ao salvar envio de e-mail');
                }
            }
        }
        return true;
    }

    public function sendEmail($to, $subject, $message){
        LOG::info('EmailService::sendEmail');
        Mail::send(new MailCobranca($to, $subject, $message));
        return true;
    }

    /**
     * save
     *
     * save or update in table 
     * 
     * campos = 'idCobranca', 'assunto', 'corpo', 'dataEnvio','created_at', 'updated_at'
     * 
     * @param array $dados
     * @return integer
     * @author Thyago H. Pacher <thyago.pacher@gmail.com>
     */
    public function save(array $dados):int{

        if(empty($dados['assunto'])){
            throw new ParameterException('assunto is required');
        }        
        if(empty($dados['corpo'])){
            throw new ParameterException('corpo is required');
        }

        if(!empty($dados['id'])){
            $mail = EmailCobranca::find($dados['id']);
        }else{
            $mail = new EmailCobranca();
        }
 
        $mail->idCobranca = $dados['idCobranca'];
        $mail->assunto = $dados['assunto'];
        $mail->corpo = $dados['corpo'];
        $mail->dataEnvio = $dados['dataEnvio'];

        $mail->save();

        return $mail->id;
    }

    /**
     * delete
     *
     * @param int $id
     * @return bool
     * @author Thyago H. Pacher <thyago.pacher@gmail.com>
     */
    public function delete(int $id):bool{
        $res = EmailCobranca::where('id', $id)->delete();
        return $res;
    }

    /**
     * findById
     *
     * @param int $id
     * @return array
     * @author Thyago H. Pacher <thyago.pacher@gmail.com>
     */
    public function findById(int $id):array{
        $ret = [];
        $res = EmailCobranca::where('id', $id)->get();
        if(!$res->isEmpty()){
            $ret = $res->toArray();
        }
        return $ret;
    }

    /**
     * findAll
     *
     * @param array $params
     * @return array
     * @author Thyago H. Pacher <thyago.pacher@gmail.com>
     */
    public function findAll(array $params):array{
        $ret = [];
        $res = EmailCobranca::listEmails($params);
        if(!$res->isEmpty()){
            $ret = $res->toArray();
        }

        return $ret;
    }
}