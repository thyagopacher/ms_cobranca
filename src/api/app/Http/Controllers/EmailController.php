<?php

namespace App\Http\Controllers;

use App\Jobs\EmailJob;
use App\Services\EmailService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EmailController extends Controller
{

    private $emailService;

    public function __construct(
        EmailService $emailService
    )
    {
        $this->emailService = $emailService;
    }

    public function sendEmailCobranca(){
        try{

            dispatch(new EmailJob());

            $httpCode = Response::HTTP_OK;

            return response()->json([
                'Msg' => 'JOB iniciado para cobrança',
                'Status' => true,
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

    public function saveEmail(Request $request){


        $responseArr = [];
        $statusResponse = 500;
        
        try{
            $params = $request->all();
            $idSalva = $this->emailService->save($params);
            if($idSalva > 0){
                $responseArr = [
                    'Status' => true,
                    'Msg' => 'E-mail cobrança salvo',
                    'IdImportacao' => $idSalva
                ];
                $statusResponse = Response::HTTP_OK;

            }else{
                $responseArr = [
                    'Status' => false,
                    'Msg' => 'Erro ao salvar email'
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

    public function findByIdEmail(int $id){
        try{

            $resList = $this->emailService->findById($id);

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
    
    public function listEmail(Request $request){
        try{

            $params = $request->all();
            $resList = $this->emailService->findAll($params);

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

    public function deleteEmail(int $id){
        try{

            $res = $this->emailService->delete($id);

            return response()->json([
                'Status' => $res,
                'Msg' => 'E-mail excluido',
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
