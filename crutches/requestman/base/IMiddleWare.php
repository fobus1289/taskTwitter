<?php

namespace crutch;

interface IMiddleWare
{
    public function handle(\yii\web\Request &$request);
}
