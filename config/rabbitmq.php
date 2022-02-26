<?php

return [

    'fake' =>  env('RABBITMQ_FAKE', 'false'),
    'host' =>  env('RABBITMQ_HOST', 'rabbitmq'),
    'port' => env('RABBITMQ_PORT', '5672'),
    'vhosts' => env('RABBITMQ_VHOSTS', '/'),
    'login' => env('RABBITMQ_LOGIN', 'guest'),
    'password' => env('RABBITMQ_PASSWORD', 'guest'),

];
