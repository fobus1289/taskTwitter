<?php

namespace app\models\traits;

use app\models\Channel;

trait UserAssistant 
{

    /**
     * @return array
     */
    public function fields() {
        return [ 
            'id' => $this->id,
            'name' => $this->name,
            'last_name'=>$this->last_name,
            'login' => $this->login,
            'dateOfBirth' => $this->date_of_birth,
            'icon' => $this->icon,
            'following'=> $this->following()->count(),
            'followers'=> $this->followers()->count(),
            'signed' => $this->signed()
        ];
    }
    
    private function hasChannel($id)
    {
        if($id == $this->id) {
            validation_error('400',['message' => "You can't subscribe to yourself"]);
        }
        
        $publisher = static::findOne(['id' => $id]);
        
        if($publisher == null) {
           validation_error('400',['message' => 'No such channel exists']);
        }
        
        return $this->hasOne(Channel::class,[
            'subscriber' => 'id'
        ])->where(['publisher' => $publisher->id])->one();
        
    }
    
    /**
     * @param int $id
     * @return \yii\db\ActiveRecord
     */
    public function subscriber($id)
    {
       $result = $this->hasChannel($id);
       
       if($result) {
           validation_error('400',['message' => 'You are already subscribed to this channel']);
       }
       
       $channel = Channel::create([
           'subscriber' => $this->id,
           'publisher'  => $id
       ]);
       
       return $channel;
    }
    
    /**
     * @param int $id
     * @return boolean
     */
    public function unSubscriber($id)
    {
        $result = $this->hasChannel($id);
        
        if($result == null) {
            validation_error('400',['error' => 'This channel does not exist']);
        }
        
        return $result->delete();
    }
 
    public function attachComment($data)
    {
        $data['user_id'] = $this->id;

        return \app\models\Comment::create($data) ?? false;
    }

    /**
     * @param string $name
     * @param string $value
     */
    public function __set($name, $value) {
        
        if($name == 'password') {
            $value = bcrypt($value);
        }
        parent::__set($name, $value);
    }
 
    /**
     * @return array
    */
    public static function credentials()
    {
        return [
            'primary' => 'id',
            'login' => 'login',
            'passwd' => 'password',
        ];
    }

}
