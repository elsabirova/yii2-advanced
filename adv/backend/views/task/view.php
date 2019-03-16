<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Task;

/* @var $this yii\web\View */
/* @var $model common\models\Task */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="task-view">
    <p>
        <?php if (Yii::$app->taskService->canTake(Yii::$app->user->identity, $model->project, $model)): ?>
            <?= Html::a('Take', ['take', 'id' => $model->id], [
                'class' => 'btn btn-warning',
                'data' => [
                    'confirm' => 'Are you sure you want to take this task?',
                    'method' => 'post',
                ]]) ?>
        <?php endif; ?>
        <?php if (Yii::$app->taskService->canComplete(Yii::$app->user->identity, $model)): ?>
            <?= Html::a('Complete', ['complete', 'id' => $model->id], [
                'class' => 'btn btn-success',
                'data' => [
                    'confirm' => 'Are you sure you want to complete this task?',
                    'method' => 'post',
                ]
            ]) ?>
        <?php endif; ?>

        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'description:ntext',
            [
                'attribute' => Task::RELATION_PROJECT . '.title',
                'format' => 'html',
                'value' => function (Task $model) {
                    if ($model->project) {
                        return Html::a($model->project->title, ['project/view', 'id' => $model->project->id]);
                    }
                    return null;
                }
            ],
            [
                'attribute' => Task::RELATION_EXECUTOR . '.username',
                'format' => 'html',
                'value' => function (Task $model) {
                    if ($model->executor) {
                        return Html::a($model->executor->username, ['user/view', 'id' => $model->executor->id]);
                    }
                    return null;
                }
            ],
            'started_at:datetime',
            'completed_at:datetime',
            [
                'attribute' => Task::RELATION_CREATOR . '.username',
                'format' => 'html',
                'value' => function (Task $model) {
                    if ($model->creator) {
                        return Html::a($model->creator->username, ['user/view', 'id' => $model->creator->id]);
                    }
                    return null;
                }
            ],
            [
                'attribute' => Task::RELATION_UPDATER . '.username',
                'format' => 'html',
                'value' => function (Task $model) {
                    if ($model->updater) {
                        return Html::a($model->updater->username, ['user/view', 'id' => $model->updater->id]);
                    }
                    return null;
                }
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

    <?php echo \yii2mod\comments\widgets\Comment::widget([
        'model' => $model,
        'relatedTo' => 'User ' . \Yii::$app->user->identity->username . ' commented on the page ' . \yii\helpers\Url::current(),
        'dataProviderConfig' => [
            'pagination' => [
                'pageSize' => 10
            ],
        ],
        'listViewConfig' => [
            'emptyText' => Yii::t('app', 'No comments found.'),
        ],
    ]); ?>

</div>