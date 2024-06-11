<?php

namespace App\Http\Controllers;

use App\Models\Pencatatan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $lateCount = Pencatatan::where('p_piutang', 1)->count();
        $notLateCount = Pencatatan::where('p_piutang', 0)->count();
        return view('pencatatan.dashboard', ["late" => $lateCount, 'notLate' => $notLateCount]);
    }
}
