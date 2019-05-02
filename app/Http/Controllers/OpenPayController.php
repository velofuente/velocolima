<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPUnit\Framework\Exception;
use Openpay, Log, Config, Auth, DB;
use function GuzzleHttp\json_encode;

class OpenPayController extends Controller
{
    public static function openPay()
    {
        return Config::get('constants.openpay');
    }
    public function addCustomerCard(Request $request)
    {
        //TODO: Implementar validador
        // log::info($request->all());
        //Obtener usuario de la petición
        $requestUser = $request->user();
        //Validar si el usuario ya existe en OpenPay
        if ($requestUser->customer_id == null){
            $openPayCustomer = $this->addCustomer($requestUser);
            $requestUser->customer_id = $openPayCustomer->id;
            $requestUser->save();
        } else {
            $openpay = self::openPay();
            $openPayCustomer = $openpay->customers->get($requestUser->customer_id);
        }
        //Obtener el usuaro de OpenPay
        $cardData = $this->getCardToken($request->token_id);
        if (!isset($cardData->card)) {
            return "No se encontró la tarjeta ingrasada, pruebe de nuevo ".json_encode($cardData);
        }
        else{
            //TODO: Validar si existe la tarjeta en mi base de datos con los datos obtenidos de getCardToken
            $existsCard = DB::table('cards')->where(
                'card_number', '=', "{$cardData->card->card_number}"
                )->get();
            if (!isset($existsCard)) {
                return "La tarjeta que deseas ingresar ya existe favor de revisar los datos de la tarjeta o ingresar una nueva.";
            }
            else{
                app('App\Http\Controllers\CardController')->store($cardData);
                /*DB::table('card_user')->insert([
                    'card_id' => DB::table('cards')->select('id')->where('card_number', '=', "{$cardData->card->card_number}")->get(),
                    'user_id' => $requestUser->id
                ]);*/
                $cardDataRequest = [
                    'token_id' => $cardData->id,
                    'device_session_id' => $request->device_session_id
                ];

                try{
                    $card = $openPayCustomer->cards->add($cardDataRequest);
                    return json_encode($card);
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
        }
    }

    /**
     * Crea un usuario en OpenPay
     *
     * @param Request $request
     * @return Object/String
     */
    public function addCustomer($request)
    {
        //Instanciamos OpenPay
        $openpay = self::openPay();
        //Creamos el array con la información del usuario
        $customerData = [
	        'name' => $request->name,
	        'last_name' => $request->last_name,
	        'email' => $request->email,
	        'phone_number' => $request->phone_number,
        ];
        //Intentamos crear el usuario en OpenPay
        try {
            return $openpay->customers->add($customerData);

        } catch(Exception $e) {
            //Retornamos error
            //TODO: Investigar si se puede cachar el tipo de error
            return "No se pudo agregar el cliente: ".$e->getMessage();
        }
    }
    public function getCustomer(Request $request)
    {
        $openpay = self::openPay();
        try{
            $customer = $openpay->customers->get($request->customer_id);
            return response()->json($customer->serializableData);
        }catch(Exception $e){
            return "Cliente no existente: ".$e->getMessage();
        }
    }

    /**
     * Obtener los datos de una tarjeta basado en un token
     *
     * @param String $tokenId
     * @return void
     */
    public function getCardToken($tokenId)
    {
        $key = env("OPENPAY_PUBLIC_KEY", '');
        $merchantId = env("OPENPAY_ID", '');
        $apiUrl = "https://{$key}@sandbox-api.openpay.mx/v1/{$merchantId}/tokens/{$tokenId}";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $apiUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $card = json_decode(curl_exec($curl));
        curl_close($curl);
        return $card;
    }
    public function makeChargeCustomer(Request $request)
    {
        $openpay = self::openPay();

        //obtener la tarjeta seleccionada

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
    public function makeRefund(Request $request)
    {
        $openpay = self::openPay();

        $refundData = array('description' => $request->description );

        $customer = $openpay->customers->get($request->customer_id);
        $charge = $customer->charges->get($request->charge_id);
        $charge->refund($refundData);
    }
    public function deleteCustomer(Request $request)
    {
        $openpay = self::openPay();
        $customer = $openpay->customers->get($request->customer_id);
        $customer->delete();
        return "Borrado exitosamente";
    }
    public function getApiKeyAndSessionId()
    {
        return [
            env('OPENPAY_ID','default'),
            env('OPENPAY_PUBLIC_KEY','default'),
        ];
    }
}
