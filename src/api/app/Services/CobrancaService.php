<?php

namespace App\Services;

use App\Models\Cobranca;
use App\Exceptions\ParameterException;

/**
 * CobrancaService
 *
 * @author Thyago H. Pacher <thyago.pacher@gmail.com>
 */
class CobrancaService{

    private $importacao;

    public function __construct(
        Cobranca $importacao
    )
    {
        $this->importacao = $importacao;
    }

    
    public function processCobranca(array $dados):bool{

        
        return true;
    }
}