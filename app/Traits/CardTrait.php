<?php

namespace App\Traits;

Trait GeneralTrait
{

    private function checkIfCustomerAlreadyHasCard($cardNumber, ...$customerCards){
        foreach ($customerCards as $key => $card) {
            if($card->last4 == substr($cardNumber, -4)){
                return true;
                break;
            }
        }
        return false;
    }
}