<?php
namespace common\modules\chat\widgets;

use common\modules\chat\assets\ChatAsset;
use yii\bootstrap\Widget;

class Chat extends Widget
{
    public $port = 8080;
    public $user;
    public $projectId;

    public function init() {
        ChatAsset::register($this->view);
    }

    public function run() {
        $this->view->registerJsVar('wsPort', $this->port);
        $this->view->registerJsVar('wsUserId', $this->user);
        $this->view->registerJsVar('wsProjectId', $this->projectId);

        $chat = \common\models\Chat::find()
            ->innerJoinWith(\common\models\Chat::RELATION_AUTHOR)
            ->where(['project_id' => $this->projectId])
            ->orderBy(['created_at' => SORT_DESC])->all();

        return $this->render('chat', [
            'chat' => $chat,
            'projectId' => $this->projectId
        ]);
    }
}