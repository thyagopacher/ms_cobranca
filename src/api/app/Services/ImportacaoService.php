<?php

namespace App\Services;

use App\Models\Importacao;
use App\Exceptions\ParameterException;

/**
 * ImportacaoService
 *
 * @author Thyago H. Pacher <thyago.pacher@gmail.com>
 */
class ImportacaoService{

    private $importacao;

    public function __construct(
        Importacao $importacao
    )
    {
        $this->importacao = $importacao;
    }

    /**
     * saveFile
     *
     * save or update in table importacaos
     * 
     * @param array $dados
     * @return integer
     * @author Thyago H. Pacher <thyago.pacher@gmail.com>
     */
    public function saveFile(array $dados):int{

        if(empty($dados['arquivo'])){
            throw new ParameterException('Parametro inválido');
        }
        if(!empty($dados['id'])){
            $importacao = Importacao::find($dados['id']);
        }else{
            $importacao = new Importacao();
        }
 
        $importacao->nomeOriginal = $dados['nomeOriginal'];
        $importacao->arquivo = $dados['arquivo'];
        $importacao->totalLinhas = $dados['totalLinhas'];
        $importacao->totalImportado = isset($dados['totalImportado']) ? $dados['totalImportado'] : 0;

        $importacao->save();

        return $importacao->id;
    }

    /**
     * listFile
     *
     * @param array $params
     * @return array
     * @author Thyago H. Pacher <thyago.pacher@gmail.com>
     */
    public function listFile(array $params):array{
        $ret = [];
        $res = Importacao::listFile($params);
        if(!$res->isEmpty()){
            $ret = $res->toArray();
        }

        return $ret;
    }
}