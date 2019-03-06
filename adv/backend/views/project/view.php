<?php
use common\models\Project;
use common\models\ProjectUser;
use common\models\User;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Project */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="project-view">

    <p>
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
                'attribute' => 'active',
                'value' => function(Project $model) {
                    return Project::STATUS_LABELS[$model->active];
                }
            ],
            'creator.username',
            'updater.username',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

    <h3>Users in project</h3>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'user.username',
            [
                'attribute' => 'avatar',
                'format' => 'html',
                'value' => function(ProjectUser $model) {
                    return Html::img($model->user->getThumbUploadUrl('avatar', User::AVATAR_ICO), ['class' => 'img-thumbnail']);
                }
            ],
            'role',
            'user.email:email',
            [
                'attribute' => 'status',
                'value' => function(ProjectUser $model) {
                    return User::STATUS_LABELS[$model->user->status];
                }
            ],
            'user.created_at:datetime',
            'user.updated_at:datetime'
        ],
    ]); ?>

</div>
