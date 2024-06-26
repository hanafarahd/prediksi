<?php

namespace App\Http\Controllers;

use App\Models\Pencatatan;

class HomeController extends Controller
{
    public function index()
    {
        $lateCount = Pencatatan::where('prediction', 'Terlambat')->count();
        $notLateCount = Pencatatan::where('prediction', 'Tidak Terlambat')->count();

        return view('pencatatan.dashboard', [
            "late" => $lateCount,
            'notLate' => $notLateCount
        ]);
    }
}
