<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessarCobrancaJob;
use App\Services\ImportacaoService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

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

    public function saveFile(Request $request){


        $responseArr = [];
        $statusResponse = 500;
        
        try{

            $file = $request->file('arquivo');

            if ($file != null && $file->isValid()) {
                
                $fileName = uniqid().".csv";
                $path = $file->path();

                $linhas = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                $totalLinhasArquivo = count($linhas);

                $storage = app('filesystem');
                $path = Storage::disk('local')->put($fileName, $file->getContent());

                $dadosPlanilhaSalva = [
                    'arquivo' => $fileName,
                    'nomeOriginal' => $file->getClientOriginalName(),
                    'totalLinhas' => $totalLinhasArquivo,
                    'totalImportado' => 0
                ];
                $idImportacaoSalva = $this->importacaoService->saveFile($dadosPlanilhaSalva);
                if($idImportacaoSalva > 0){
                    $responseArr = [
                        'Status' => true,
                        'Msg' => 'Arquivo salvo arquivo processamento',
                        'IdImportacao' => $idImportacaoSalva
                    ];
                    $statusResponse = Response::HTTP_OK;

                    dispatch(new ProcessarCobrancaJob($idImportacaoSalva));
                }else{
                    $responseArr = [
                        'Status' => false,
                        'Msg' => 'Erro ao salvar importação'
                    ];
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

    public function listFile(Request $request){

        try{

            $params = $request->all();
            $resList = $this->importacaoService->listFile($params);

            return response()->json([
                'Data' => $resList
            ], Response::HTTP_OK);

        }catch(\Exception $e){
            $responseArr = [
                'File' => $e->getFile(),
                'Msg' => $e->getMessage(),
                'Code' => $e->getCode(),
                'Line' => $e->getLine()
            ];
            return response()->json($responseArr, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
