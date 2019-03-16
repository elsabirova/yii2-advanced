<?php

namespace common\services;

use Yii;
use common\models\Project;
use common\models\ProjectUser;
use common\models\Task;
use common\models\User;
use yii\base\Component;
use yii\base\Event;

class AfterTakeTaskEvent extends Event
{
    public $task;
    public $project;
    public $developer;
    public $receivers;
}

class AfterCompleteTaskEvent extends Event
{
    public $task;
    public $project;
    public $developer;
    public $receivers;
}

class TaskService extends Component
{
    const EVENT_AFTER_TAKE_TASK = 'event_take_task';
    const EVENT_AFTER_COMPLETE_TASK = 'event_complete_task';

    /**
     * @param Task $task
     * @param Project $project
     * @param User $developer
     * @param array $receivers
     */
    public function afterTakeTask(Task $task, Project $project, User $developer, array $receivers) {
        $event = new AfterTakeTaskEvent();
        $event->task = $task;
        $event->project = $project;
        $event->developer = $developer;
        $event->receivers = $receivers;

        $this->trigger(self::EVENT_AFTER_TAKE_TASK, $event);
    }

    /**
     * @param Task $task
     * @param Project $project
     * @param User $developer
     * @param array $receivers
     */
    public function afterCompleteTask(Task $task, Project $project, User $developer, array $receivers) {
        $event = new AfterCompleteTaskEvent();
        $event->task = $task;
        $event->project = $project;
        $event->developer = $developer;
        $event->receivers = $receivers;

        $this->trigger(self::EVENT_AFTER_COMPLETE_TASK, $event);
    }

    /**
     * @param User $user
     * @param Project|null $project
     * @return bool
     */
    public function canManage(User $user, Project $project = null) {
        return Yii::$app->projectService->hasRole($user, ProjectUser::ROLE_MANAGER, $project);
    }

    /**
     * @param User $user
     * @param Project $project
     * @param Task $task
     * @return bool
     */
    public function canTake(User $user, Project $project, Task $task) {
        if (!$task->executor_id && Yii::$app->projectService->hasRole($user, ProjectUser::ROLE_DEVELOPER, $project)) {
            return true;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Task $task
     * @return bool
     */
    public function canComplete(User $user, Task $task) {
        if ($task->executor_id === $user->id && !$task->completed_at) {
            return true;
        }

        return false;
    }

    /**
     * @param Task $task
     * @param User $user
     * @return bool
     */
    public function takeTask(Task $task, User $user) {
        $task->executor_id = $user->id;
        $task->started_at = time();

        $result = $task->save();
        if ($result) {
            $receivers = $this->getReceivers($task->project->id, ProjectUser::ROLE_MANAGER);
            if (!empty($receivers)) {
                $this->afterTakeTask($task, $task->project, $user, $receivers);
            }

            Yii::$app->session->setFlash('success', 'Task is picked successfully');
        }
        return $result;
    }

    /**
     * @param Task $task
     * @param User $user
     * @return bool
     */
    public function completeTask(Task $task, User $user) {
        $task->completed_at = time();

        $result = $task->save();
        if ($result) {
            $roles = [ProjectUser::ROLE_MANAGER, ProjectUser::ROLE_TESTER];
            $receivers = $this->getReceivers($task->project->id, $roles);

            if (!empty($receivers)) {
                $this->afterCompleteTask($task, $task->project, $user, $receivers);
            }

            Yii::$app->session->setFlash('success', 'Task is completed successfully');
        }
        return $result;
    }

    /**
     * @param int $projectId
     * @param $roles
     * @return array|User[]
     */
    public function getReceivers(int $projectId, $roles) {
        return User::find()
            ->byProject($projectId)
            ->byRole($roles, false)->all();
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
        if ($user) {
            $listUsers->workInProjectsWithUser($user->id);
        }

        if ($role) {
            $listUsers->byRole($role, false);
        }

        if ($onlyActive) {
            $listUsers->onlyActive();
        }

        return $listUsers->column();
    }
}