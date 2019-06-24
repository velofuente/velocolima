<?php

Openpay::setSandboxMode(env('OPENPAY_SANDBOX', true));
$openpay = Openpay::getInstance(env('OPENPAY_ID','default'), env('OPENPAY_PRIVATE_KEY','default'));

return [
    "openpay" => $openpay,
];