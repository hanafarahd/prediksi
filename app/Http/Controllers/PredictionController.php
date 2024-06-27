<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class PredictionController extends Controller
{
    public function predict(Request $req)
    {
        $exchange_freq = $req->exchange_freq;
        $outstanding = intval($req->outstanding);
        $invoice_amount = intval($req->invoice_amount);

        $cutoffDate = Carbon::parse($req->cutoff_date);
        $dueDate = Carbon::parse($req->due_date);
        $transDate = Carbon::parse($req->trans_date);

        if ($invoice_amount >= 200 && $invoice_amount <= 394253) $invoice_amount = 0;
        elseif ($invoice_amount >= 394254 && $invoice_amount <= 769896) $invoice_amount = 1;
        elseif ($invoice_amount >= 769897 && $invoice_amount <= 1946398) $invoice_amount = 2;
        elseif ($invoice_amount >= 1946399 && $invoice_amount <= 965216862) $invoice_amount = 3;

        if ($outstanding >= 0 && $outstanding <= 281710) $outstanding = 0;
        elseif ($outstanding >= 281711 && $outstanding <= 616852) $outstanding = 1;
        elseif ($outstanding >= 616853 && $outstanding <= 1572134) $outstanding = 2;
        elseif ($outstanding >= 1572135 && $outstanding <= 550544183) $outstanding = 3;
       
        $lamaTransaksi = $cutoffDate->diffInDays($transDate);
        $lamaJatuhTempo = $dueDate->diffInDays($cutoffDate, false);

        $formattedData = [
            "Type_Jual" => $req->sale_type,
            "Kode_Salesman" => $req->salesman_code,
            "Cust_Group" => $req->customer_group_id,
            "Kode_Territory" => $req->territory_code,
            "Invoice_Amount" => $invoice_amount,
            "Outstanding_AR" => $outstanding,
            "Frek_Tukar_Faktur" => $exchange_freq,
            "Frek_Tagih" => $req->bill_freq,
            "Ada_Garansi_Letter" => $req->guarantee_letter,
            'Lama_Transaksi' => $lamaTransaksi,
            'Lama_Jatuh_Tempo' => $lamaJatuhTempo,
        ];

        // Konversi nilai data menjadi bilangan bulat
        // $data_int = [];
        // foreach ($formattedData as $value) $data_int[] = (int) $value;

        // Ubah data ke dalam format list
        // $data_list = $data_int;

        // return response()->json($data_list);

        // Buat instance dari Guzzle HTTP client
        $client = new Client();

        // $url = 'https://t0zbz929-5000.asse.devtunnels.ms/';
        $url = 'http://localhost:5000/predict';

        // Buat permintaan POST ke endpoint Flask
        $response = $client->post($url, [
            'json' => $formattedData,
            'verify' => false
        ]);

        // Kembalikan respons dari endpoint Flask
        return $response->getBody();
    }
}
