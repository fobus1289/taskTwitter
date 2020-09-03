<?php

namespace request\create;

use crutch\Request;

class CommentCreateRequest extends Request
{
    protected function methodsAllowed()
    {
        return ['post'];
    }
    
    public function rules(\crutch\IValidator $validator) 
    {
        $validator->required('message')
                  ->min('message', 2);
        $validator->number('parent_id');        
    }
   
    public function rulesLazy(\crutch\IMayBe $validator)
    {
        $validator->lazyFileCheck('media.image','*');
    }
    
    protected function messages()
    {
        return [ 
            'message.required' => 'Комментарий не может быть пустым',
            'parent_id.number' => 'Не коректные данные',
        ];
    }

    protected function error($array) 
    {
        validation_error('400', ['message' => $array]);
    }
}
