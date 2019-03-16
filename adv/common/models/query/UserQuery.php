<?php
namespace common\models\query;

use common\models\Project;
use common\models\ProjectUser;
use common\models\User;

/**
 * This is the ActiveQuery class for [[\common\models\User]].
 *
 * @see \common\models\User
 */
class UserQuery extends \yii\db\ActiveQuery
{
    public function onlyActive()
    {
        return $this->andWhere(['status' => User::STATUS_ACTIVE]);
    }

    /**
     * @param int $userId
     * @return UserQuery
     */
    public function workInProjectsWithUser(int $userId)
    {
        $userProjects = ProjectUser::find()->select('project_id')->andWhere(['user_id' => $userId]);

        return $this->innerJoinWith(User::RELATION_PROJECT_USERS)
            ->andWhere(['project_id' => $userProjects]);
    }

    /**
     * @param int $projectId
     * @return UserQuery
     */
    public function byProject(int $projectId)
    {
        return $this->innerJoinWith(User::RELATION_PROJECT_USERS)->andWhere(['project_id' => $projectId]);
    }

    /**
     * @param string|array $roles
     * @param bool $joinProjectUser
     * @return UserQuery
     */
    public function byRole($roles, $joinProjectUser = true)
    {
        if(is_array($roles)) {
            $where = "role = '" . implode("' or role = '", $roles) . "'";
            $result = $this->andWhere($where);
        }
        else {
            $result = $this->andWhere(['role' => $roles]);
        }

        if($joinProjectUser) {
            $result = $result->innerJoinWith(User::RELATION_PROJECT_USERS);
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     * @return \common\models\User[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\User|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
