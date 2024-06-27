<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Pencatatan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;

class PencatatanController extends Controller
{
    public function index()
    {
        $pencatatan = DB::table('pencatatans')->get();

        return view('pencatatan.pencatatan', compact('pencatatan'));
    }

    public function addPencatatan()
    {
        $debts = DB::table('pencatatans')->get();


        return view('pencatatan.add-pencatatan', ['debts' => $debts]);
    }

    public function addInvoice()
    {
        $sales = DB::table('sales')->get();
        $salesmans = DB::table('salesmans')->get();
        $territories = DB::table('territories')->get();
        $customerGroups = DB::table('customer_groups')->get();

        return view('pencatatan.add-invoice', [
            'sales' => $sales,
            'salesmans' => $salesmans,
            'territories' => $territories,
            'customerGroups' => $customerGroups
        ]);
    }

    public function storeInvoice(Request $request)
    {
        try {
            DB::table('pencatatans')->insert([
                'invoice' => $request->invoice,
                'sale_type' => $request->sale_type,
                'salesman_code' => $request->salesman_code,
                'customer_group_id' => $request->customer_group_id,
                'territory_code' => $request->territory_code,
                'guarantee_letter' => $request->guarantee,
                'invoice_amount' => $request->invoice_amount,
                'outstanding' => $request->outstanding,
                'cutoff_date' => Carbon::now()->format('Y-m-d'),
                'due_date' => $request->due_date,
                'trans_date' => $request->trans_date,
                'exchange_freq' => $request->exchange_freq,
                'bill_freq' => $request->bill_freq,
                'created_at' => Carbon::now(),
            ]);

            return back()->with('success', 'Berhasil menambahkan Data Piutang.');
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            dd($errorMessage);
            return back()->with('error', 'Gagal menambahkan Data Piutang: Coba Lagi $errorMessage');
        }
    }

    public function input(Request $request,$id)
    {

        try {
            DB::table('pencatatans')->where('id', $id)->update([
                'prediction' => $request->p_piutang,
            ]);

            return redirect('/pencatatan')->with('success', 'Berhasil menambahkan Data Piutang.');
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            dd($errorMessage);

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
