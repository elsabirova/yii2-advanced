<?php
namespace common\services;

use Yii;
use yii\base\Component;
use common\models\Project;
use common\models\User;

class NotificationService extends Component
{
    public function sendInfoAboutNewRole(Project $project, User $user, $role)  {
        $subject = 'Add new role ' . $role;
        $data = ['project' => $project, 'user' => $user, 'role' => $role];

        return Yii::$app->emailService->send($user->email, $subject, 'assignRole-html', 'assignRole-text', $data);
    }
}