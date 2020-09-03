<?php

namespace request\auth;

use crutch\Request;

class LoginRequest extends Request
{
    
    protected function methodsAllowed()
    {
        return ['post'];
    }
    
    public function rules(\crutch\IValidator $validator) 
    {
        $validator->required('login')
                  ->email('login')
                  ->unique('login', 'users.login', false);
        
        $validator->required('password')
                  ->min('login', 6);
    }
  
    protected function messages()
    {
        return [ 
            'login.required'    => 'Логин не может быть пустым',
            'login.email'       => 'Недействительный адрес электронной почты',
            'login.unique.no'   => 'Неверный логин или пароль',
            'password.required' => 'Пароль не может быть пустым',
            'password.min'      => 'Минемальная длина пароля может быть 6 символов',
        ];
    }

    protected function error($array) 
    {
        validation_error('400', ['message' => $array]);
    }

}
