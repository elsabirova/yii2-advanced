<?php
/* @var $this yii\web\View */
/* @var $listUsers \common\models\User[]*/
/* @var $model common\models\Project */

$this->title = 'Update project';
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="project-update">

    <?= $this->render('_form', [
        'model' => $model,
        'listUsers' => $listUsers,
    ]) ?>

</div>