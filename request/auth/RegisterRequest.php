<?php

namespace request\auth;

use crutch\Request;

class RegisterRequest extends Request
{
    
    protected function methodsAllowed()
    {
        return ['post'];
    }
    
    public function rules(\crutch\IValidator $validator) 
    {
        $validator->removeAny(['id']);
        
        $validator->required('login')
                  ->email('login')
                  ->unique('login', 'users.login');

        $validator->required('password')
                  ->min('password', 6)
                  ->max('password', 32)
                  ->confirmation('password', 'password_conf');
                
    }
  
    protected function messages()
    {
        return [ 
            'login.required'        => 'Логин не может быть пустым',
            'login.email'           => 'Недействительный адрес электронной почты',
            'login.unique'          => 'Этот логин уже используется',
            'password.required'     => 'Пароль не может быть пустым',
            'password.min'          => 'Минемальная длина пароля может быть 6 символов',
            'password.max'          => 'Максимальная длина пароля может быть 32 символов',
            'password.confirmation' => 'Пароли не совподают',
        ];
    }

    protected function error($array) 
    {
        validation_error('400', ['message' => $array]);
    }

}
