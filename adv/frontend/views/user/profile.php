<?php
use common\models\User;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Profile: ' . $model->username;
$this->params['breadcrumbs'][] = 'Profile';
?>

<div class="user-profile">

    <div class="user-form">

        <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data'],
            'layout' => 'horizontal',
            'fieldConfig' => [
                'horizontalCssClasses' =>
                    ['label' => 'col-sm-2',]
            ],
        ]); ?>

        <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'avatar')->fileInput(['accept' => 'image/*']) ?>

        <div class="form-group">
            <div class="col-sm-2"></div>
            <div class="col-sm-6">
                <?php if($model->avatar): ?>
                    <?= Html::img($model->getThumbUploadUrl('avatar', User::AVATAR_PREVIEW), ['class' => 'img-thumbnail']) ?>
                <?php endif;?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-2"></div>
            <div class="col-sm-6">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
