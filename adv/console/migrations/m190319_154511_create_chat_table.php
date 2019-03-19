<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%chat}}`.
 */
class m190319_154511_create_chat_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%chat}}', [
            'id' => $this->primaryKey(),
            'message' => $this->text()->notNull(),
            'author_id' => $this->integer()->notNull(),
            'project_id' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-chat-author_id',
            'chat',
            'author_id',
            'user',
            'id'
        );

        $this->addForeignKey(
            'fk-chat-project_id',
            'chat',
            'project_id',
            'project',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-chat-author_id',
            'chat'
        );

        $this->dropForeignKey(
            'fk-chat-project_id',
            'chat'
        );

        $this->dropTable('{{%chat}}');
    }
}
