<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Transformers\NotificationTransformer;

class NotificationsController extends Controller
{
    /**
     * 消息提醒
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        $notifications = $this->user->notifications()->paginate(20);

        return $this->response->paginator($notifications, new NotificationTransformer());
    }

    /**
     * 消息数统计
     * @return mixed
     */
    public function stats()
    {
        return $this->response->array([
            'unread_count' => $this->user()->notification_count,
        ]);
    }

    /**将消息标为已读
     * @return \Dingo\Api\Http\Response
     */
    public function read()
    {
        $this->user()->markAsRead();

        return $this->response->noContent();
    }
}
