<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserNotificationsController extends Controller
{
    public function index()
    {
        return auth()->user()->unreadNotifications;
        // dd(Auth::user()->unreadNotifications);
    }

    public function destroy(User $user, $notificationId)
    {
        auth()->user()->notifications()->findOrFail($notificationId)->markAsRead();
    }
}
