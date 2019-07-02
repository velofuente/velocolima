<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPUnit\Framework\Exception;
use Openpay, Log, Config, Auth, DB, Session;
use App\{Purchase, Card, Product};

class OpenPayController extends Controller
{
    public static function openPay()
    {
        return Config::get('constants.openpay');
    }

    public function addCustomerCard(Request $request)
    {
        DB::beginTransaction();
        //TODO: Implementar validador
        // log::info($request->all());
        //Obtener usuario de la petición
        $requestUser = $request->user();
        // dd($requestUser);
        $cardCount = Card::where('user_id', $requestUser->id)->count();
        if($cardCount > 3){
            return "No puedes agregar mas de 3 tarjetas a tu perfil";
        }
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
                //TODO: Validar si existe la tarjeta en mi base de datos con los datos obtenidos de getCardToken
                $existsCard = DB::table('cards')->where(
                    'card_number', '=', "{$cardData->card->card_number}"
                    )->get();
                if (!isset($existsCard)) {
                    return "La tarjeta que deseas ingresar ya existe favor de revisar los datos de la tarjeta o ingresar una nueva.";
                }
                else{
                    $userCards = Card::where('user_id' , $requestUser->id)->get();
                    If(count($userCards)>0){
                        Card::where('user_id' , $requestUser->id)->where('selected', 1)->update(['selected' => 0]);
                    }
                    // Session::flash('alertButton', "Aceptar");
                    $cardDataRequest = [
                        'token_id' => $cardData->id,
                        'device_session_id' => $request->device_session_id
                    ];
                    try{
                        $card = $openPayCustomer->cards->add($cardDataRequest);
                        app('App\Http\Controllers\CardController')->store($cardData,$requestUser->id);
                        DB::commit();
                        Session::flash('alertTitle', "Tarjeta guardada!");
                        Session::flash('alertMessage', "Tu tarjeta fue guardada exitosamente");
                        Session::flash('alertType', "success");
                        return [
                            "status" => "OK",
                            "message" => "Tu tarjeta fue guardada exitosamente"
                        ];
                    }catch(\OpenpayApiTransactionError $e){
                        Log::info(json_encode($e->getErrorCode()));
                        Log::info(json_encode($e->getDescription()));
                        Log::info(json_encode($e->getFraudRules()));
                        switch ($e->getErrorCode()) {
                            case 2005:
                                $message = "La fecha de expiración de la tarjeta es anterior a la fecha actual.";
                                break;
                            case 2006:
                                $message = "El código de seguridad de la tarjeta (CVV2) no fue proporcionado.";
                                break;
                            case 2009:
                                $message = "El código de seguridad de la tarjeta (CVV2) es inválido.";
                                break;
                            case 3001:
                                $message = "Tarjeta declinada. Contacta a tu banco e inténtalo de nuevo.";
                                break;
                            case 3002:
                                $message = "La tarjeta ha expirado.";
                                break;
                            case 3003:
                                $message = "La tarjeta no tiene fondos suficientes.";
                                break;
                            case 3006:
                                $message = "La operación no esta permitida para este cliente o esta transacción. Contacta a tu banco.";
                                break;
                            case 3007:
                                $message = "Tarjeta declinada. Contacta a tu banco e inténtalo de nuevo.";
                                break;
                            case 3008:
                                $message = "La tarjeta no es soportada en transacciones en línea. Contacta a tu banco.";
                                break;
                            case 3010:
                                $message = "El banco ha restringido la tarjeta. Contacta a tu banco.";
                                break;
                            case 3012:
                                $message = "Se requiere solicitar al banco autorización para realizar este pago. Contacta a tu banco.";
                                break;
                            default:
                                $message = "Tarjeta no válida. Contacta a tu banco.";
                        }
                    }catch(\OpenpayApiRequestError $e){
                        $message = "Tarjeta no válida. Contacta a tu banco.";
                    }catch(\Exception $e){
                        $message = "No se pudo agregar la tarjeta, inténtalo nuevamente.";
                    } return [
                        "status" => "error",
                        "message" => $message
                    ];
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
            'requires_account' => false,
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
        // $apiUrl = "https://{$key}@sandbox-api.openpay.mx/v1/{$merchantId}/tokens/{$tokenId}";
        $apiUrl = "https://{$key}@api.openpay.mx/v1/{$merchantId}/tokens/{$tokenId}";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $apiUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $card = json_decode(curl_exec($curl));
        curl_close($curl);
        return $card;
    }
    public function makeChargeCustomer(Request $request)
    {
        log::info("entro");
        $openpay = self::openPay();
        $requestUser = $request->user();

        // $card = DB::table('cards')->select('id','token_id')->where('user_id', "{$requestUser->id}")->where('selected', 1)->first();
        //Validar si no tiene tarjetas

        //TODO: Validar producto
        $product = DB::table('products')->where('id', '=', "{$request->product_id}")->first();
        //TODO: validar si el usuario tiene un customer, si no tiene lo debe de crear
        //Validar si usuario tiene cuenta con OpenPay
        if ($requestUser->customer_id == null){
            $customer = $this->addCustomer($requestUser);
            $requestUser->customer_id = $customer->id;
            $requestUser->save();
        } else {
            $openpay = self::openPay();
            $customer = $openpay->customers->get($requestUser->customer_id);
        }
        try{
            log::info("entro al try");
            DB::beginTransaction();
            //Inicializamos array para compra (MI DB)
            $purchaseArray = [
                'product_id' => $product->id,
                // 'card_id' => $card->id,
                'user_id' => $requestUser->id,
                'n_classes' => $product->n_classes,
                'expiration_days' => $product->expiration_days,
            ];
            log::info("purchasearray creado");
            //Obtenemos el token de la tarjeta
            $cardToken = $request->token_id;
            log::info("obtuvo token id");
            // $purchaseArray["card_id"] = $card->id;
            // $cardToken = $card->token_id;
            //Registramos la compra en el sistema
            $compra = Purchase::create($purchaseArray);
            log::info("crea la compra");
            //Inicializamos array de cargo (OpenPay)
            $chargeData = [
                'method' => 'card',
                'source_id' => $cardToken,
                'amount' => $product->price,
                'description' => $product->description,
                'order_id' => 'ORDEN-'.$compra->id."-".time(),
                'device_session_id' => $request->device_session_id
            ];
            log::info("crea el charge data");
            $charge = $customer->charges->create($chargeData);
            DB::commit();
            Session::flash('alertTitle', "Compra realizada!");
            Session::flash('alertMessage', "Tu compra fue procesada exitosamente");
            Session::flash('alertType', "success");
            // Session::flash('alertButton', "Aceptar");
            return [
                "status" => "OK",
                "message" => "Compra realizada correctamente",
                // "data" => [
                //     "charge" => $charge
                // ]
            ];
        }catch(\OpenpayApiTransactionError $e){
            Log::info('OpenPayController@makeChargeCustomer');
            Log::info(json_encode($e->getErrorCode()));
            Log::info(json_encode($e->getDescription()));
            Log::info(json_encode($e->getFraudRules()));
            switch ($e->getErrorCode()) {
                case "2005":
                    $message = "La fecha de expiración de la tarjeta es anterior a la fecha actual.";
                    break;
                case "2006":
                    $message = "El código de seguridad de la tarjeta (CVV2) no fue proporcionado.";
                    break;
                case "2009":
                    $message = "El código de seguridad de la tarjeta (CVV2) es inválido.";
                    break;
                case "3001":
                    $message = "Tarjeta declinada. Contacta a tu banco e inténtalo de nuevo.";
                    break;
                case "3002":
                    $message = "La tarjeta ha expirado.";
                    break;
                case "3003":
                    $message = "La tarjeta no tiene fondos suficientes.";
                    break;
                case "3006":
                    $message = "La operación no esta permitida para este cliente o esta transacción. Contacta a tu banco.";
                    break;
                case "3007":
                    $message = "Tarjeta declinada. Contacta a tu banco e inténtalo de nuevo.";
                    break;
                case "3008":
                    $message = "La tarjeta no es soportada en transacciones en línea. Contacta a tu banco.";
                    break;
                case "3010":
                    $message = "El banco ha restringido la tarjeta. Contacta a tu banco.";
                    break;
                case "3012":
                    $message = "Se requiere solicitar al banco autorización para realizar este pago. Contacta a tu banco.";
                    break;
                default:
                    $message = "Tarjeta no válida. Contacta a tu banco.";
            }
        } catch (\OpenpayApiRequestError $e){
            $message = "Tarjeta no válida. Contacta a tu banco.";
        } catch (Exception $e){
            $message = "No se pudo agregar la tarjeta, inténtalo nuevamente.";
        }
        log::info($message);
        DB::rollback();
        return [
            "status" => "error",
            "message" => $message
        ];
    }
    public function makeChargeCard(Request $request)
    {
        $requestUser = $request->user();

        //$card = Card::select('id','token_id')->where('user_id', "{$requestUser->id}")->where('selected', 1)->first();
        $card = Card::select('id', 'token_id')->where('id',$request->card_id)->where('user_id', $requestUser->id)->first();
        log::info($card);
        //TODO: Validar producto
        $product = Product::where('id', '=', "{$request->product_id}")->first();
        log::info($product);
        //TODO: validar si el usuario tiene un customer, si no tiene lo debe de crear
        //Validar si usuario tiene cuenta con OpenPay
        if ($requestUser->customer_id == null){
            $customer = $this->addCustomer($requestUser);
            $requestUser->customer_id = $customer->id;
            $requestUser->save();
        } else {
            $openpay = self::openPay();
            $customer = $openpay->customers->get($requestUser->customer_id);
        }
        try{
            DB::beginTransaction();
            //Inicializamos array para compra (MI DB)
            $purchaseArray = [
                'product_id' => $product->id,
                'card_id' => $card->id,
                'user_id' => $requestUser->id,
                'n_classes' => $product->n_classes,
                'expiration_days' => $product->expiration_days,
            ];
            //Obtenemos el token de la tarjeta
            $cardToken = $card->token_id;
            //Registramos la compra en el sistema
            $compra = Purchase::create($purchaseArray);
            //Inicializamos array de cargo (OpenPay)
            $chargeData = [
                'method' => 'card',
                'source_id' => $cardToken,
                'amount' => $product->price,
                'description' => $product->description,
                'order_id' => 'ORDEN-'.$compra->id."-".time(),
                'device_session_id' => $request->device_session_id
            ];
            log::info("crea el charge data");
            $charge = $customer->charges->create($chargeData);
            DB::commit();
            Session::flash('alertTitle', "Compra realizada!");
            Session::flash('alertMessage', "Tu compra fue procesada exitosamente");
            Session::flash('alertType', "success");
            // Session::flash('alertButton', "Aceptar");
            return [
                "status" => "OK",
                "message" => "Compra realizada correctamente",
                // "data" => [
                //     "charge" => $charge
                // ]
            ];
        }catch(\OpenpayApiTransactionError $e){
            Log::info('OpenPayController@makeChargeCustomer');
            Log::info(json_encode($e->getErrorCode()));
            Log::info(json_encode($e->getDescription()));
            Log::info(json_encode($e->getFraudRules()));
            switch ($e->getErrorCode()) {
                case "2005":
                    $message = "La fecha de expiración de la tarjeta es anterior a la fecha actual.";
                    break;
                case "2006":
                    $message = "El código de seguridad de la tarjeta (CVV2) no fue proporcionado.";
                    break;
                case "2009":
                    $message = "El código de seguridad de la tarjeta (CVV2) es inválido.";
                    break;
                case "3001":
                    $message = "Tarjeta declinada. Contacta a tu banco e inténtalo de nuevo.";
                    break;
                case "3002":
                    $message = "La tarjeta ha expirado.";
                    break;
                case "3003":
                    $message = "La tarjeta no tiene fondos suficientes.";
                    break;
                case "3006":
                    $message = "La operación no esta permitida para este cliente o esta transacción. Contacta a tu banco.";
                    break;
                case "3007":
                    $message = "Tarjeta declinada. Contacta a tu banco e inténtalo de nuevo.";
                    break;
                case "3008":
                    $message = "La tarjeta no es soportada en transacciones en línea. Contacta a tu banco.";
                    break;
                case "3010":
                    $message = "El banco ha restringido la tarjeta. Contacta a tu banco.";
                    break;
                case "3012":
                    $message = "Se requiere solicitar al banco autorización para realizar este pago. Contacta a tu banco.";
                    break;
                default:
                    $message = "Tarjeta no válida. Contacta a tu banco.";
            }
        } catch (\OpenpayApiRequestError $e){
            $message = "Tarjeta no válida. Contacta a tu banco.";
        } catch (Exception $e){
            $message = "No se pudo agregar la tarjeta, inténtalo nuevamente.";
        }
        log::info($message);
        DB::rollback();
        return [
            "status" => "error",
            "message" => $message
        ];
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
        //$requestUser = $request->user();
        $customer = $openpay->customers->get($request->customer_id);
        $customer->delete();
        //$requestUser->customer_id = null;
        $requestUser->save();
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
