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
                'filter' =>  \dosamigos\datepicker\DateRangePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'date_from',
                    'attributeTo' => 'date_to',
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'dd-mm-yyyy'
                    ]
                ])
            ],
            [
                'attribute' => 'updated_at',
                'format' => ['date', 'php:d-m-Y H:i:s']
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>
</div>
