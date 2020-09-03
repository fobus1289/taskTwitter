<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%channels}}`.
 */
class m200831_121628_create_channels_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%channels}}', [
            'id' => $this->primaryKey(),
            'publisher' => $this->integer(),
            'subscriber' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%channels}}');
    }
}
