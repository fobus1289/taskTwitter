<?php

namespace request\update;

use crutch\Request;

class CommentUpdateRequest extends Request
{
    
    /**
     * @example проверяет текущий метод бросает исключение 405
     */
    protected function methodsAllowed()
    {
        return ['put'];
    }
    
    public function rulesLazy(\crutch\IMayBe $validator)
    {
        $validator->removeAny(['user_id','parent_id']);
        
        $validator->lazyRequired('id')
                  ->lazyNumber('id');
        
        $validator->lazyFileCheck('media.image','*');
        
        $validator->lazyRequired('message');
    }
    
    protected function messages()
    {
        return [
            'id.required' => 'иденфикатор не может быть пустым',
            'id.number' => 'иденфикатор коментария может быть числом',
            'media.file' => 'Файл не может быть пустым',
            'media.file.type' => 'Не коректный тип файла',
        ];
    }

    protected function error($array) 
    {
        validation_error('400', ['message' => $array]);
    }
    
}
