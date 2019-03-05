<?php
use kartik\daterange\DateRangePicker;
use common\models\Project;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Projects';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-index">

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Project', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'title',
            'description:ntext',
            [
                'attribute' => 'active',
                'filter' => Project::STATUS_LABELS,
                'value' => function(Project $model) {
                    return Project::STATUS_LABELS[$model->active];
                }
            ],
            'creator.username',
            'updater.username',
            [
                'attribute' => 'created_at',
                'format' => ['datetime'],
                'filter' =>  DateRangePicker::widget([
                    //http://demos.krajee.com/date-range
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
                'format' => ['datetime'],
                'filter' =>  DateRangePicker::widget([
                    //http://demos.krajee.com/date-range
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
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
