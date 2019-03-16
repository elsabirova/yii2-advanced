<?php
use kartik\daterange\DateRangePicker;
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

    <?php Pjax::begin(); ?>
    <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'attribute' => 'username',
                'format' => 'html',
                'value' => function (User $model) {
                    return Html::a($model->username, ['view', 'id' => $model->id]);
                }
            ],
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
                'format' => ['datetime'],
                'filter' =>  DateRangePicker::widget([
                    //http://demos.krajee.com/date-range
                    'model'=>$searchModel,
                    'attribute'=>'created_at',
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
                'format' => ['datetime'],
                'filter' =>  DateRangePicker::widget([
                    //http://demos.krajee.com/date-range
                    'model'=>$searchModel,
                    'attribute'=>'updated_at',
                    'hideInput'=>true,
                    'convertFormat'=>true,
                    'pluginOptions'=>[
                        'locale'=>[
                            'format'=>'d-m-Y'
                        ]
                    ]
                ])
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>
</div>
