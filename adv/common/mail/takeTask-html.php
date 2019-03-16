<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $developer common\models\User */
/* @var $receiver common\models\User */
/* @var $project common\models\Project */
/* @var $task common\models\Task */
?>

<div>
    <p>Hello <?= Html::encode($receiver->username) ?>,</p>

    <p>Developer <?= Html::a($developer->username, Url::to(['user/view', 'id' => $developer->id], true)) ?>
        took the task <?= Html::a($task->title, Url::to(['task/view', 'id' => $task->id], true)) ?>
        in the project <?= Html::a($project->title, Url::to(['project/view', 'id' => $project->id], true)) ?> </p>
</div>