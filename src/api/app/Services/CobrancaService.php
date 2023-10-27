<?php

namespace App\Services;

use App\Contracts\CadastroContract;
use App\Exceptions\ParameterException;
use App\Models\Cobranca;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

/**
 * CobrancaService
 *
 * @author Thyago H. Pacher <thyago.pacher@gmail.com>
 */
class CobrancaService implements CadastroContract{

    public ImportacaoService $importacaoService;

    public function __construct(
        ImportacaoService $importacaoService
    )
    {
        $this->importacaoService = $importacaoService;
    }

    /**
     * processCobranca
     *
     * vai buscar o arquivo da planilha para salvar os dados da mesma na tabela - cobrancas
     * 
     * @param integer $idImportacaoSalva
     * @return boolean
     * @author Thyago H. Pacher <thyago.pacher@gmail.com>
     */
    public function processCobranca(int $idImportacaoSalva):bool{

        LOG::info('CobrancaService::processCobranca');

        $chunk = 1024;
        $resImportacao = $this->importacaoService->findById($idImportacaoSalva);

        if(!empty($resImportacao)){
            foreach ($resImportacao as $key => $importacaoPlanilha) {
                
                $local = $importacaoPlanilha['arquivo'];
                $contents = Storage::disk('local')->get($local);
                $lines = explode("\n", $contents);
                $indiceLinhas = 0;
                
                LOG::info(" == Total linhas do arquivo: ". count($lines));

                unset($lines[0]);//retirando linha de cabeçalho não é necessário processar isso.

                foreach(array_chunk($lines, $chunk) as $linesPartial){

                    $cobrancas = [];

                    foreach ($linesPartial as $key => $line) {
                        $separaLine = explode(",", $line);
                        if(!empty($separaLine[0])){
                            //name,governmentId,email,debtAmount,debtDueDate,debtId
                            $cobrancas[] = [
                                'name' => $separaLine[0],
                                'governmentId' => $separaLine[1],
                                'email' => $separaLine[2],
                                'debtAmount' => (float) $separaLine[3],
                                'debtDueDate' => $separaLine[4],
                                'debtId' => $separaLine[5],
                            ];
                        }
                    }

                    Cobranca::upsert($cobrancas, ['name', 'email']);

                    $totalProcessado = ($indiceLinhas + 1) * $chunk;
                    LOG::info('Inserindo agrupamento:: '. $indiceLinhas . ' - total: '. $totalProcessado);

                    $indiceLinhas++;

                }
            }
        }

        return true;
    }


    /**
     * save
     *
     * save or update in table 
     * 
     * campos = 'name','governmentId','email', 'debtAmount', 'debtDueDate', 'debtId', 'created_at', 'updated_at'
     * 
     * @param array $dados
     * @return integer
     * @author Thyago H. Pacher <thyago.pacher@gmail.com>
     */
    public function save(array $dados):int{
        if(empty($dados['name'])){
            throw new ParameterException('Name is required');
        }

        if(empty($dados['email'])){
            throw new ParameterException('Email is required');
        }

        if(!empty($dados['id'])){
            $cobranca = Cobranca::find($dados['id']);
        }else{
            $cobranca = new Cobranca();
        }
 
        $cobranca->name = $dados['name'];
        $cobranca->governmentId = $dados['governmentId'];
        $cobranca->email = $dados['email'];
        $cobranca->debtAmount = $dados['debtAmount'];
        $cobranca->debtDueDate = $dados['debtDueDate'];
        $cobranca->debtId = $dados['debtId'];

        $cobranca->save();

        return $cobranca->id;
    }


    /**
     * delete
     *
     * @param int $id
     * @return bool
     * @author Thyago H. Pacher <thyago.pacher@gmail.com>
     */
    public function delete(int $id):bool{
        $res = Cobranca::where('id', $id)->delete();
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
        $res = Cobranca::where('id', $id)->get();
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
        $res = Cobranca::listCobranca($params);
        if(!$res->isEmpty()){
            $ret = $res->toArray();
        }

        return $ret;
    }
}