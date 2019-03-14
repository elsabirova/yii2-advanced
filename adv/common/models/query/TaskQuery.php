<?php
namespace common\models\query;

use common\models\Task;

/**
 * This is the ActiveQuery class for [[\common\models\Task]].
 *
 * @see \common\models\Task
 */
class TaskQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @param $userId
     * @return TaskQuery
     */
    public function byUser($userId) {
        return $this->innerJoinWith(Task::RELATION_PROJECT_USERS)
            ->andWhere(['user_id' => $userId]);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Task[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Task|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }
}