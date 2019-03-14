<?php
namespace common\services;

use Yii;
use common\models\Project;
use common\models\ProjectUser;
use common\models\Task;
use common\models\User;
use yii\base\Component;

class TaskService extends Component
{
    public function canManage(User $user, Project $project = null) {
        return Yii::$app->projectService->hasRole($user, ProjectUser::ROLE_MANAGER, $project);
    }

    public function canTake(User $user, Project $project, Task $task) {
        if(!$task->executor_id && Yii::$app->projectService->hasRole($user, ProjectUser::ROLE_DEVELOPER, $project)) {
            return true;
        }

        return false;
    }

    public function canComplete(User $user, Task $task) {
        if($task->executor_id === $user->id && !$task->completed_at) {
            return true;
        }

        return false;
    }

    public function takeTask(Task $task, User $user) {
        $task->executor_id = $user->id;
        $task->started_at = time();

        return $task->save();
    }

    public function completeTask(Task $task) {
        $task->completed_at = time();

        return $task->save();
    }

    /**
     * List of users
     *
     * @param User $user
     * @param string|null $role
     * @param bool $onlyActive
     * @return array
     */
    public function getListUsers(User $user = null, string $role = null, bool $onlyActive = true) {
        $listUsers = User::find()->select('username')->indexBy('id');
        if($user) {
            $listUsers->workInProjectsWithUser($user->id);
        }

        if($role) {
            $listUsers->byRole($role, false);
        }

        if($onlyActive) {
            $listUsers->onlyActive();
        }

        return $listUsers->column();
    }
}