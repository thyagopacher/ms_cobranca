<?php

namespace App\Services;

use App\Models\Cobranca;
use App\Models\Importacao;
use App\Exceptions\ParameterException;
use Illuminate\Support\Facades\Storage;

/**
 * CobrancaService
 *
 * @author Thyago H. Pacher <thyago.pacher@gmail.com>
 */
class CobrancaService{

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
     * @param integer|null $idImportacaoSalva
     * @return boolean
     * @author Thyago H. Pacher <thyago.pacher@gmail.com>
     */
    public function processCobranca(int $idImportacaoSalva = null):bool{

        $arrFilter = [];
        $arrFilter['notFinished'] = 'S';
        if($idImportacaoSalva != null){
            $arrFilter['id'] = $idImportacaoSalva;
            unset($arrFilter['notFinished']);
        }
        $resImportacao = $this->importacaoService->listFile($arrFilter);
        if(!empty($resImportacao)){
            foreach ($resImportacao as $key => $importacaoPlanilha) {
                $local = $importacaoPlanilha['arquivo'];
                $contents = Storage::disk('local')->get($local);
                print_r($contents);
            }
        }

        return true;
    }
}