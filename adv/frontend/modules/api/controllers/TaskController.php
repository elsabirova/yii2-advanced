<?php
namespace frontend\modules\api\controllers;

use frontend\modules\api\models\Task;
use yii\data\ActiveDataProvider;
use yii\filters\auth\QueryParamAuth;
use yii\helpers\Url;
use yii\rest\Controller;
use yii\web\ServerErrorHttpException;

class TaskController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::class,
        ];
        return $behaviors;
    }

    /**
     * Lists all tasks
     *
     * @return ActiveDataProvider
     */
    public function actionIndex()
    {
        return new ActiveDataProvider([
            'query' => Task::find(),
        ]);
    }

    /**
     * Displays a single Task
     *
     * @param $id
     * @return Task|null
     */
    public function actionView($id)
    {
        return Task::findOne($id);
    }

    /**
     * Creates a new Task
     *
     * @return Task
     * @throws ServerErrorHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionCreate()
    {
        $model = new Task();
        $model->load(\Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->save()) {
            $response = \Yii::$app->getResponse();
            $response->setStatusCode(201);
            $id = $model->getPrimaryKey();
            $response->getHeaders()->set('Location', Url::toRoute(['view', 'id' => $id], true));
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the task');
        }

        return $model;
    }

    /**
     * Updates an existing Task
     *
     * @param $id
     * @return Task|null
     * @throws ServerErrorHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionUpdate($id)
    {
        $model = Task::findOne($id);
        $model->load(\Yii::$app->getRequest()->getBodyParams(), '');

        if ($model->save() === false && !$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to update the task');
        }

        return $model;
    }

    /**
     * Deletes an existing Task
     *
     * @param $id
     * @return false|int
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $result = Task::findOne($id)->delete();
        if ($result === false) {
            throw new ServerErrorHttpException('Failed to delete the task.');
        }

        return $result;
    }
}
