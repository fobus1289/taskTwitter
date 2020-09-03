<?php

namespace request\update;

use crutch\Request;

class UserUpdateRequest extends Request
{
    
    protected function methodsAllowed()
    {
        return ['put','options'];
    }

    protected function specialCheckFile()
    {
        return [
            'image' => [
                'image/gif',
                'image/jpeg',
                'image/pjpeg',
                'image/png',
                'image/svg', 
            ],
        ];
    }

    public function rulesLazy(\crutch\IMayBe $validator)
    {
        $this->removeAny(['id','login']);
        
        $validator->lazyMin('name', 2)
                  ->lazyMax('name', 40);
        
        $validator->lazyMin('last_name', 2)
                  ->lazyMax('last_name', 40); 
        
        $validator->lazyMin('password', 6)
                  ->lazyMax('password', 32); 
        
        $validator->lazyRequired('date_of_birth')
                  ->lazyDate('date_of_birth');

        $validator->lazyFileCheck('icon.image', ['jpg','jpeg','png','svg','gif'],1024);
    } 
    
    protected function messages()
    {
        return [ 
            'password.required'   => 'Пароль не может быть пустым',
            'password.min'        => 'Минемальная длина пароля может быть 6 символов',
            'password.max'        => 'Максимальная длина пароля может быть 32 символов',
            'name.min'            => 'Минимальная длина имени 2 символа',
            'name.max'            => 'Максимальная длина имени 40 символа',
            'last_name.min'       => 'Минимальная длина Фамилии 2 символа',
            'last_name.max'       => 'Максимальная длина Фамилии 40 символа',
            'icon.file'           => 'Файл не может быть пустым',
            'icon.file.type'      => 'Такой тип файла не подерживаетса', 
            'icon.file.size'      => 'Максемальный размер файла 1 мегабайт',
            'icon.file.extension' => 'Такая раширения файла не подерживаетса',
        ];
    }

    protected function error($array) 
    {
        validation_error('400', ['message' => $array]);
    }

}
