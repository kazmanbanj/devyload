<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use YlsIdeas\FeatureFlags\Facades\Features;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $featureThread = Features::accessible('new-thread');
// dd($featureThread);

        return view('home');
    }
}
