<?php

namespace app\controllers\traits;

trait ControllerAssistant
{

    /**
     * @param \yii\db\ActiveRecord $models
     * @param string $name
     * @return array
     */
    public function convertArray($models ,$name = '')
    {
        if($name == '') {
            return parent::asJson($this->toArr($models));  
        }
        $models[$name] = $this->toArr($models[$name]);
        return parent::asJson($models);
    }
        
    private function toArr($models) 
    {
        $result = [];

        foreach($models as $model){
            if($model instanceof \yii\db\ActiveRecord){
               $result[] = $model->fields(); 
            }
        }
        
        return $result;
    }
    
}
