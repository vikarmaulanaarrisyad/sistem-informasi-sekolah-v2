<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->hasRole('admin')) {
            return view ('admin.dashboard.index');
        } else if (auth()->user()->hasRole('guru')) {
            return view ('guru.dashboard.index');
        }
    }
}
