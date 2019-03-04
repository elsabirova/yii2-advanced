<?php
use common\models\User;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'username',
            'email:email',
            [
                'attribute' => 'avatar',
                'format' => 'html',
                'value' => function(User $model) {
                    return Html::img($model->getThumbUploadUrl('avatar', User::AVATAR_ICO), ['class' => 'img-thumbnail']);
                }
            ],
            [
                'attribute' => 'status',
                'filter' => User::STATUS_LABELS,
                'value' => function(User $model) {
                    return User::STATUS_LABELS[$model->status];
                }
            ],
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:d-m-Y H:i:s'],
                'filter' =>  \kartik\daterange\DateRangePicker::widget([
                    'model'=>$searchModel,
                    'attribute'=>'created_at',
                    'presetDropdown'=>true,
                    'hideInput'=>true,
                    'convertFormat'=>true,
                    'pluginOptions'=>[
                        'locale'=>[
                            'format'=>'d-m-Y'
                        ]
                    ]
                ])
            ],
            [
                'attribute' => 'updated_at',
                'format' => ['date', 'php:d-m-Y H:i:s'],
                'filter' =>  \kartik\daterange\DateRangePicker::widget([
                    'model'=>$searchModel,
                    'attribute'=>'updated_at',
                    'presetDropdown'=>true,
                    'hideInput'=>true,
                    'convertFormat'=>true,
                    'pluginOptions'=>[
                        'locale'=>[
                            'format'=>'d-m-Y'
                        ]
                    ]
                ])
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
