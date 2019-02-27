<?php
namespace frontend\modules\api\models;

/**
 * {@inheritdoc}
 */
class Project extends \common\models\Project
{
    /**
     * {@inheritdoc}
     */
    public function getTasks() {
        return $this->hasMany(Task::class, ['project_id' => 'id']);
    }

    public function fields() {
        return ['id', 'title', 'active',
            'description_short' => function(Project $model){
                return substr($model->description, 0, 50);
        }];
    }

    public function extraFields() {
        return [self::RELATION_TASKS];
    }
}