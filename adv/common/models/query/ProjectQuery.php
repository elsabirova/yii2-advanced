<?php
namespace common\models\query;

use common\models\Project;

/**
 * This is the ActiveQuery class for [[\common\models\Project]].
 *
 * @see \common\models\Project
 */
class ProjectQuery extends \yii\db\ActiveQuery
{

    public function onlyActive()
    {
        return $this->andWhere(['active' => Project::STATUS_ACTIVE]);
    }

    /**
     * @param $userId
     * @param string|null $role
     * @return ProjectQuery
     */
    public function byUser($userId, $role = null)
    {
        $where = ['user_id' => $userId];
        if($role) {
            $where['role'] = $role;
        }
        return $this->innerJoinWith(Project::RELATION_PROJECT_USERS)
            ->andWhere($where);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Project[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Project|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
