<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Conekta\Conekta;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Product;
/* use App\Traits\CardTrait; */

class ConektaController extends Controller
{

    public function checkout(Request $request){
      $user =  User::where('id',Auth::user()->id)->first();
      $product =  Product::where('id',$request->product_id)->first();
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
              "metadata" => ["reference" => $user->id],
              "payment_sources" => [
                [
                  "type" => "card",
                  "token_id" => $request->conektaTokenId
                ]
              ]
            ]
          );
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
        }
        $card = $user->cards()->create([
          'token_id' => $request->conektaTokenId, 
          'card_number' =>  $request->number, 
          'holder_name' => $request->name, 
          'expiration_year' => 20, 
          'expiration_moth' => 11, 
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
                      "token_id" => $request->conektaTokenId
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
