<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Log;


class PredictionController extends Controller
{
    public function predict(Request $request)
    {
        // Ambil data dari permintaan
        $data = $request->all();

        // Konversi nilai data menjadi bilangan bulat
        $data_int = [];
        foreach ($data as $value) {
            $data_int[] = (int) $value;
        }

        // Ubah data ke dalam format list
        $data_list = $data_int;

        // Buat instance dari Guzzle HTTP client
        $client = new Client();


        // Buat permintaan POST ke endpoint Flask
        $response = $client->post('http://localhost:5000/predict', [
            'json' => $data_list, // Mengirim data dalam format list
            'verify' => false
        ]);

        // Kembalikan respons dari endpoint Flask
        return $response->getBody();
    }
}
