<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\User;

class ProfilesController extends Controller
{
    public function show(User $profileUser)
    {
        $activities = Activity::feed($profileUser);

        return view('profiles.show', compact('profileUser', 'activities'));
    }
}
