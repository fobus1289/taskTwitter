<?php

namespace crutch;

use app\models\User;

/**
 * @example authorization helper
 * @author Xotam <fobus1289@mail.ru>
 */
final class AuthMan
{
    /**
     * @var \app\models\User $user  
     */    
    public static $user;
    public static $data = null;
    /**
     * @param array $credentials
     * @return string|false
     */
    public static function attach($credentials) 
    {        
        $cred = User::credentials();
        
        self::$user = User::findOne([
            $cred['login'] => $credentials[$cred['login']]
        ]);
        
        if(self::$user != null) {
            if(\password_verify($credentials[$cred['passwd']],self::$user->password)) {
                return static::JWT()->encode(self::$user->fields());
            }
        }
        
        validation_error('400', ['message' => 'Неверный логин или пароль']);

    }
    
    /**
     * @param string $token
     * @param boolean $checkBaseEveryTime
     * @return array
     * @throws \yii\web\BadRequestHttpException
     */
    public static function detach($token = null,$checkBaseEveryTime = true)
    {
        self::$data = static::JWT()->decode($token ?? jwt_config('token'));
        
        if($checkBaseEveryTime) {
            
            $credentials = User::credentials();
            $primary = $credentials['primary'];
            $id = self::$data['payload'][$primary];
            self::$user = User::findOne([$primary => $id]);
             
            if(self::$user == null) {
                validation_error('404', ['message'=>'User not found']);
            }
            
        }
        
        return [
            'payload' => self::$data['payload'],
            'user' => self::$user
        ];
    }

    /**
     * 
     * @staticvar \crutch\JwtAuth $jwt
     * @return \crutch\JwtAuth
     */
    public static function &JWT() 
    {
        static $jwt;
        
        if($jwt == null) {
            $jwt = new JwtAuth();
        }
        return $jwt;
    }
 
    /**
     * @staticvar \app\models\User $user
     * @return \app\models\User
     */
    public static function &user()
    {
        return self::$user;
    }
           
}
