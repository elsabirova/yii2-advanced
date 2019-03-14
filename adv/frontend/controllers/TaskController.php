<?php
namespace frontend\controllers;

use Yii;
use common\models\Task;
use common\models\ProjectUser;
use common\models\query\TaskQuery;
use frontend\models\search\TaskSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function () {
                            $task = Task::findOne(Yii::$app->request->get('id'));

                            return Yii::$app->projectService->isProjectAvailable(Yii::$app->user->identity, $task->project);
                        },
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function () {
                            return Yii::$app->taskService->canManage(Yii::$app->user->identity);
                        }
                    ],
                    [
                        'actions' => ['update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function () {
                            $project = Task::findOne(Yii::$app->request->get('id'))->project;
                            return Yii::$app->taskService->canManage(Yii::$app->user->identity, $project);
                        }
                    ],
                    [
                        'actions' => ['take'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function () {
                            $task = Task::findOne(Yii::$app->request->get('id'));
                            $project = $task->project;
                            return Yii::$app->taskService->canTake(Yii::$app->user->identity, $project, $task);
                        }
                    ],
                    [
                        'actions' => ['complete'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function () {
                            $task = Task::findOne(Yii::$app->request->get('id'));
                            return Yii::$app->taskService->canComplete(Yii::$app->user->identity, $task);
                        }
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Task models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        /* @var $query TaskQuery */
        $query = $dataProvider->query;
        $query = $query->byUser(Yii::$app->user->identity->id);
        $dataProvider->query = $query;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Task model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Task model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Task();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'projectsNames' => Yii::$app->projectService->getAvailableProjects(Yii::$app->user->identity, ProjectUser::ROLE_MANAGER, true),
        ]);
    }

    /**
     * Updates an existing Task model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'projectsNames' => Yii::$app->projectService->getAvailableProjects(Yii::$app->user->identity, ProjectUser::ROLE_MANAGER, true),
        ]);
    }

    /**
     * Deletes an existing Task model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionTake($id) {
        $model = $this->findModel($id);
        if(Yii::$app->taskService->takeTask($model, Yii::$app->user->identity)) {
            Yii::$app->session->setFlash('success', 'Task is picked successfully');
            return $this->redirect(['view', 'id' => $id]);
        }
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionComplete($id) {
        $model = $this->findModel($id);
        if(Yii::$app->taskService->completeTask($model)) {
            Yii::$app->session->setFlash('success', 'Task is completed successfully');
            return $this->redirect(['view', 'id' => $id]);
        }
    }

    /**
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
