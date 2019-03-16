<?php
/* @var $this yii\web\View */
/* @var $developer common\models\User */
/* @var $receiver common\models\User */
/* @var $project common\models\Project */
/* @var $task common\models\Task */
?>

Hello <?= $receiver->username ?>,

Developer <?= $developer->username ?> completed the task <?= $task->title ?> in the project <?= $project->title ?>