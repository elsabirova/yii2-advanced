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
            [
                'attribute' => 'title',
                'format' => 'html',
                'value' => function (Project $model) {
                    return Html::a($model->title, ['view', 'id' => $model->id]);
                }
            ],
            'description:ntext',
            [
                'attribute' => 'active',
                'filter' => Project::STATUS_LABELS,
                'value' => function(Project $model) {
                    return Project::STATUS_LABELS[$model->active];
                }
            ],
            [
                'attribute' => Project::RELATION_CREATOR . '.username',
                'format' => 'html',
                'value' => function (Project $model) {
                    if ($model->creator) {
                        return Html::a($model->creator->username, ['user/view', 'id' => $model->creator->id]);
                    }
                    return null;
                }
            ],
            [
                'attribute' => Project::RELATION_UPDATER. '.username',
                'format' => 'html',
                'value' => function (Project $model) {
                    if ($model->updater) {
                        return Html::a($model->updater->username, ['user/view', 'id' => $model->updater->id]);
                    }
                    return null;
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
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{chat} {view} {update} {delete}',
                'buttons' => [
                    'chat' => function ($url, Project $model) {
                        $icon = \yii\bootstrap\Html::icon('envelope');
                        $url = ['project/chat', 'id' => $model->id];

                        return Html::a($icon, $url);
                    },
                ],
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
