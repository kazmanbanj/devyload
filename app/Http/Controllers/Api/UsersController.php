<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $search = $request['name'];

        return User::query()
            ->where('name', 'LIKE', "$search%")
            // ->take(5)
            ->pluck('name');
    }
}
