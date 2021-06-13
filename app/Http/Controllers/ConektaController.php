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
      if($product){
        Conekta::setApiKey(env('CONEKTA_PRIVATE_KEY'));
        Conekta::setApiVersion("2.0.0");
          try{
            $order = \Conekta\Order::create(
              [
              "line_items" => [
                [
                  "name" => $product->description,
                  "unit_price" => $product->price,
                  "quantity" => 1
                ]
              ],
              "currency" => "MXN",
              "customer_info" => [
                "name" => $user->name." ". $user->last_name,
                "email" => $user->email,
                "phone" => $user->phone,
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
          return ['status' => false, 'code' => $error->getCode() ,'message' => $error->getMesage(), 'data' => ''];
          } catch (\Conekta\ParameterValidationError $error){
          return ['status' => false, 'code' => $error->getCode() ,'message' =>$error->getMessage(), 'data' => ''];
          } catch (\Conekta\Handler $error){
          return ['status' => false, 'code' => $error->getCode() ,'message' =>$error->getMessage(), 'data' => ''];
          } 
          return ['status' => true, 'code' => 200 ,'message' => 'Pago realizado correctamente', 'data' => $order];
      }else{
        return ['status' => false, 'code' => 404 ,'message' => 'No se encontró el producto', 'data' => ''];
      }
/*         
        //SE DEJARÁ PARA SI SE QUIERE IMPLEMENTAR EL REGISTOR DE TARJETAS CON CONEKTA
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
            } catch (\Conekta\ProccessingError $error){
            return json_encode(['status' => false, 'code' => $error->getCode() ,'message' => $error->getMesage()]);
            } catch (\Conekta\ParameterValidationError $error){
            return json_encode( ['status' => false, 'code' => $error->getCode() ,'message' =>$error->getMessage()]);
            } catch (\Conekta\Handler $error){
            return json_encode( ['status' => false, 'code' => $error->getCode() ,'message' =>$error->getMessage()]);
            }
        }else{
            $customer = Conekta::Customer.find($user->conekta_token_user_id);
        }
        if($this->checkIfCustomerAlreadyHasCard($request->number, $customer.payment_sources)){
            
        }else{
            $user->cards()->create([
            'token_id' => $request->conektaTokenId, 
            'card_number' =>  $request->number, 
            'holder_name' => $request->name, 
            'expiration_year' => 20, 
            'expiration_moth' => 20, 
            'selected' => true, 
            'brand' => $request->brand_card]);
        }  */
        //Implementación de una orden.

/*         echo "ID: ". $order->id;
        echo "Status: ". $order->payment_status;
        echo "$". $order->amount/100 . $order->currency;
        echo "Order";
        echo $order->line_items[0]->quantity .
            "-". $order->line_items[0]->name .
            "- $". $order->line_items[0]->unit_price/100;
        echo "Payment info";
        echo "CODE:". $order->charges[0]->payment_method->auth_code;
        echo "Card info:".
            "- ". $order->charges[0]->payment_method->name .
            "- ". $order->charges[0]->payment_method->last4 .
            "- ". $order->charges[0]->payment_method->brand .
            "- ". $order->charges[0]->payment_method->type; */
    }

}
