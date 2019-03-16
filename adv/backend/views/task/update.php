<?php
/* @var $this yii\web\View */
/* @var $model common\models\Task */
/* @var $projectsNames array */

$this->title = 'Update task';
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="task-update">

    <?= $this->render('_form', [
        'model' => $model,
        'projectsNames' => $projectsNames,
    ]) ?>

</div>