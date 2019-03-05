<?php
use common\models\Project;
use common\models\ProjectUser;
use unclead\multipleinput\MultipleInput;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model Project */
/* @var $listUsers \common\models\User[]*/
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-form">

    <?php $form = ActiveForm::begin([
            'layout' => 'horizontal',
            'fieldConfig' => [
                'horizontalCssClasses' =>
                    ['label' => 'col-sm-2',]
            ],
    ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'active')->dropDownList(Project::STATUS_LABELS) ?>

    <?php if(!$model->isNewRecord): ?>
        <?= $form->field($model, Project::RELATION_PROJECT_USERS)->widget(MultipleInput::class, [
            //https://github.com/unclead/yii2-multiple-input/wiki/Usage
            'id' => 'project-users',
            'max' => 10,
            'min' => 0,
            'addButtonPosition' => MultipleInput::POS_HEADER,
            'columns' => [
                [
                    'name'  => 'project_id',
                    'type'  => 'hiddenInput',
                    'defaultValue' => $model->id,
                ],
                [
                    'name'  => 'user_id',
                    'type'  => 'dropDownList',
                    'title' => 'User',
                    'items' => $listUsers
                ],
                [
                    'name'  => 'role',
                    'title' => 'Role',
                    'type'  => 'dropDownList',
                    'items' => ProjectUser::ROLE_LABELS,
                ]
            ]
        ]);
        ?>
    <?php endif; ?>

    <div class="form-group">
        <div class="col-sm-2"></div>
        <div class="col-sm-6">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
