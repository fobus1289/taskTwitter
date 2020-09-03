<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m200828_010149_create_users_table extends Migration
{

    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'last_name' => $this->string(),
            'name' => $this->string(),
            'login' => $this->string()
                            ->unique(),
            'password' => $this->string(),
            'date_of_birth' => $this->date(),
            'icon' => $this->string()
                           ->defaultValue('web/images/no-image.png'),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}
