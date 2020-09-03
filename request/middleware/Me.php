<?php

namespace request\middleware;

class Me implements \crutch\IMiddleWare
{
  
    public function handle(\yii\web\Request &$request)
    {
        \crutch\AuthMan::detach();
    }

}
