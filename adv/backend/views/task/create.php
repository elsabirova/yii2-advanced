<?php
/* @var $this yii\web\View */
/* @var $model common\models\Task */
/* @var $projectsNames array */

$this->title = 'Create task';
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-create">

    <?= $this->render('_form', [
        'model' => $model,
        'projectsNames' => $projectsNames,
    ]) ?>

</div>