<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%managers}}`.
 */
class m231129_124240_create_managers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%managers}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(512),
            'email' => $this->string(),
            'phone' => $this->string(20)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%managers}}');
    }
}
