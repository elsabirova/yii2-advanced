<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%task}}`.
 */
class m190221_123804_create_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%task}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'description' => $this->text()->notNull(),
            'project_id' => $this->integer(),
            'executor_id' => $this->integer(),
            'started_at' => $this->integer(),
            'completed_at' => $this->integer(),
            'creator_id' => $this->integer()->notNull(),
            'updater_id' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-task-executor_id',
            'task',
            'executor_id',
            'user',
            'id'
        );

        $this->addForeignKey(
            'fk-task-creator_id',
            'task',
            'creator_id',
            'user',
            'id'
        );

        $this->addForeignKey(
            'fk-task-updater_id',
            'task',
            'updater_id',
            'user',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-task-executor_id',
            'task'
        );

        $this->dropForeignKey(
            'fk-task-creator_id',
            'task'
        );

        $this->dropForeignKey(
            'fk-task-updater_id',
            'task'
        );

        $this->dropTable('{{%task}}');
    }
}
