<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Activity;

class ProfilesController extends Controller
{
    public function show($user)
    {
        $profileUser = User::where('name', $user)->first();
        $activities = Activity::feed($profileUser);

        return view('profiles.show', compact('profileUser', 'activities'));
    }
}
