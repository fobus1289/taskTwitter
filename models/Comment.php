<?php

namespace app\models;

/**
 * This is the model class for table "comments".
 *
 * @property int $id
 * @property string|null $message
 * @property string|null $media
 * @property string|null $media_type
 * @property int|null $user_id
 * @property int|null $parent_id
 * @property string|null $comment_date
 */
class Comment extends \yii\db\ActiveRecord
{  
    use \app\models\traits\ModelAssistant;

    public static function tableName()
    {
        return 'comments';
    }
    
    public function fields() {
        return [
            'id' => $this->id,
            'message' => $this->message,
            'media' => $this->media,
            'user_id' => $this->user_id,
            'parent_id' => $this->parent_id,
            'comment_date' => $this->comment_date,
            'child' =>  map($this->child(), function($key,$value){
                            return $value->fields();
                        })
        ];
    }
    
    public function rules()
    {

        return [
            [['media_type'], 'string'],
            [['user_id', 'parent_id'], 'integer'],
            [['comment_date'], 'safe'],
            [['message', 'media'], 'string', 'max' => 255],
        ];
    }

    
    public function child()
    {
        return $this->hasMany(self::class, [
            'parent_id' => 'id'
        ])->all();
    }
    
}
