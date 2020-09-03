<?php

namespace request\middleware;

class Cross implements \crutch\IMiddleWare
{
    public function handle(\yii\web\Request &$request) 
    {   
        \header('Access-Control-Allow-Origin: *');
        \header('Access-Control-Allow-Methods: *'); 
        \header('Access-Control-Allow-Credentials: true');   
        \header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
    }
}
