<?php
namespace common\modules\chat\components;

use Yii;
use common\models\User;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use yii\base\Component;

class Chat extends Component implements MessageComponentInterface {
    protected $clients;
    public $projects;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

        $data = json_decode($msg);
        if(isset($data->setProjectId)) {
            $this->projects[$from->resourceId] = $data->setProjectId;
        } else {
            $date = time();
            $data->date = date("d-m-Y  H:i:s", $date);
            Yii::$app->db->open();

            $modelUser = User::findOne($data->authorId);
            $chat = new \common\models\Chat([
                'message' => $data->msg,
                'author_id' => $data->authorId,
                'project_id' => $data->projectId,
                'created_at' => $date,
            ]);
            $chat->save();

            Yii::$app->db->close();

            $data->avatar = $modelUser->getThumbUploadUrl('avatar', User::AVATAR_COMMENT);

            foreach ($this->clients as $client) {
                // The sender is the receiver
                if ($from === $client) {
                    $data->author = 'Me';
                }
                else {
                    $data->author = $modelUser->username;
                }
                //Send to clients with the same project
                if($this->projects[$client->resourceId] == $data->projectId) {
                    $client->send(json_encode($data));
                }
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}