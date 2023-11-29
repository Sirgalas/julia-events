<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%managers_events}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%managers}}`
 * - `{{%events}}`
 */
class m231129_124718_create_junction_table_for_managers_and_events_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%managers_events}}', [
            'managers_id' => $this->integer(),
            'events_id' => $this->integer(),
            'PRIMARY KEY(managers_id, events_id)',
        ]);

        // creates index for column `managers_id`
        $this->createIndex(
            '{{%idx-managers_events-managers_id}}',
            '{{%managers_events}}',
            'managers_id'
        );

        // add foreign key for table `{{%managers}}`
        $this->addForeignKey(
            '{{%fk-managers_events-managers_id}}',
            '{{%managers_events}}',
            'managers_id',
            '{{%managers}}',
            'id',
            'CASCADE'
        );

        // creates index for column `events_id`
        $this->createIndex(
            '{{%idx-managers_events-events_id}}',
            '{{%managers_events}}',
            'events_id'
        );

        // add foreign key for table `{{%events}}`
        $this->addForeignKey(
            '{{%fk-managers_events-events_id}}',
            '{{%managers_events}}',
            'events_id',
            '{{%events}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%managers}}`
        $this->dropForeignKey(
            '{{%fk-managers_events-managers_id}}',
            '{{%managers_events}}'
        );

        // drops index for column `managers_id`
        $this->dropIndex(
            '{{%idx-managers_events-managers_id}}',
            '{{%managers_events}}'
        );

        // drops foreign key for table `{{%events}}`
        $this->dropForeignKey(
            '{{%fk-managers_events-events_id}}',
            '{{%managers_events}}'
        );

        // drops index for column `events_id`
        $this->dropIndex(
            '{{%idx-managers_events-events_id}}',
            '{{%managers_events}}'
        );

        $this->dropTable('{{%managers_events}}');
    }
}
