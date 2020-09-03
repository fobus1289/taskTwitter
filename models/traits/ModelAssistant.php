<?php

namespace app\models\traits;

trait ModelAssistant 
{
 
    /**
     * @param array $data
     * @return \yii\db\ActiveRecord
    */
    public static function create($data)
    {
        /**
         * @var $model \yii\db\ActiveRecord
         */
        $model = new static();
        
        filter($data, function($key,$value) use($model) {
            if($model->hasAttribute($key)){
                $model->$key = $value;
            }    
        });         
        
        $model->save();
        
        return $model;
    }
        
}
