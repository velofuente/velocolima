<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Conekta\Conekta;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Product;
use App\Card;
/* use App\Traits\CardTrait; */

class ConektaController extends Controller
{

    public function checkout(Request $request){
      $user =  User::where('id',Auth::user()->id)->first();
      $product =  Product::where('id',$request->product_id)->first();
      $source;
      Conekta::setApiKey(env('CONEKTA_PRIVATE_KEY'));
      Conekta::setApiVersion("2.0.0");
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
        $card = $user->cards()->create([
          'token_id' =>  $source->id, 
          'card_number' =>  $request->number, 
          'holder_name' => $request->name, 
          'expiration_year' => $source->exp_year, 
          'expiration_moth' => $source->exp_month, 
          'selected' => true, 
          'brand' => $request->brand_card]);
          try{
            $order = \Conekta\Order::create(
              [
              "line_items" => [
                [
                  "name" => $product->description,
                  "unit_price" => $product->price * 100, //conekta requiere que los cargos sean en eentavos por lo que se multiplica por 100 
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
                      "payment_source_id" => $card->token_id
                    ]
                  ]
              ]
              ]
            );
          } catch (\Conekta\ProcessingError $error){
          return ['status' => false, 'code' => $error->getCode() ,'message' => $error, 'data' => ''];
          } catch (\Conekta\ParameterValidationError $error){
          return ['status' => false, 'code' => $error->getCode() ,'message' =>$error, 'data' => ''];
          } catch (\Conekta\Handler $error){
          return ['status' => false, 'code' => $error->getCode() ,'message' =>$error, 'data' => ''];
          } 
          $purchase = $this->createPurchase($user, $product, $card);
          $this->createOrder($purchase, $order);
          return ['status' => true, 'code' => 200 ,'message' => 'Pago realizado correctamente', 'data' => $order];
      }else{
        return ['status' => false, 'code' => 404 ,'message' => 'No se encontró el producto', 'data' => ''];
      }
    }

    public function charge(Request $request){
      $user =  User::where('id',Auth::user()->id)->first();
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
                  "unit_price" => $product->price * 100, //conekta requiere que los cargos sean en eentavos por lo que se multiplica por 100 
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
          return ['status' => false, 'code' => $error->getCode() ,'message' => $error, 'data' => ''];
          } catch (\Conekta\ParameterValidationError $error){
          return ['status' => false, 'code' => $error->getCode() ,'message' =>$error, 'data' => ''];
          } catch (\Conekta\Handler $error){
          return ['status' => false, 'code' => $error->getCode() ,'message' =>$error, 'data' => ''];
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
