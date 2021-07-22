<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Conekta\Conekta;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Product;
use App\Card;
use App\CardAttempt;
use Carbon\Carbon;
/* use App\Traits\CardTrait; */

class ConektaController extends Controller
{

    public function checkout(Request $request){
      $user =  User::where('id',Auth::user()->id)->first();
      $product =  Product::where('id',$request->product_id)->first();
      $source;
      Conekta::setApiKey(env('CONEKTA_PRIVATE_KEY'));
      Conekta::setApiVersion("2.0.0");
      if($this->checkIfUserIsAbleToPurchase($user)){
        if($this->isCardAbleToProcess($user->id)){
          if($product){
            if(!$user->conekta_token_user_id){
              try {
              $customer = \Conekta\Customer::create(
                [
                  "name" =>  $user->name." ". $user->last_name,
                  "email" =>  $user->email,
                  "phone" =>  $user->phone,
                  "metadata" => ["reference" => $user->id]
                ]
              );
              $source = $customer->createPaymentSource([
                'token_id' => $request->conektaTokenId,
                'type'     => 'card'
              ]);
              $user->update(['conekta_token_user_id' => $customer->id]);
              } catch (\Conekta\ProccessingError $error){
              return json_encode(['status' => false, 'code' => $error->getCode() ,'message' => $error->getMesage()]);
              } catch (\Conekta\ParameterValidationError $error){
              return json_encode( ['status' => false, 'code' => $error->getCode() ,'message' =>$error->getMessage()]);
              } catch (\Conekta\Handler $error){
              return json_encode( ['status' => false, 'code' => $error->getCode() ,'message' =>$error->getMessage()]);
              }
            }else{
              $customer = \Conekta\Customer::find($user->conekta_token_user_id);
              $source = $customer->createPaymentSource([
                'token_id' => $request->conektaTokenId,
                'type'     => 'card'
              ]);
            }
              try{
                $order = \Conekta\Order::create(
                  [
                  "line_items" => [
                    [
                      "name" => $product->description,
                      "unit_price" => $product->price * 100, //conekta requiere que los cargos sean en centavos por lo que se multiplica por 100 
                      "quantity" => 1
                    ]
                  ],
                  "currency" => "MXN",
                  "customer_info" => [
                    "customer_id" => $customer->id
                  ],
                  "metadata" => ["user_id" => $user->id, 'product_id' => $product->id],
                  "charges" => [
                      [ 
                        "payment_method" => 
                        [
                          "type" => "card",
                          "payment_source_id" => $source->id
                        ]
                      ]
                  ]
                  ]
                );
              } catch (\Conekta\ProcessingError $error){
                $this->addAttemptCard($request, $user);
                logger()->info(['controller' => 'ConektaController', 'code_key' => $error->code, 'error' => json_decode($error->errorStack)->details[0]->message, 'error_code' => json_decode($error->errorStack)->type->error_code, 'error_type' => json_decode($error->errorStack)->type->error_type]);
                return ['status' => false, 'code' => $error->getCode() ,'message' =>  json_decode($error->errorStack)->details[0]->message, 'data' => ''];
              } catch (\Conekta\ParameterValidationError $error){
                $this->addAttemptCard($request, $user);
                logger()->info(['controller' => 'ConektaController', 'code_key' => $error->code, 'error' => json_decode($error->errorStack)->details[0]->message, 'error_code' => json_decode($error->errorStack)->type->error_code, 'error_type' => json_decode($error->errorStack)->type->error_type]);
                return ['status' => false, 'code' => $error->getCode() ,'message' => json_decode($error->errorStack)->details[0]->message, 'data' => ''];
              } catch (\Conekta\Handler $error){
                $this->addAttemptCard($request, $user);
                logger()->info(['controller' => 'ConektaController', 'code_key' => $error->code, 'error' => json_decode($error->errorStack)->details[0]->message, 'error_code' => json_decode($error->errorStack)->type->error_code, 'error_type' => json_decode($error->errorStack)->type->error_type]);
                return ['status' => false, 'code' => $error->getCode() ,'message' => 'Ocurrió un error al procesar el pago, intente más tarde o use otra tarjeta', 'data' => ''];
              } 
              $card = $user->cards()->create([
                'token_id' =>  $source->id, 
                'card_number' =>  $request->number, 
                'holder_name' => $request->name, 
                'expiration_year' => $source->exp_year, 
                'expiration_moth' => $source->exp_month, 
                'selected' => true, 
                'brand' => $request->brand_card]);
              $purchase = $this->createPurchase($user, $product, $card);
              $this->createOrder($purchase, $order);
              return ['status' => true, 'code' => 200 ,'message' => 'Pago realizado correctamente', 'data' => $order];
          }else{
            return ['status' => false, 'code' => 404 ,'message' => 'No se encontró el producto', 'data' => ''];
          }
        }else{
          return ['status' => false, 'code' => 404 ,'message' => 'Ha superado el limite de intentos por día, vuelva intetar nuevamente en 24 horas (Después de: '.Carbon::now()->addHours(24)->format('d/m/Y h:i a').') o prueba con otro tarjeta', 'data' => ''];
        }
      }else{
        return ['status' => false, 'code' => 500 ,'message' => 'Por seguridad, no puede hacer compras consecutivas con menos de 3 minutos de diferencia, espere 3 minutos y podrá volver a hacer compras. Gracias', 'data' => ''];
      }
    }

