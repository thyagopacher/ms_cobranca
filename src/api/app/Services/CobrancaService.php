<?php

namespace App\Services;

use App\Contracts\CadastroContract;
use App\Models\Cobranca;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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
                
                unset($lines[0]);//retirando linha de cabeçalho não é necessário processar isso.

                foreach(array_chunk($lines, $chunk) as $linesPartial){

                    $cobrancas = [];

                    foreach ($linesPartial as $key => $line) {
                        $separaLine = explode(",", $line);
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

                    Cobranca::upsert($cobrancas, ['name', 'email']);
                    LOG::info('Inserindo agrupamento:: '. $indiceLinhas);

                    $indiceLinhas++;

                }


                

            }
        }

        return true;
    }
}