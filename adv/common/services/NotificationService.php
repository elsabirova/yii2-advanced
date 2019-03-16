<?php
namespace common\services;

use Yii;
use yii\base\Component;
use common\models\Project;
use common\models\Task;
use common\models\User;

class NotificationService extends Component
{
    public function sendInfoAboutNewRole(Project $project, User $user, $role) {
        $subject = "Add new role {$role}";
        $data = ['project' => $project, 'user' => $user, 'role' => $role];

        return Yii::$app->emailService->send($user->email, $subject, 'assignRole-html', 'assignRole-text', $data);
    }

    public function sendInfoAboutTakeTask(Task $task, Project $project, User $developer, array $receivers) {
        $subject = "Task {$task->title} was taken";

        foreach ($receivers as $receiver) {
            $data = ['task' => $task, 'project' => $project, 'developer' => $developer, 'receiver' => $receiver];
            Yii::$app->emailService->send($receiver->email, $subject, 'takeTask-html', 'takeTask-text', $data);
        }
    }

    public function sendInfoAboutCompleteTask(Task $task, Project $project, User $developer, array $receivers) {
        $subject = "Task {$task->title} was completed";

        foreach ($receivers as $receiver) {
            $data = ['task' => $task, 'project' => $project, 'developer' => $developer, 'receiver' => $receiver];
            Yii::$app->emailService->send($receiver->email, $subject, 'completeTask-html', 'completeTask-text', $data);
        }
    }
}