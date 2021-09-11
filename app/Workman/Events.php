<?php

namespace App\Workman;

use GatewayWorker\Lib\Gateway;

class Events
{
    /**
     * 回调里面初始化一些全局数据
     * @param $businessWorker
     */
    public static function onWorkerStart($businessWorker)
    {
        echo "WorkerStart\n";
    }

    /**
     * 当客户端连接上gateway进程时(TCP三次握手完毕时)触发的回调函数
     * @param $client_id lient_id固定为20个字符的字符串，用来全局标记一个socket连接，每个客户端连接都会被分配一个全局唯一的client_id。
     */
    public static function onConnect($client_id)
    {
        Gateway::sendToCurrentClient(json_encode(['client_id' => $client_id, 'type' => 'connect']));
    }

    /**
     * 当客户端连接上gateway完成websocket握手时触发的回调函数。
     * @param $client_id
     * @param $data
     */
    public static function onWebSocketConnect($client_id, $data)
    {
    }

    /**
     * 当客户端发来数据(Gateway进程收到数据)后触发的回调函数
     * @param $client_id
     * @param $message
     * @return bool|string|void
     */
    public static function onMessage($client_id, $message)
    {
        //{type:say,content:msg,to_client_id:all or id}
        $message = json_decode($message, true);
        if (!$message) {
            return;
        }

        switch ($message['type']) {
            case 'pong':
                break;
            case 'login':
                $_SESSION['client_name'] = $message['client_name'];
                $_SESSION['room_id'] = $message['room_id'];
                $client_name = $message['client_name'];

                $clientList = Gateway::getClientSessionsByGroup($message['room_id']);
                foreach ($clientList as $index => $client) {
                    $clientList[$index] = $client['client_name'];
                }
                $clientList[$client_id] = $client_name;

                // 转播给当前房间的所有客户端，xx进入聊天室 message {type:login, client_id:xx, name:xx}
                $new_message = array('type' => $message['type'], 'client_id' => $client_id, 'client_name' => htmlspecialchars($client_name), 'time' => date('Y-m-d H:i:s'));
                Gateway::sendToGroup($_SESSION['room_id'], json_encode($new_message));
                Gateway::joinGroup($client_id, $_SESSION['room_id']);

                $new_message['client_list'] = $clientList;
                //Gateway::sendToCurrentClient(json_encode($new_message));
                return;

            case 'say':
                $client_name = $_SESSION['client_name'];
                if ($message['to_client_id'] && $message['to_client_id'] != 'all') {
                    $new_message = array(
                        'type' => 'say',
                        'from_client_id' => $client_id,
                        'from_client_name' => $client_name,
                        'to_client_id' => $message['to_client_id'],
                        'content' => "<b>对你说: </b>" . nl2br(htmlspecialchars($message['content'])),
                        'time' => date('Y-m-d H:i:s'),
                    );
                    Gateway::sendToClient($message['to_client_id'], json_encode($new_message));
                    $new_message['content'] = "<b>你对" . htmlspecialchars($message['to_client_name']) . "说: </b>" . nl2br(htmlspecialchars($message['content']));
                    return Gateway::sendToCurrentClient(json_encode($new_message));
                }
                $new_message = array(
                    'type' => 'say',
                    'from_client_id' => $client_id,
                    'from_client_name' => $client_name,
                    'to_client_id' => 'all',
                    'content' => nl2br(htmlspecialchars($message['content'])),
                    'time' => date('Y-m-d H:i:s'),
                );
                return Gateway::sendToGroup(1, json_encode($new_message));
            case 'room_say':
                $_SESSION['client_name'] = $message['client_name'];
                $_SESSION['room_id'] = $message['room_id'];
                $client_name = $message['client_name'];

                $clientList = Gateway::getClientSessionsByGroup($message['room_id']);
                foreach ($clientList as $index => $client) {
                    $clientList[$index] = $client['client_name'];
                }
                $clientList[$client_id] = $client_name;

                // 转播给当前房间的所有客户端，xx进入聊天室 message {type:login, client_id:xx, name:xx}
                $new_message = array('type' => $message['type'], 'client_id' => $client_id, 'client_name' => htmlspecialchars($client_name), 'content' => htmlspecialchars($message['content']), 'time' => date('Y-m-d H:i:s'));
                Gateway::sendToGroup($_SESSION['room_id'], json_encode($new_message));
                Gateway::joinGroup($client_id, $_SESSION['room_id']);

                $new_message['client_list'] = $clientList;
                //Gateway::sendToCurrentClient(json_encode($new_message));
        }
    }

    /**
     * 客户端与Gateway进程的连接断开时触发。不管是客户端主动断开还是服务端主动断开，都会触发这个回调。
     * @param $client_id
     */
    public static function onClose($client_id)
    {
        if (isset($_SESSION['room_id'])) {
            $room_id = $_SESSION['room_id'];
            $new_message = array('type' => 'logout', 'from_client_id' => $client_id, 'from_client_name' => $_SESSION['client_name'], 'time' => date('Y-m-d H:i:s'));
            Gateway::sendToGroup($room_id, json_encode($new_message));
        }

    }
}
