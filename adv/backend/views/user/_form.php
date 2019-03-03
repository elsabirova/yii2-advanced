<?php
use common\models\User;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

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

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'avatar')->fileInput(['accept' => 'image/*']) ?>

    <div class="form-group">
        <div class="col-sm-2"></div>
        <div class="col-sm-6">
            <?php if($model->avatar): ?>
                <?= Html::img($model->getThumbUploadUrl('avatar', User::AVATAR_PREVIEW), ['class' => 'img-thumbnail']) ?>
            <?php endif;?>
        </div>
    </div>

    <?= $form->field($model, 'status')->dropDownList(User::STATUS_LABELS) ?>

    <div class="form-group">
        <div class="col-sm-2"></div>
        <div class="col-sm-6">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
