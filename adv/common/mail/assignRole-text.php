<?php
use common\models\ProjectUser;

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $project common\models\Project */
/* @var $role string */
?>

Hello <?= $user->username ?>,

You are assigned the role <?= ProjectUser::ROLE_LABELS[$role] ?> in the project  <?= $project->title ?>
