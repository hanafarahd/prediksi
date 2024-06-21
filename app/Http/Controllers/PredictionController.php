<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Log;


class PredictionController extends Controller
{
    public function predict(Request $req)
    {
        $exchange_freq = $req->exchange_freq;

        $formattedData = [
            "Type_Jual" => $req->sale_type,
            "Kode_Salesman" => $req->salesman_code,
            "Cust_Group" => $req->customer_group_id,
            "Kode_Territory" => $req->territory_code,
            "Invoice_Amount" => $req->invoice_amount,
            "Outstanding_AR" => $req->outstanding,
            "Frek_Tukar_Faktur" => $exchange_freq,
            "Frek_Tagih" => $req->bill_freq,
            "Ada_Garansi_Letter" => $req->guarantee_letter,
            "Due_Month" => $req->due_month,
            "Due_Day" => $req->due_day,
            "Due_Year" => $req->due_year,
            "Cutoff_Month" => $req->cutoff_month,
            "Cutoff_Day" => $req->cutoff_day,
            "Cutoff_Year" => $req->cutoff_year
        ];

        // Ambil data dari permintaan
        $data = $req->all();

        // Konversi nilai data menjadi bilangan bulat
        $data_int = [];
        foreach ($formattedData as $value) $data_int[] = (int) $value;

        // Ubah data ke dalam format list
        $data_list = $data_int;

        // Buat instance dari Guzzle HTTP client
        $client = new Client();

        $testUrl = 'https://t0zbz929-5000.asse.devtunnels.ms/';
        $url = 'http://localhost:5000/predict';

        // Buat permintaan POST ke endpoint Flask
        $response = $client->post($testUrl, [
            'json' => $data_list,
            'verify' => false
        ]);

        dd($response);


        // Kembalikan respons dari endpoint Flask
        return $response->getBody();
    }
}
