@extends('layouts.app')
@section('title', 'Pencatatan Data Piutang')
@section('content')
    <main>
        <div class="pt-3 px-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-4">Pencatatan Data Piutang</h5>
                    <a href="{{ url('/add-pencatatan') }}" class="btn btn-primary btn-sm mb-3">
                        <i class="ti ti-plus"></i> Tambah Pencatatan
                    </a>

                    <div class="overflow-auto" style="max-width: 100%; ">
                        <div class="card-body p-1 " style="width: 154.5%">
                            <table class="table table-responsive table-sm table-bordered table-striped text-center "
                                id="myDatapencatatan">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th scope="col">Invoice</th>
                                        <th scope="col">Tipe Jual</th>
                                        <th scope="col">Kode Salesman</th>
                                        <th scope="col">Kode Customer Group</th>
                                        <th scope="col">Kode Wilayah</th>
                                        <th scope="col">Garansi Letter</th>
                                        <th scope="col">Cut Off Date</th>
                                        <th scope="col">Due Date</th>
                                        <th scope="col">Trans Date</th>
                                        <th scope="col">Lama Transaksi</th>
                                        <th scope="col">Lama Jatuh Tempo</th>
                                        <th scope="col">Frekuensi Tukar</th>
                                        <th scope="col">Frekuensi Tagih</th>
                                        <th scope="col">Nilai Piutang</th>
                                        <th scope="col">Outstanding</th>
                                        <th scope="col">Prediksi </th>
                                        <th scope="col" class="no-sort">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($pencatatan as $p)
                                        @php
                                            $cutoffDate = $p->cutoff_date
                                                ? Carbon\Carbon::parse($p->cutoff_date)
                                                : null;
                                            $transDate = $p->trans_date ? Carbon\Carbon::parse($p->trans_date) : null;
                                            $dueDate = $p->due_date ? Carbon\Carbon::parse($p->due_date) : null;

                                            $lamaTransaksi =
                                                $cutoffDate && $transDate ? $cutoffDate->diffInDays($transDate) : null;
                                            $lamaJatuhTempo =
                                                $dueDate && $cutoffDate
                                                    ? $dueDate->diffInDays($cutoffDate, false)
                                                    : null;
                                        @endphp
                                        <tr class="text-capitalize">
                                            <td class="align-middle">{{ $p->invoice }}</td>
                                            <td class="align-middle">{{ $p->sale_type }}</td>
                                            <td class="align-middle">{{ $p->salesman_code }}</td>
                                            <td class="align-middle">{{ $p->customer_group_id }}</td>
                                            <td class="align-middle">{{ $p->territory_code }}</td>
                                            <td class="align-middle">{{ $p->guarantee_letter }}</td>
                                            <td class="align-middle">{{ $p->cutoff_date }}</td>
                                            <td class="align-middle">{{ $p->due_date }}</td>
                                            <td class="align-middle">{{ $p->trans_date }}</td>
                                            <td class="align-middle">{{ $lamaTransaksi }}</td>
                                            <td class="align-middle">{{ $lamaJatuhTempo }}</td>

                                            <td class="align-middle">{{ $p->exchange_freq }}</td>
                                            <td class="align-middle">{{ $p->bill_freq }}</td>

                                            <td class="align-middle">{{ number_format($p->invoice_amount, 0, '.') }}</td>
                                            <td class="align-middle">{{ number_format($p->outstanding, 0, '.') }}</td>
                                            <td class="align-middle">{{ $p->prediction ?? 'Prediksi Belum Ada' }}</td>
                                            <td class="align-middle">
                                                <a href="/delete-pencatatan/{{ $p->id }}">
                                                    <button class="btn btn2 btn-danger">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>
@endsection
