<?php

Openpay::setSandboxMode(env('OPENPAY_SANDBOX', true));
$openpay = Openpay::getInstance(env('OPENPAY_ID','default'), env('OPENPAY_PRIVATE_KEY','default'));
$defaultCancelationMinutes = env("DEFAULT_CANCELATION_MINUTES", 120);
$minutesAfterClassStart = env("MINUTES_AFTER_CLASS_START", -15);

return [
    "openpay" => $openpay,
    "defaultCancelationMinutes" => $defaultCancelationMinutes,
    "minutesAfterClassStart" => $minutesAfterClassStart,
];