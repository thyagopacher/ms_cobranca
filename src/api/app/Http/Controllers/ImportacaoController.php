<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessarCobrancaJob;
use App\Services\ImportacaoService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ImportacaoController extends Controller
{

    private $importacaoService;

    public function __construct(
        ImportacaoService $importacaoService
    )
    {
        $this->importacaoService = $importacaoService;
    }

    public function saveFile(Request $request){


        $responseArr = [];
        $statusResponse = 500;
        
        try{

            $file = $request->file('arquivo');

            if ($file != null && $file->isValid()) {
                
                $fileName = uniqid().".csv";
                //só pra evitar sobrecarregar com testes locais
                if(getenv('APP_ENV') == 'local'){
                    $fileName = 'arquivo_cobranca.csv';
                }
                $path = $file->path();

                $linhas = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                $totalLinhasArquivo = count($linhas);

                $path = Storage::disk('local')->put($fileName, $file->getContent());

                $dadosPlanilhaSalva = [
                    'arquivo' => $fileName,
                    'nomeOriginal' => $file->getClientOriginalName(),
                    'totalLinhas' => $totalLinhasArquivo,
                    'totalImportado' => 0
                ];
                $idImportacaoSalva = $this->importacaoService->save($dadosPlanilhaSalva);
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

    public function findById(int $id){
        try{

            $resList = $this->importacaoService->findById($id);

            $httpCode = Response::HTTP_OK;
            if(empty($resList)){
                $httpCode = Response::HTTP_NOT_FOUND;
            }
            return response()->json([
                'Data' => $resList
            ], $httpCode);

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
    
    public function listFile(Request $request){
        try{

            $params = $request->all();
            $resList = $this->importacaoService->findAll($params);

            $httpCode = Response::HTTP_OK;
            if(empty($resList)){
                $httpCode = Response::HTTP_NOT_FOUND;
            }
            return response()->json([
                'Data' => $resList
            ], $httpCode);

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

    public function deleteFile(int $id){
        try{

            $resList = $this->importacaoService->delete($id);

            return response()->json([
                'Status' => $resList,
                'Msg' => 'Arquivo excluido',
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
