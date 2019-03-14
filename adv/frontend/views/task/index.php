<?php
use kartik\daterange\DateRangePicker;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Task;
use common\models\ProjectUser;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\TaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tasks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>

    <?php if(Yii::$app->taskService->canManage(Yii::$app->user->identity)): ?>
        <p>
            <?= Html::a('Create Task', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php endif; ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'attribute' => 'title',
                'format' => 'html',
                'value' => function (Task $model) {
                    return Html::a($model->title, ['view', 'id' => $model->id]);
                }
            ],
            'description:ntext',
            [
                'attribute' => 'project_id',
                'filter' => Yii::$app->projectService->getAvailableProjects(Yii::$app->user->identity),
                'format' => 'html',
                'value' => function (Task $model) {
                    if ($model->project) {
                        return Html::a($model->project->title, ['project/view', 'id' => $model->project->id]);
                    }
                    return null;
                }
            ],
            [
                'attribute' => 'executor_id',
                'filter' => Yii::$app->taskService->getListUsers(Yii::$app->user->identity, ProjectUser::ROLE_DEVELOPER),
                'format' => 'html',
                'value' => function (Task $model) {
                    if ($model->executor) {
                        return Html::a($model->executor->username, ['user/view', 'id' => $model->executor->id]);
                    }
                    return null;
                }
            ],
            [
                'attribute' => 'started_at',
                'format' => ['datetime'],
                'filter' => DateRangePicker::widget([
                    //http://demos.krajee.com/date-range
                    'model' => $searchModel,
                    'attribute' => 'started_at',
                    'hideInput' => true,
                    'convertFormat' => true,
                    'pluginOptions' => [
                        'locale' => [
                            'format' => 'd-m-Y'
                        ],
                    ],
                ])
            ],
            [
                'attribute' => 'completed_at',
                'format' => ['datetime'],
                'filter' => DateRangePicker::widget([
                    //http://demos.krajee.com/date-range
                    'model' => $searchModel,
                    'attribute' => 'completed_at',
                    'hideInput' => true,
                    'convertFormat' => true,
                    'pluginOptions' => [
                        'locale' => [
                            'format' => 'd-m-Y'
                        ],
                    ],
                ])
            ],
            [
                'attribute' => 'creator_id',
                'filter' => Yii::$app->taskService->getListUsers(Yii::$app->user->identity, ProjectUser::ROLE_MANAGER),
                'format' => 'html',
                'value' => function (Task $model) {
                    if ($model->creator) {
                        return Html::a($model->creator->username, ['user/view', 'id' => $model->creator->id]);
                    }
                    return null;
                }
            ],
            [
                'attribute' => 'updater_id',
                'filter' => Yii::$app->taskService->getListUsers(Yii::$app->user->identity, ProjectUser::ROLE_MANAGER),
                'format' => 'html',
                'value' => function (Task $model) {
                    if ($model->updater) {
                        return Html::a($model->updater->username, ['user/view', 'id' => $model->updater->id]);
                    }
                    return null;
                }
            ],
            [
                'attribute' => 'created_at',
                'format' => ['datetime'],
                'filter' => DateRangePicker::widget([
                    //http://demos.krajee.com/date-range
                    'model' => $searchModel,
                    'attribute' => 'created_at',
                    'hideInput' => true,
                    'convertFormat' => true,
                    'pluginOptions' => [
                        'locale' => [
                            'format' => 'd-m-Y'
                        ]
                    ]
                ])
            ],
            [
                'attribute' => 'updated_at',
                'format' => ['datetime'],
                'filter' => DateRangePicker::widget([
                    //http://demos.krajee.com/date-range
                    'model' => $searchModel,
                    'attribute' => 'updated_at',
                    'hideInput' => true,
                    'convertFormat' => true,
                    'pluginOptions' => [
                        'locale' => [
                            'format' => 'd-m-Y'
                        ],
                    ],
                ]),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {take} {complete} {update} {delete}',
                'buttons' => [
                    'take' => function ($url, Task $model) {
                        $icon = \yii\bootstrap\Html::icon('pushpin');
                        $url = ['/task/take', 'id' => $model->id];

                        return Html::a($icon, $url, [
                            'data' => [
                                'confirm' => 'Are you sure you want to take this task?',
                                'method' => 'post',
                            ]
                        ]);
                    },
                    'complete' => function ($url, Task $model) {
                        $icon = \yii\bootstrap\Html::icon('ok');
                        $url = ['/task/complete', 'id' => $model->id];

                        return Html::a($icon, $url, [
                            'data' => [
                                'confirm' => 'Are you sure you want to complete this task?',
                                'method' => 'post',
                            ]
                        ]);
                    },
                ],
                'visibleButtons' => [
                    'take' => function (Task $model) {
                        return Yii::$app->taskService->canTake(Yii::$app->user->identity, $model->project, $model);
                    },
                    'complete' => function (Task $model) {
                        return Yii::$app->taskService->canComplete(Yii::$app->user->identity, $model);
                    },
                    'update' => function (Task $model) {
                        return Yii::$app->taskService->canManage(Yii::$app->user->identity, $model->project);
                    },
                    'delete' => function (Task $model) {
                        return Yii::$app->taskService->canManage(Yii::$app->user->identity, $model->project);
                    },
                ],
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>