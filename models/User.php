<?php

namespace app\models;

use app\models\traits\UserAssistant;
use app\models\traits\ModelAssistant;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $login 
 * @property string|null $last_name 
 * @property string|null $password
 * @property string|null $date_of_birth
 * @property string|null $icon
 */
class User extends \yii\db\ActiveRecord implements \crutch\IAuth
{
    use UserAssistant,ModelAssistant;
            
    public static function tableName()
    {
        return 'users';
    }
    
    public function rules()
    {
        return [
            [['date_of_birth'], 'safe'],
            [['name','last_name', 'login', 'password', 'icon'], 'string', 'max' => 255],
            [['login'], 'unique'],
        ];
    }
 
    /**
     * @param int $id
     * @return Comment
     */
    public function findByIdComment($id)
    {
       return $this->hasOne(Comment::class, [
           'user_id'=> 'id'
       ])->where(['id'=>$id])->one()
               ??
       validation_error('400', ['message' => 'Incorrect data']);
    }

    public function following()
    {
        return $this->hasMany(Channel::class, [
            'subscriber'=>'id'
        ]);
    }

    public function signed()
    {
        if(!$data = \crutch\AuthMan::$data) {
            return false;
        }
        return (bool)$this->hasOne(Channel::class, [
            'publisher' => 'id'
        ])->where([
            'subscriber' => $data['payload']['id']
        ])->count();
    }

    public function followers()
    {
        return $this->hasMany(Channel::class, [
            'publisher'=>'id'
        ]);
    }

    public function afterFind()
    {
        
        parent::afterFind();
    }
    
}
