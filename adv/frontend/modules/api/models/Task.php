<?php
namespace frontend\modules\api\models;

/**
 * {@inheritdoc}
 */
class Task extends \common\models\Task
{
    /**
     * {@inheritdoc}
     */
    public function getProject()
    {
        return $this->hasOne(Project::class, ['id' => 'project_id']);
    }

    public function fields() {
        return ['id', 'title',
            'description_short' => function (Task $model) {
                return substr($model->description, 0, 50);
            }];
    }

    public function extraFields() {
        return [self::RELATION_PROJECT];
    }
}