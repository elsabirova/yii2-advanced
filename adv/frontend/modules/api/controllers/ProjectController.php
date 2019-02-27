<?php
namespace frontend\modules\api\controllers;

use frontend\modules\api\models\Project;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;

class ProjectController extends ActiveController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::class,
        ];
        return $behaviors;
    }

    public $modelClass = Project::class;
}
