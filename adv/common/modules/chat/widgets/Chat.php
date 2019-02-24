<?php
namespace common\modules\chat\widgets;

use common\modules\chat\assets\ChatAsset;
use yii\bootstrap\Widget;

class Chat extends Widget
{
    public $port = 8080;

    public  function init() {
        ChatAsset::register($this->view);
    }

    public function run() {
        $this->view->registerJsVar('wsPort', $this->port);
        return $this->render('chat');
    }
}