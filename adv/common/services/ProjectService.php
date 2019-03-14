<?php
namespace common\services;

use common\models\Project;
use common\models\ProjectUser;
use common\models\User;
use yii\base\Component;
use yii\base\Event;

class AssignRoleEvent extends Event {
    public $project;
    public $user;
    public $role;

    public function dump() {
        return ['project_id' => $this->project->id, 'user_id' => $this->user->id, 'role' => $this->role];
    }
}

class ProjectService extends Component
{
    const EVENT_ASSIGN_ROLE = 'event_assign_role';

    /**
     * @param Project $project
     * @param User $user
     * @param $role
     */
    public function assignRole(Project $project, User $user, $role) {
        $event          = new AssignRoleEvent();
        $event->project = $project;
        $event->user    = $user;
        $event->role    = $role;

        $this->trigger(self::EVENT_ASSIGN_ROLE, $event);
    }

    /**
     * Returns a list of user roles in a specific project
     *
     * @param Project $project
     * @param User $user
     * @return array
     */
    public function getRoles(User $user, Project $project = null) {
        $where = ['user_id' => $user->id];
        if($project) {
            $where['project_id'] = $project->id;
        }

        return ProjectUser::find()->select('role')->where($where)->column();
    }

    /**
     * Checks if a user has a specific role in a project
     *
     * @param Project $project
     * @param User $user
     * @param $role
     * @return bool
     */
    public function hasRole(User $user, $role, Project $project = null) {
        return in_array($role, $this->getRoles($user, $project));
    }


    /**
     * @param User $user
     * @param string|null $role
     * @param bool $onlyActive
     * @return array
     */
    public function getAvailableProjects(User $user, string $role = null, bool $onlyActive = false) {
        $projects = Project::find()->select('title')->indexBy('id')->byUser($user->id, $role);
        if($onlyActive) {
            $projects->onlyActive();
        }

        return $projects->column();
    }

    /**
     * @return array
     */
    public function getActiveProjects() {
        return Project::find()->select('title')->onlyActive()
            ->indexBy('id')->column();
    }

    public function isProjectAvailable(User $user, Project $project) {
        return array_key_exists($project->id, $this->getAvailableProjects($user));
    }
}