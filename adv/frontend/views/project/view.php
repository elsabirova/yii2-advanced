<?php
use common\models\Project;
use common\models\ProjectUser;
use common\models\User;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Project */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="project-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'description:ntext',
            [
                'attribute' => 'active',
                'value' => function (Project $model) {
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
                'attribute' => Project::RELATION_UPDATER . '.username',
                'format' => 'html',
                'value' => function (Project $model) {
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

    <h3>Users in project</h3>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => ProjectUser::RELATION_USER . '.username',
                'format' => 'html',
                'value' => function (ProjectUser $model) {
                    return Html::a($model->user->username, ['user/view', 'id' => $model->user->id]);
                }
            ],
            [
                'attribute' => 'avatar',
                'format' => 'html',
                'value' => function (ProjectUser $model) {
                    return Html::img($model->user->getThumbUploadUrl('avatar', User::AVATAR_ICO), ['class' => 'img-thumbnail']);
                }
            ],
            'role',
            'user.email:email',
        ],
    ]); ?>

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