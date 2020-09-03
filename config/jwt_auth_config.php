<?php

return [
    //user namespace
    'user' => \app\models\User::class,
    //minutes 1 ... 60
    'token_expired' => 120,
    //3 days time() + (24 * 3 * 60 * 60)
    'refresh_expired' => day_unix(3),
    //you secret
    'secret' => 'secret@secret',
    //token header key
    'header_key' => 'Authorization',
    //token parse prefix 
    'prefix' => ''
];
