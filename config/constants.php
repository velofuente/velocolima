<?php

Openpay::setSandboxMode(env('OPENPAY_SANDBOX', true));
$openpay = Openpay::getInstance(env('OPENPAY_ID','default'), env('OPENPAY_PRIVATE_KEY','default'));
$defaultCancelationMinutes = env("DEFAULT_CANCELATION_MINUTES", 120);
$minutesAfterClassStart = env("MINUTES_AFTER_CLASS_START", -15);

return [
    "openpay" => $openpay,
    "defaultCancelationMinutes" => $defaultCancelationMinutes,
    "minutesAfterClassStart" => $minutesAfterClassStart,
    "reservationDayCountLimit" => env("RESERVATION_DAY_COUNT_LIMIT", true),
    "reservationDayMessage" => env("RESERVATION_DAY_MESSAGE", "Ya tienes una clase reservada en este día (Solo puedes reservar una clase en el día)."),
    "promotionalVeloBranchId" => env("PROMOTIONAL_VELO_BRANCH_ID", 3),
    "promotionalForteBranchId" => env("PROMOTIONAL_FORTE_BRANCH_ID", 5),
];