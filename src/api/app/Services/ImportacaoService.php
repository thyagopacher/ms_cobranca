<?php

namespace App\Services;

use App\Contracts\CadastroContract;
use App\Models\Importacao;
use App\Exceptions\ParameterException;

/**
 * ImportacaoService
 *
 * @author Thyago H. Pacher <thyago.pacher@gmail.com>
 */
class ImportacaoService implements CadastroContract{

    private $importacao;

    public function __construct(
        Importacao $importacao
    )
    {
        $this->importacao = $importacao;
    }

    /**
     * save
     *
     * save or update in table importacaos
     * 
     * @param array $dados
     * @return integer
     * @author Thyago H. Pacher <thyago.pacher@gmail.com>
     */
    public function save(array $dados):int{

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
     * delete
     *
     * @param int $id
     * @return bool
     * @author Thyago H. Pacher <thyago.pacher@gmail.com>
     */
    public function delete(int $id):bool{
        $res = Importacao::where('id', $id)->delete();
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
        $res = Importacao::where('id', $id)->get();
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
        $res = Importacao::listFile($params);
        if(!$res->isEmpty()){
            $ret = $res->toArray();
        }

        return $ret;
    }
}