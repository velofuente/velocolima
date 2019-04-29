<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPUnit\Framework\Exception;
use Openpay, Log, Config, Auth;

class OpenPayController extends Controller
{
    public static function openPay()
    {
        return Config::get('constants.openpay');
    }
    public function addCustomerCard(Request $request)
    {
        log::info($request->all());
        $openpay = self::openPay();

        $cardDataRequest = [
            'token_id' => $request->token_id,
            'device_session_id' => $request->device_session_id
        ];

        $customer = $openpay->customers->get($request->customer_id);

        try{
            $card = $customer->cards->add($cardDataRequest);
            return $card;
        }catch(OpenpayApiTransactionError $e){
            switch ($e->getErrorCode()) {
                case 3001:
                    return "Tarjeta declinada. Contacta a tu banco e inténtalo de nuevo.";
                    break;
                case 3002:
                    return "La tarjeta ha expirado.";
                    break;
                case 3003:
                    return "La tarjeta no tiene fondos suficientes.";
                    break;
                case 3006:
                    return "La operación no esta permitida para este cliente o esta transacción. Contacta a tu banco.";
                    break;
                case 3007:
                    return "Tarjeta declinada. Contacta a tu banco e inténtalo de nuevo.";
                    break;
                case 3008:
                    return "La tarjeta no es soportada en transacciones en línea. Contacta a tu banco.";
                    break;
                case 3010:
                    return "El banco ha restringido la tarjeta. Contacta a tu banco.";
                    break;
                case 3012:
                    return "Se requiere solicitar al banco autorización para realizar este pago. Contacta a tu banco.";
                    break;
                default:
                    return "Tarjeta no válida. Contacta a tu banco.";
            }
        }catch(OpenpayApiRequestError $e){
            return "Tarjeta no válida. Contacta a tu banco.";
        }catch(Exception $e){
            return "No se pudo agregar la tarjeta, inténtalo nuevamente.";
        }
    }
    public function addCustomer(Request $request)
    {
        $openpay = self::openPay();
        $customerData = [
	        'name' => $request->name,
	        'last_name' => $request->last_name,
	        'email' => $request->email,
	        'phone_number' => $request->phone_number,
            ];

        try{
            $customer = $openpay->customers->add($customerData);
            app('App\Http\Controllers\UserController')->updateCustomerId($customer->id);
            return json_encode($customer->id);
        }catch(Exception $e){
            return "No se pudo agregar el cliente: ".$e->getMessage();
        }
    }
    public function getCustomer(Request $request)
    {
        $openpay = self::openPay();
        //Log::info($request->all());
        try{
            $customer = $openpay->customers->get($request->customer_id);
            return response()->json($customer->serializableData);
        }catch(Exception $e){
            return "Cliente no existente: ".$e->getMessage();
        }
    }
    public function makeChargeCustomer(Request $request)
    {
        $openpay = self::openPay();

        /*
            obtener la tarjeta seleccionada
        */

        $customer = $openpay->customers->get($request->customer_id);

        $chargeData = [
            'method' => 'card',
            'source_id' => $request->token_id,
            'amount' => $request->amount,
            'description' => $request->description,
            'order_id' => 'ORDEN-00071',
            'device_session_id' => $request->device_session,
            'customer' => $customer,
        ];

        try{
            $charge = $customer->charges->create($chargeData);
            return $charge;
        }catch(OpenpayApiTransactionError $e){
            switch ($e->getErrorCode()) {
                case 3001:
                    return "Tarjeta declinada. Contacta a tu banco e inténtalo de nuevo.";
                    break;
                case 3002:
                    return "La tarjeta ha expirado.";
                    break;
                case 3003:
                    return "La tarjeta no tiene fondos suficientes.";
                    break;
                case 3006:
                    return "La operación no esta permitida para este cliente o esta transacción. Contacta a tu banco.";
                    break;
                case 3007:
                    return "Tarjeta declinada. Contacta a tu banco e inténtalo de nuevo.";
                    break;
                case 3008:
                    return "La tarjeta no es soportada en transacciones en línea. Contacta a tu banco.";
                    break;
                case 3010:
                    return "El banco ha restringido la tarjeta. Contacta a tu banco.";
                    break;
                case 3012:
                    return "Se requiere solicitar al banco autorización para realizar este pago. Contacta a tu banco.";
                    break;
                default:
                    return "Tarjeta no válida. Contacta a tu banco.";
            }
        }catch(OpenpayApiRequestError $e){
            return "Tarjeta no válida. Contacta a tu banco.";
        }catch(Exception $e){
            return "No se pudo agregar la tarjeta, inténtalo nuevamente.";
        }
    }
    public function deleteCustomer(Request $request)
    {
        $openpay = self::openPay();
        $customer = $openpay->customers->get($request->customer_id);
        $customer->delete();
        return "Borrado exitosamente";
    }
    public function makeFeeCharge(Request $request)
    {
        $openpay = self::openPay();

        $feeData = array(
            'customer_id' => $request->custormer_id,
            'amount' => $request->amount,
            'description' => $request->description,
            'order_id' => 'ORDEN-00063');

        try{
            $fee = $openpay->fees->create($feeData);
            return $fee;
        }catch(OpenpayApiTransactionError $e){
            switch ($e->getErrorCode()) {
                case 3001:
                    return "Tarjeta declinada. Contacta a tu banco e inténtalo de nuevo.";
                    break;
                case 3002:
                    return "La tarjeta ha expirado.";
                    break;
                case 3003:
                    return "La tarjeta no tiene fondos suficientes.";
                    break;
                case 3006:
                    return "La operación no esta permitida para este cliente o esta transacción. Contacta a tu banco.";
                    break;
                case 3007:
                    return "Tarjeta declinada. Contacta a tu banco e inténtalo de nuevo.";
                    break;
                case 3008:
                    return "La tarjeta no es soportada en transacciones en línea. Contacta a tu banco.";
                    break;
                case 3010:
                    return "El banco ha restringido la tarjeta. Contacta a tu banco.";
                    break;
                case 3012:
                    return "Se requiere solicitar al banco autorización para realizar este pago. Contacta a tu banco.";
                    break;
                default:
                    return "Tarjeta no válida. Contacta a tu banco.";
            }
        }catch(OpenpayApiRequestError $e){
            return "Tarjeta no válida. Contacta a tu banco.";
        }catch(Exception $e){
            return "No se pudo agregar la tarjeta, inténtalo nuevamente.";
        }
    }
    public function getApiKeyAndSessionId()
    {
        return [
            env('OPENPAY_ID','default'),
            env('OPENPAY_PUBLIC_KEY','default'),
        ];
    }
}
