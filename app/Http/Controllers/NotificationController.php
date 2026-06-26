<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Notification;
class NotificationController extends Controller
{

public function markAsRead()
{
    Notification::where('user_id', Auth::id())
        ->where('is_read', false)
        ->update(['is_read' => true]);

    return back();
}
}
