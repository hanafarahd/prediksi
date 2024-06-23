<?php

namespace App\Http\Controllers;

use App\Models\Pencatatan;

class HomeController extends Controller
{
    public function index()
    {
        $lateCount = Pencatatan::where('prediction', 1)->count();
        $notLateCount = Pencatatan::where('prediction', 0)->count();
        return view('pencatatan.dashboard', ["late" => $lateCount, 'notLate' => $notLateCount]);
    }
}
