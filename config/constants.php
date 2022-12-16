<?php

use Carbon\Carbon;

return [
    'validation_codes' => [
        'bad_request' => 400,
        'unauthorized' => 401,
        'forbidden' => 403,
        'not_found' => 404,
        'unprocessable_entity' => 422,
        'too_many_request' => 429,
        'internal_server' => 500,
        'success' => 200,
        'bad_gatway' => 502
    ],

    'visible' => [
        'no' => false,
        'yes' => true,
    ],

    'visible_text' => [
        '0' => false,
        '1' => true,
    ],

    'visible_code' => [
        'no' => '0',
        'yes' => '1'
    ],

    'status' => [
        '0' => 'Inactive',
        '1' => 'Active',
    ],
    'status_code' => [
        'inactive' => '0',
        'active' => '1'
    ],

    'role' => ['admin'=>'admin','customer'=>'customer']
];
