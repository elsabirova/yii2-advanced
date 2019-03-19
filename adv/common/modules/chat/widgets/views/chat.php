<?php
use yii\bootstrap\Html;
use common\models\User;

/* @var $chat \common\models\Chat */
/* @var $projectId int */
?>

<input class="chat-message" type="text" placeholder="Enter your message">
<?= Html::button('Send', ['class' => 'chat-message-send btn btn-primary']);?>

<div id="chat-area">
    <?php foreach ($chat as $c): ?>
        <div class="chat-img pull-left">
            <img src="<?= $c->author->getThumbUploadUrl('avatar', User::AVATAR_COMMENT)?>" class="img-circle" alt="user image"/>
        </div>
        <div class="chat-author"><?= ($c->author->id == Yii::$app->user->identity->id) ? 'Me' : $c->author->username?> <span class="chat-time"><i class="fa fa-clock-o"></i><?= date("d-m-Y  H:i:s", $c->created_at)?></span></div>
        <div><?= $c->message?></div>
    <?php endforeach; ?>
</div>