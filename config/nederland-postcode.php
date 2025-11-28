<?php

return [

    'base_url' => env('NEDERLAND_POSTCODE_BASE_URL', 'https://api.nederlandpostcode.com/v1/'),

    'api_key' => env('NEDERLAND_POSTCODE_API_KEY'),

    'timeout' => env('NEDERLAND_POSTCODE_TIMEOUT', 10),

    'retry_times' => env('NEDERLAND_POSTCODE_RETRY_TIMES', 3),

    'retry_sleep' => env('NEDERLAND_POSTCODE_RETRY_SLEEP', 1000),

];
