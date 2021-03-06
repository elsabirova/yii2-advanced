<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%project_user}}`.
 */
class m190221_135030_create_project_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%project_user}}', [
            'id' => $this->primaryKey(),
            'project_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'role' => "enum('manager', 'developer', 'tester')",
        ]);

        $this->addForeignKey(
            'fk-project_user-user_id',
            'project_user',
            'user_id',
            'user',
            'id'
        );

        $this->addForeignKey(
            'fk-project_user-project_id',
            'project_user',
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
            'fk-project_user-user_id',
            'project_user'
        );

        $this->dropForeignKey(
            'fk-project_user-project_id',
            'project_user'
        );

        $this->dropTable('{{%project_user}}');
    }
}
