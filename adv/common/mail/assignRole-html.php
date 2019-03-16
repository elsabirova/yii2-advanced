<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\ProjectUser;

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $project common\models\Project */
/* @var $role string */
?>

<div>
    <p>Hello <?= Html::encode($user->username) ?>,</p>

    <p>You are assigned the role <?= Html::encode(ProjectUser::ROLE_LABELS[$role]) ?>
        in the project <?= Html::a($project->title, Url::to(['project/view', 'id' => $project->id], true)) ?></p>
</div>
