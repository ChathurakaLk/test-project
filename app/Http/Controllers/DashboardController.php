<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function studentPage()
    {
        return view('students.index');
    }
}
