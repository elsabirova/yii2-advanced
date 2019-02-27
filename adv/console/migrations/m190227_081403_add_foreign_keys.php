<?php

use yii\db\Migration;

/**
 * Class m190227_081403_add_foreign_keys
 */
class m190227_081403_add_foreign_keys extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey(
            'fk-task-project_id',
            'task',
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
            'fk-task-project_id',
            'task'
        );
    }
}
