<?php

namespace app\controllers;

use app\models\User;
use crutch\Request;
use crutch\AuthMan;
use request\auth\RegisterRequest;
use request\auth\LoginRequest;
use request\update\UserUpdateRequest;

class AuthorizationController extends BaseRestController
{
     
    #по умолчанию он false
    #если true то будет создавать экземпляры в параметрах экшенв (actionIndex ...) автоматом
    #примечание не подерживает классы с приватном конструктром и с параметрами
    #может бросить исключение если не соблюдать 3 пункт
    protected $authoBindingParams = true;
    
    protected function postConstruct() 
    {
        #если 2 параметр middleware не null
        #обслуживает все маршруты этого экземпляра
        #примечание 2 параметр middleware не null то middleware возвращает null 
        #если такого класса нету по пути __DIR__.'/../config/middleware.php' 
        #будет бораш исключение \yii\web\ServerErrorHttpException
        $this->middleware(['cross'],'*');
        
        #если 2 параметр middleware null
        #примечание 2 параметр middleware null то middleware возвращает \AppCrutch\IMiddleMan
        #only обслуживает все входящие маршруты указиные в массиве
        $this->middleware(['me'])
             ->only(['actionMe','actionUpdate']);
    }

    
    /**
     * @param Request $request
     * @return type
     */
    public function actionRegister(RegisterRequest $request)
    {        
        
        $credentials = $request->all(['login','password']); 
        
        $data = $request->all();
        
        $user = User::create($data);
        
        return $this->asJson([
            'success' => true,
            'token' => AuthMan::attach($credentials),
            'user' => $user->fields()
        ]);
        
    }
    
    /**
     * @param UserUpdateRequest $request
     * @return mixed
     */
    public function actionUpdate(UserUpdateRequest $request)
    {
        $user = user();
              
        filter($request->all(), function($key,$value) use(&$user) {
            if($user->hasAttribute($key)) {
                $user->$key = $value; 
            }
        });
        
        if($request->file('icon')) {
            
           $defaultIcon = 'web/images/no-image.png'; 
           $filename = $request->store('icon');

           if($user->icon != $defaultIcon) {
               @\unlink(base_path($user->icon));
           }

           $user->icon = $filename ?? $defaultIcon;
        }
        
        $user->save();
        
        $fiels = $user->fields();
        
        $token = AuthMan::JWT()->encode($fiels);
        
        return $this->asJson([
            'success' => true,
            'user' => $fiels,
            'token' => $token
        ]);
        
    }
    
    public function actionSearch()
    {
        
        $owner = User::find()->where(['like', 'name', get('q') . '%', false]);
       
        if(($token = get('token'))) {
            try{
                $data = AuthMan::JWT()->decode($token, jwt_config('secret'),false);
                $id = $data['payload']['id'];
                $owner->andWhere(['NOT', ['id' => $id]]);
            } catch (\Throwable $ex) {

            }
        }   
       
        return $this->asJson([
            'owner'=> $owner->one()->fields(),
        ]);
    }

    public function actionLogin(LoginRequest $request)
    {
                
        $credentials = $request->all(['login','password']); 
        
        $token = AuthMan::attach($credentials);
          
        return $this->asJson([
            'success' => true,
            'token' => $token,
            'user' => user()->fields()
        ]);
    }

    public function actionRefresh() 
    {
        return $this->asJson([
           'success' => true,
           'token' => AuthMan::JWT()->refresh()
        ]);
    }

    public function actionMe()
    {
        return $this->asJson([
           'success' => true,
           'user' => user()->fields() 
        ]);
    }  
    
}
