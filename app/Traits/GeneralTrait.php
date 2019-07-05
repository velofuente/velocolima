<?php

namespace App\Traits;
use Exception, Log, DB, Carbon;
use Illuminate\Support\Collection as Collection;

Trait GeneralTrait
{
    /**
     * Función genérica para retorno de mensaje exitoso
     *
     * @param $data
     * @return \Illuminate\Http\Response
     */
    public function responseSuccess($data) {
        return response()->json([
            'status' => 'OK',
            'data' => $data
        ]);
    }

    /**
     * Función genérica para retorno de mensaje erróneo
     *
     * @param $data
     * @return \Illuminate\Http\Response
     */
    public function responseErrorMessage($code, $message) {
        return response()->json([
            'data' => [
                'error' => [
                    "message" => $message,
                    "code" => $code,
                    "status" => 'error'
                ],
                'status' => 'error'
            ],
            'status' => 'error'
        ]);
    }

    /**
     * Función genérica para retorno de mensaje erróneo
     *
     * @param $code, $message
     * @return \Illuminate\Http\Response
     */
    public function responseError($code, $message) {
        return response()->json([
            'status' => 'error',
            'error' => [
                'code' => $code,
                'message' => $message
            ]
        ]);
    }
}