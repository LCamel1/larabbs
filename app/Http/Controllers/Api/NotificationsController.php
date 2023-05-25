<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\NotificationResource;

class NotificationsController extends Controller
{
    public function index(Request $request)
    {
        $notifications = $request->user()->notifications()->paginate();
        return NotificationResource::collection($notifications);
    }

    /**
     * 消息统计
     */
    public function stats(Request $request)
    {
        return responce()->json([
            'unread_count' => $request->user()->notification_count,
        ]);
    }

    /**
     * 标记为已读
     */
    public function read(Request $request)
    {
        $request->user()->markAsRead();
        return response(null, 204);
    }
}
