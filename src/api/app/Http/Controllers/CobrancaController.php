<?php

namespace App\Http\Controllers;

use App\Services\ImportacaoService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CobrancaController extends Controller
{

    private string $destino_arquivo;
    private $importacaoService;

    public function __construct(
        ImportacaoService $importacaoService
    )
    {
        $this->destino_arquivo = './storage/app/';
        $this->importacaoService = $importacaoService;
    }

    public function salvarArquivo(Request $request){


        $responseArr = [];
        $statusResponse = 500;
        
        try{

            $file = $request->file('arquivo');

            if ($file != null && $file->isValid()) {
                
                $fileName = uniqid().".csv";
                $path = $file->path();
                var_dump($path);
                $linhas = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                $totalLinhasArquivo = count($linhas);

                $file->move($this->destino_arquivo, $fileName);
                
                $dadosPlanilhaSalva = [
                    'arquivo' => $fileName,
                    'totalLinhas' => $totalLinhasArquivo,
                    'totalImportado' => 0
                ];
                $resImportacaoSalva = $this->importacaoService->salvarArquivo($dadosPlanilhaSalva);
                if($resImportacaoSalva){
                    $responseArr = [
                        'Status' => true,
                        'Msg' => 'Arquivo salvo arquivo processamento'
                    ];
                    $statusResponse = Response::HTTP_OK;
                }
            }else{
                $responseArr = [
                    'Status' => false,
                    'Msg' => 'Arquivo invalido, por favor conferir'
                ];
                if($file != null){
                    $error = $file->getErrorMessage();
                    $responseArr['Msg'] .= ' - Erro: ' . $error;
                }
                $statusResponse = Response::HTTP_BAD_REQUEST;
            }
        }catch(\Exception $ex){
            
            $responseArr = array(
                'Status' => false,
                'Line' => $ex->getLine(),
                'Message' => $ex->getMessage(),
                'File' => $ex->getFile(),
                'Code' => $ex->getCode()
            );
            $statusResponse = Response::HTTP_INTERNAL_SERVER_ERROR;

        }finally{
            return response()->json($responseArr, $statusResponse);
        }
    }
}
