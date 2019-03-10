<?php
/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Profile: ' . $model->username;
$this->params['breadcrumbs'][] = 'Profile';
?>
<div class="user-profile">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
