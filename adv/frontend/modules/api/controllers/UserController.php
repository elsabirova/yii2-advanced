<?php
namespace frontend\modules\api\controllers;

use frontend\modules\api\models\User;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;

class UserController extends ActiveController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::class,
        ];
        return $behaviors;
    }

    public $modelClass = User::class;
}
