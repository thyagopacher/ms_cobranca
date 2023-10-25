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

    
    public function salvarArquivo(array $dados):bool{

        if(empty($dados['arquivo'])){
            throw new ParameterException('Parametro inválido');
        }
        if(!empty($dados['id'])){
            $importacao = Importacao::find($dados['id']);
        }else{
            $importacao = new Importacao();
        }
 
        $importacao->arquivo = $dados['arquivo'];
        $importacao->totalLinhas = $dados['totalLinhas'];
        $importacao->totalImportado = isset($dados['totalImportado']) ? $dados['totalImportado'] : 0;

        $importacao->save();
        return true;
    }
}