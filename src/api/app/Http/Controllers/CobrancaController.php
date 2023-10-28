<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessarCobrancaJob;
use App\Services\CobrancaService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class CobrancaController extends Controller
{

    private $cobrancaService;

    public function __construct(
        CobrancaService $cobrancaService
    )
    {
        $this->cobrancaService = $cobrancaService;
    }

    public function saveCobranca(Request $request){


        $responseArr = [];
        $statusResponse = 500;
        
        try{
            $params = $request->all();
            $idSalva = $this->cobrancaService->save($params);
            if($idSalva > 0){
                $responseArr = [
                    'Status' => true,
                    'Msg' => 'Cobrança salva',
                    'IdImportacao' => $idSalva
                ];
                $statusResponse = Response::HTTP_OK;

            }else{
                $responseArr = [
                    'Status' => false,
                    'Msg' => 'Erro ao salvar Cobrança'
                ];
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

    public function findByIdCobranca(int $id){
        try{

            $resList = $this->cobrancaService->findById($id);

            $httpCode = Response::HTTP_OK;
            if(empty($resList)){
                $httpCode = Response::HTTP_NOT_FOUND;
            }

            $arrRet = [
                'Data' => $resList
            ];

            return response()->json($arrRet, $httpCode);

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
    
    public function listCobranca(Request $request){
        try{

            $params = $request->all();
            $resList = $this->cobrancaService->findAll($params);

            $httpCode = Response::HTTP_OK;
            if(empty($resList)){
                $httpCode = Response::HTTP_NOT_FOUND;
            }

            $arrRet = [
                'Data' => $resList
            ];
            if(!empty($params['pagina'])){
                $arrRet['page'] = $params['pagina'];
            }
            return response()->json($arrRet, $httpCode);

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

    public function deleteCobranca(int $id){
        try{

            $res = $this->cobrancaService->delete($id);

            return response()->json([
                'Status' => $res,
                'Msg' => 'Cobrança excluida',
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
