<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserAvatarController extends Controller
{
    /**
     * Class constructor.
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function store()
    {
        $this->validate(request(), [
            'avatar' => ['required', 'image']
        ]);
        // dd(request()->file('avatar'));
        
        $user = User::where('id', auth()->user()->id)->first();

        $user->update([
            'avatar_path' => request()->file('avatar')->store('avatars', 'public')
        ]);

        return response([], 204);
    }
}
