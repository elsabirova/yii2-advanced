<?php
namespace common\modules\chat\widgets;

use common\modules\chat\assets\ChatAsset;
use yii\bootstrap\Widget;

class Chat extends Widget
{
    public $port = 8080;
    public $user;

    public function init() {
        ChatAsset::register($this->view);
    }

    public function run() {
        $this->view->registerJsVar('wsPort', $this->port);
        $this->view->registerJsVar('wsUser', $this->user);
        return $this->render('chat');
    }
}