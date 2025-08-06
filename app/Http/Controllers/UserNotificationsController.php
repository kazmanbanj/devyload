<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserNotificationsController extends Controller
{
    public function index()
    {
        return auth()->user()->unreadNotifications;
    }

    public function destroy(User $user, $notificationId)
    {
        $user->notifications()->findOrFail($notificationId)->markAsRead();
    }
}
