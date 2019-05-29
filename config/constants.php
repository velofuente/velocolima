<?php

$openpay = Openpay::getInstance(env('OPENPAY_ID','default'), env('OPENPAY_PRIVATE_KEY','default'));

return [
    "openpay" => $openpay,
];