    private function isCardAbleToProcess($userId){
      $attemptsCard = CardAttempt::where('user_id', $userId)->whereDate('date', Carbon::now())->first();
      if(!$attemptsCard){
        return true;
      }else if($attemptsCard->attempts < env('ATTEMPTS_ALLOWED_CARD', 3)){
        return true;
      }else{
        return false;
      }
    }
    private function addAttemptCard($request, $user){
      $cardAttempt = CardAttempt::where('user_id', $user->id)->first();
      if($cardAttempt){
        if($cardAttempt->date->format('Y-m-d') == Carbon::now()->format('Y-m-d')){
          $cardAttempt->attempts += 1;
          $cardAttempt->save();
        }else{
          $cardAttempt->attempts = 1;
          $cardAttempt->date = Carbon::now()->format('Y-m-d');
          $cardAttempt->save();
        }
      }else{
        CardAttempt::create(['user_id' => $user->id, 'attempts' => 1, 'date' => Carbon::now()]);
      } 
    }

    public function charge(Request $request){
      $user =  User::where('id',Auth::user()->id)->first();
      if($this->checkIfUserIsAbleToPurchase($user)){
        $product =  Product::where('id',$request->product_id)->first();
        $card =  Card::where('id',$request->card_id)->first();
        Conekta::setApiKey(env('CONEKTA_PRIVATE_KEY'));
        Conekta::setApiVersion("2.0.0");
        if($product){
          if($user->conekta_token_user_id){
            $customer = \Conekta\Customer::find($user->conekta_token_user_id);
            try{
              $order = \Conekta\Order::create(
                [
                "line_items" => [
                  [
                    "name" => $product->description,
                    "unit_price" => $product->price * 100, //conekta requiere que los cargos sean en centavos por lo que se multiplica por 100 
                    "quantity" => 1
                  ]
                ],
                "currency" => "MXN",
                "customer_info" => [
                  "customer_id" => $customer->id
                ],
                "metadata" => ["user_id" => $user->id, 'product_id' => $product->id],
                "charges" => [
                    [ 
                      "payment_method" => 
                      [
                        "type" => "card",
                        "payment_source_id" =>  $card->token_id
                      ]
                    ]
                ]
                ]
              );
            } catch (\Conekta\ProcessingError $error){
            return ['status' => false, 'code' => $error->getCode() ,'message' =>  json_decode($error->errorStack)->details[0]->message, 'data' => ''];
            } catch (\Conekta\ParameterValidationError $error){
            return ['status' => false, 'code' => $error->getCode() ,'message' => json_decode($error->errorStack)->details[0]->message, 'data' => ''];
            } catch (\Conekta\Handler $error){
            return ['status' => false, 'code' => $error->getCode() ,'message' => 'Ocurrió un error al procesar el pago, intente más tarde o use otra tarjeta', 'data' => ''];
            } 
            $purchase = $this->createPurchase($user, $product, $card);
            $this->createOrder($purchase, $order);
            return ['status' => true, 'code' => 200 ,'message' => 'Pago realizado correctamente', 'data' => $order];
        }else{
          return ['status' => false, 'code' => 404 ,'message' => 'Ocurrió un error al hacer el cargo', 'data' => ''];
        }
      }else{
        return ['status' => false, 'code' => 404 ,'message' => 'No se encontró el producto', 'data' => ''];
      } 
    }else{
      return ['status' => false, 'code' => 500 ,'message' => 'Por seguridad, no puede hacer compras consecutivas con menos de 3 minutos de diferencia, espere 3 minutos y podrá volver a hacer compras. Gracias', 'data' => ''];
    }
  }

  private function checkIfUserIsAbleToPurchase($user)
  {
    $lastUserPurchase = $user->purchase->last();
    if($lastUserPurchase){
      if($lastUserPurchase->created_at->addMinutes(3) > now()){
        return false;
      }else{
        return true;
      }
    }else{
      return true ;
    }
  }

    private function createPurchase($user, $product, $card){
      $purchaseArray = [
        'product_id' => $product->id,
        'card_id' => $card->id,
        'n_classes' => $product->n_classes,
        'expiration_days' => $product->expiration_days,
      ];
      return $user->purchase()->create($purchaseArray);
    }

    private function createOrder($purchase, $order){
      $orderArray = [
        'token_conekta_id' => $order->id,
        'status' => $order->payment_status,
        'auth_code' => $order->charges[0]->payment_method->auth_code                  
      ];
      $purchase->orders()->create($orderArray);
    }

}
