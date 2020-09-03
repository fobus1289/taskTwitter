<?php

//    BadRequestHttpException — 400 ошибка
//    UnauthorizedHttpException — 401 ошибка
//    ForbiddenHttpException — 403 ошибка
//    NotFoundHttpException — 404 ошибка
//    MethodNotAllowedHttpException — 405 ошибка
//    NotAcceptableHttpException — 406 ошибка
//    ConflictHttpException — 409 ошибка
//    GoneHttpException — 410 ошибка
//    UnsupportedMediaTypeHttpException — 415 ошибка
//    TooManyRequestsHttpException — 429 ошибка
//    ServerErrorHttpException — 500 ошибка

return [
    '400' => \yii\web\BadRequestHttpException::class,
    '401' => \yii\web\UnauthorizedHttpException::class,
    '404' => \yii\web\MethodNotAllowedHttpException::class,
    '405' => \yii\web\BadRequestHttpException::class,
    '406' => \yii\web\NotAcceptableHttpException::class,
    '409' => \yii\web\ConflictHttpException::class,
    '410' => \yii\web\GoneHttpException::class,
    '415' => \yii\web\UnsupportedMediaTypeHttpException::class,
    '429' => \yii\web\TooManyRequestsHttpException::class,
    '500' => \yii\web\ServerErrorHttpException::class,
];