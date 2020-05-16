<?php

namespace ChatApp;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Models\dialogModel;

class Chat implements MessageComponentInterface
{
    protected $clients;
    private $uidResources;
    private $users;
    private $dialogModel;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
        $this->uidResources = [];
        $this->users = [];
        $this->dialogModel = new dialogModel();
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        $this->users[$conn->resourceId] = $conn;
    }

    public function onMessage(ConnectionInterface $conn, $msg)
    {
        $data = json_decode($msg);
        switch ($data->command) {
            case "connect":
                $this->uidResources[$data->userId] = $conn->resourceId;
                break;
            case "message":
                $message = $this->dialogModel->sendMessage($data->fromId, $data->toId, $data->msg);
                $toId = $message['to']['id'];
                if (isset($this->uidResources[$toId])) {
                    foreach ($this->uidResources as $uid => $resourceId) {
                        if ($uid == $toId && $resourceId != $conn->resourceId) {
                            echo "\nОтправка '{$message['text']}' пользователю $toId от пользователя {$message['from']['id']}\n";
                            $this->users[$resourceId]->send(json_encode($message));
                        }
                    }
                }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        unset($this->users[$conn->resourceId]);
        unset($this->uidResources[$conn->resourceId]);
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "ERROR: {$e->getMessage()}\n";
        $conn->close();
    }
}
