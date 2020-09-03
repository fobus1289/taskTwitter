<?php

namespace app\models;

/**
 * This is the model class for table "channels".
 *
 * @property int $id
 * @property int|null $publisher
 * @property int|null $subscriber
 */
class Channel extends \yii\db\ActiveRecord
{
    use traits\ModelAssistant;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'channels';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['publisher', 'subscriber'], 'integer'],
        ];
    }

}
