<?php
use common\modules\chat\widgets\Chat;

/* @var $this yii\web\View */
/* @var $model common\models\Project */

$this->title = 'Chat';
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="project-chat">

    <?= Chat::widget(['port' => 8081, 'user' => \Yii::$app->user->identity->id, 'projectId' => $model->id]);?>

</div>
