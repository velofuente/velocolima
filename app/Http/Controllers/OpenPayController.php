<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPUnit\Framework\Exception;
use App\{Purchase, Card, Product};
use App\Http\Controllers\CardController;
use Openpay, Log, Config, Auth, DB, Session;

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
        //Obtener usuario de la petición
        $requestUser = $request->user();
        $cardCount = Card::where('user_id', $requestUser->id)->count();
        if ($cardCount > 3) {
            $message = "No puedes agregar más de 3 tarjetas a tu perfil";
            return [
                "status" => "error",
                "message" => $message
            ];
        }
        //Validar si el usuario ya existe en OpenPay
        if ($requestUser->customer_id == null) {
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
            $message = "No se encontró la tarjeta ingrasada, pruebe de nuevo.";
            return [
                "status" => 'error',
                "message" => $message,
            ];
        } else {
            //TODO: Validar si existe la tarjeta en mi base de datos con los datos obtenidos de getCardToken
            $existsCard = DB::table('cards')
                ->where('card_number', '=', "{$cardData->card->card_number}")
                ->get();

            if (!isset($existsCard)) {
                $message = "La tarjeta que deseas ingresar ya existe favor de revisar los datos de la tarjeta o ingresar una nueva.";
                return [
                    "status" => "error",
                    "message" => $message,
                ];
            } else {
                //TODO: Validar si existe la tarjeta en mi base de datos con los datos obtenidos de getCardToken
                $existsCard = DB::table('cards')
                                ->where('card_number', '=', "{$cardData->card->card_number}")
                                ->get();
                if (!isset($existsCard)) {
                    return "La tarjeta que deseas ingresar ya existe favor de revisar los datos de la tarjeta o ingresar una nueva.";
                }
                else{
                    $userCards = Card::where('user_id' , $requestUser->id)->get();
                    if (count($userCards) > 0) {
                        Card::where('user_id' , $requestUser->id)
                            ->where('selected', 1)
                            ->update(['selected' => 0]);
                    }
                    // Session::flash('alertButton', "Aceptar");
                    $cardDataRequest = [
                        'token_id' => $cardData->id,
                        'device_session_id' => $request->device_session_id
                    ];
                    try{
                        $card = $openPayCustomer->cards->add($cardDataRequest);
                        (new CardController)->store($cardData,$requestUser->id);
                        DB::commit();
                        Session::flash('alertTitle', "Tarjeta guardada");
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
                    }
                    return [
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
            return "No se pudo agregar el cliente - Message: {$e->getMessage()}";
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
        $apiUrl = "https://{$key}@" . env("OPENPAY_GETCARDTOKEN_URL", '') . "/v1/{$merchantId}/tokens/{$tokenId}";
        //$apiUrl = "https://{$key}@api.openpay.mx/v1/{$merchantId}/tokens/{$tokenId}";
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

        try {
            DB::beginTransaction();
            //Inicializamos array para compra (MI DB)
            $purchaseArray = [
                'product_id' => $product->id,
                // 'card_id' => $card->id,
                'user_id' => $requestUser->id,
                'n_classes' => $product->n_classes,
                'expiration_days' => $product->expiration_days,
            ];
            //Obtenemos el token de la tarjeta
            $cardToken = $request->token_id;
            $card = Card::where('token_id', $cardToken)->where('user_id', $requestUser->id)->first();
            if ($card) {
                $purchaseArray = array_merge($purchaseArray, ["card_id" => $card->id]);
            } else if($cardToken) {
                $purchaseArray = array_merge($purchaseArray, ["card_token" => $cardToken]);
            }
            // $purchaseArray["card_id"] = $card->id;
            // $cardToken = $card->token_id;
            //Registramos la compra en el sistema
            //promocion clase adicional
            /*$promotion = Purchase::where('user_id', $requestUser->id)->where('status', 'pending')->latest()->first();
            if($promotion != null){
                if(Carbon::now() < Carbon::parse($promotion->created_at)->addDay() && $product->n_classes >= 10){
                    $promotion->status = 'active';
                    $promotion->save;
                }
            }*/
            //verificar si compro un paquete de mas o igual a 10 clases
            if (intval($product->n_classes) >= 10) {
                //promocion clase adicional verificar si tiene 1 clase
                $lastClassPurchase = Purchase::where('user_id', $requestUser->id)
                    ->where('n_classes', "<>", 0)
                    ->whereRaw("NOW() < DATE_ADD(created_at, INTERVAL expiration_days DAY)")
                    ->orderByRaw('DATE_ADD(created_at, INTERVAL expiration_days DAY)')
                    ->first();
                if ($lastClassPurchase) {
                    // Verificar que la última clase adquirida no haya sido la clase gratis de registro o la gratis de cumpleaños
                    if ($lastClassPurchase->product->id != 1 ||  $lastClassPurchase->product->id != 12) {
                        // En Pruebas la clase cumpleaños es id = 11, y la de regalo es id = 12
                        $promocion = Product::find(13);
                        Purchase::create([
                            'product_id' => $promocion->id,
                            'user_id' => $requestUser->id,
                            'n_classes' => $promocion->n_classes,
                            'expiration_days' => $promocion->expiration_days,
                            'status' => 'active',
                        ]);
                    }
                }
            }
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
            $customer->charges->create($chargeData);
            DB::commit();
            Session::flash('alertTitle', "Compra realizada");
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
        //TODO: Validar producto
        $product = Product::where('id', '=', "{$request->product_id}")->first();
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
            //verificar si compro un paquete de mas o igual a 10 clases
            if(intval($product->n_classes) >= 10){
                //promocion clase adicional verificar si tiene 1 clase
                $lastClassPurchase = Purchase::where('user_id', $requestUser->id)
                ->where('n_classes', "<>", 0)
                ->whereRaw("NOW() < DATE_ADD(created_at, INTERVAL expiration_days DAY)")
                ->orderByRaw('DATE_ADD(created_at, INTERVAL expiration_days DAY)')->first();
                if($lastClassPurchase){
                    if($lastClassPurchase->product->id != 1 ||  $lastClassPurchase->product->id != 11){
                        $promocion = Product::find(12);
                        Purchase::create([
                            'product_id' => $promocion->id,
                            'user_id' => $requestUser->id,
                            'n_classes' => $promocion->n_classes,
                            'expiration_days' => $promocion->expiration_days,
                            'status' => 'active',
                        ]);
                    }
                }
            }
             //Registramos la compra en el sistema
             $compra = Purchase::create($purchaseArray);
            /*$promotion = Purchase::where('user_id', $requestUser->id)->where('status', 'pending')->latest()->first();
            if($promotion != null){
                if(Carbon::now() < Carbon::parse($promotion->created_at)->addDay() && $product->n_classes >= 10){
                    $promotion->status = 'active';
                    $promotion->save;
                }
            }*/
            //Inicializamos array de cargo (OpenPay)
            $chargeData = [
                'method' => 'card',
                'source_id' => $cardToken,
                'amount' => $product->price,
                'description' => $product->description,
                'order_id' => 'ORDEN-'.$compra->id."-".time(),
                'device_session_id' => $request->device_session_id
            ];

            $customer->charges->create($chargeData);
            DB::commit();
            Session::flash('alertTitle', "Compra realizada");
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
