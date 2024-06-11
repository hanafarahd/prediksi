<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Pencatatan;
use Database\Seeders\PencatatanSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class PencatatanController extends Controller
{
    public function index()
    {
        $pencatatan = DB::table('pencatatans')->get();
        return view('pencatatan.pencatatan', compact('pencatatan'));
    }

    public function addPencatatan()
    {
        $piutang = DB::table('pencatatans')->select('id', 'cutoff_date', 'invoice', 'due_date', 'trans_date', 'p_piutang')->get();

        return view('pencatatan.add-pencatatan', ['piutang' => $piutang]);
    }

    public function addInvoice()
    {
        return view('pencatatan.add-invoice');
    }

    public function storeInvoice(Request $request)
    {
        // dd($request->all());
        try {
            DB::table('pencatatans')->insert([
                'invoice' => $request->invoice,
                'cutoff_date' => Carbon::now()->format('Y-m-d'),
                'due_date' => $request->due_date,
                'trans_date' => $request->trans_date,
                'created_at' => Carbon::now(),
            ]);

            return back()->with('success', 'Berhasil menambahkan Data Piutang.');
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            dd($errorMessage);
            return back()->with('error', 'Gagal menambahkan Data Piutang: Coba Lagi $errorMessage');
        }
    }

    public function input(Request $request, $id)
    {
        try {
            DB::table('pencatatans')->where('id', )->update([               
                'p_piutang' => $request->p_piutang,
            ]);

            return redirect('/pencatatan')->with('success', 'Berhasil menambahkan Data Piutang.');
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            // dd($errorMessage);
            return redirect('/pencatatan')->with('error', 'Gagal menambahkan Data Piutang: Coba Lagi $errorMessage');
        }
    }

    public function detail($id)
    {
        $decryptedId = decrypt($id);
        $pencatatan = Pencatatan::find($decryptedId);

        if (!$pencatatan) {
            return abort(404);
        }

        return view('pencatatan.detail-pencatatan', compact('pencatatan'));
    }

    public function update(Request $request, $id)
    {
        try {
            // return $request;
            $decryptedId = decrypt($id);
            $pencatatan = Pencatatan::find($decryptedId);

            if (!$pencatatan) {
                return abort(404);
            }
            DB::table('pencatatans')->where('id', $decryptedId)->update([
                'cutoff_date' => $request->cutoff_date,
                'invoice' => $request->invoice,
                'due_date' => $request->due_date,
                'trans_date' => $request->trans_date,
                'p_piutang' => $request->p_piutang,
                'updated_at' => Carbon::now(),
            ]);
            return redirect('/pencatatan')->with('success', 'Berhasil edit Piutang.');
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return abort(500, 'Error: Unable to decrypt the ID.');
        }
    }

    public function delete($id)
    {
        try {

            // Find the record and delete it
            $pencatatan = Pencatatan::findOrFail($id);
            $pencatatan->delete();

            return redirect('/pencatatan')->with('success', 'Berhasil hapus Piutang.');
        } catch (QueryException $e) {
            return redirect('/pencatatan')->with('error', 'Gagal hapus Piutang: ' . $e->getMessage());
        }
    }
}
