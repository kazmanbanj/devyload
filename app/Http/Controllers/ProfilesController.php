<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Thread;
use App\Models\Activity;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    public function show($user)
    {
        $profileUser = User::where('name', $user)->first();
        // dd($profileUser);
        $activities = Activity::feed($profileUser);

        return view('profiles.show', compact('profileUser', 'activities'));
    }
}
