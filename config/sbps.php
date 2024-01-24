<?php

return [
    'account_id' => env('SBPS_ACCOUNT_ID'),
    'service' => [
        'key' => env('SBPS_SERVICE_KEY'),
        'secret' => env('SBPS_SERVICE_SECRET'),
        'continuous_secret' => env('SBPS_SERVICE_CONTINUOUS_SECRET'),
    ],
];