<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sales')->insert([
            ['name' => 'regular'],
            ['name' => 'e-catalog'],
            ['name' => 'in-health'],
        ]);

        DB::table('salesmans')->insert([
            ['code' => 74, 'name' => 'yonathan leonardo'],
            ['code' => 73, 'name' => 'hary budiman'],
            ['code' => 22, 'name' => 'prastio cahyo kartika'],
            ['code' => 70, 'name' => 'Deasy Amelia Sugiarti'],
            ['code' => 46, 'name' => 'stefanus soedinardjo'],
            ['code' => 77, 'name' => 'yusak triyanto'],
            ['code' => 63, 'name' => 'sugihartono'],
            ['code' => 34, 'name' => 'suwarno'],
            ['code' => 79, 'name' => 'achmad ainur rizal'],
            ['code' => 80, 'name' => 'awiyanto'],
            ['code' => 71, 'name' => 'muhammad fauzi wardhana'],
            ['code' => 76, 'name' => 'm. eko susanto'],
            ['code' => 69, 'name' => 'yuni rachmawati'],
            ['code' => 4, 'name' => 'geger harianto s.'],
            ['code' => 45, 'name' => 'kokok teguh'],
            ['code' => 68, 'name' => 'amilatatus solecha'],
            ['code' => 81, 'name' => 'fiki arifin'],
            ['code' => 59, 'name' => 'bagus eko budi santoso'],
            ['code' => 28, 'name' => 'muhammad ashari'],
            ['code' => 99999, 'name' => 'supervisor 1 (pak bagus)'],
            ['code' => 99991, 'name' => 'supervisor 7 (pak alan)'],
        ]);

        DB::table('customer_groups')->insert([
            ["code" => "MMK", "name" => "Modern Market", "id" => 1],
            ["code" => "APX", "name" => "Apotek", "id" => 2],
            ["code" => "RSS", "name" => "Hospital Swasta", "id" => 3],
            ["code" => "ACS", "name" => "Apotek Chain Store", "id" => 4],
            ["code" => "RSP", "name" => "Hospital Pemerintah", "id" => 5],
            ["code" => "PBF", "name" => "Pedagang Besar Farmasi", "id" => 6],
            ["code" => "TPD", "name" => "Toko / P & D", "id" => 7],
            ["code" => "RSK", "name" => "Klinik", "id" => 8],
            ["code" => "SPM", "name" => "Supermarket", "id" => 9],
            ["code" => "KLM", "name" => "Klaim to Principal", "id" => 10],
            ["code" => "KLP", "name" => "Klaim To Principal", "id" => 11],
            ["code" => "TKO", "name" => "Toko Obat", "id" => 12],
            ["code" => "PEM", "name" => "Pemerintah", "id" => 13],
            ["code" => "KTN", "name" => "Kantin / Salon", "id" => 14],
            ["code" => "EMP", "name" => "Employee", "id" => 15],
            ["code" => "PRG", "name" => "Perorangan", "id" => 16],
            ["code" => "PRC", "name" => "Principal", "id" => 17]
        ]);

        DB::table('territories')->insert([
            ["code" => 101101, "name" => "Sidoarjo"],
            ["code" => 100115, "name" => "Surabaya Tengah 2"],
            ["code" => 100102, "name" => "Surabaya Barat"],
            ["code" => 101202, "name" => "Waru"],
            ["code" => 100119, "name" => "Surabaya Utara Hospital"],
            ["code" => 100101, "name" => "Surabaya Timur 1"],
            ["code" => 100701, "name" => "Bojonegoro"],
            ["code" => 101502, "name" => "Gresik"],
            ["code" => 100601, "name" => "Probolinggo"],
            ["code" => 100104, "name" => "Surabaya Tengah 1"],
            ["code" => 100501, "name" => "Mojokerto"],
            ["code" => 101401, "name" => "Banyuwangi"],
            ["code" => 100803, "name" => "Pamekasan"],
            ["code" => 101301, "name" => "Jember 2"],
            ["code" => 100117, "name" => "Surabaya Timur Hospital"],
            ["code" => 100504, "name" => "Jombang"],
            ["code" => 100105, "name" => "Surabaya Selatan"],
            ["code" => 100103, "name" => "Surabaya Utara 1"],
            ["code" => 100901, "name" => "Jember 1"],
            ["code" => 100118, "name" => "Surabaya Utara 2"],
            ["code" => 100116, "name" => "Surabaya Timur 2"],
            ["code" => 101103, "name" => "Gedangan"],
            ["code" => 101501, "name" => "Lamongan"],
            ["code" => 100603, "name" => "Pasuruan"],
            ["code" => 100801, "name" => "Bangkalan"],
            ["code" => 100703, "name" => "Tuban"],
            ["code" => 100804, "name" => "Sumenep"],
            ["code" => 101302, "name" => "Lumajang"],
            ["code" => 101402, "name" => "Situbondo"],
            ["code" => 101203, "name" => "Sepanjang"],
            ["code" => 100903, "name" => "Bondowoso"],
            ["code" => 100802, "name" => "Sampang"],
            ["code" => 100503, "name" => "Mojosari"],
            ["code" => 101201, "name" => "Krian"],
            ["code" => 101102, "name" => "Porong"],
            ["code" => 100301, "name" => "*Madiun (Tdk Dipakai)"]
        ]);

        DB::table('pencatatans')->insert([
            

        ]);
    }
}
