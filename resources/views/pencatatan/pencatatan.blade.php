@extends('layouts.app')
@section('title', 'Pencatatan Data Piutang')
@section('content')
    <main>
        <div class="container-fluid px-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-4">Pencatatan Data Piutang</h5>
                    <a href="{{ url('/add-pencatatan') }}" class="btn btn-primary btn-sm mb-3">
                        <i class="ti ti-plus"></i> Tambah Pencatatan
                    </a>

                    <div class="card card-table">
                        <div class="card-body p-1">
                            <table class="table table-sm table-bordered table-striped text-center" id="myDatapencatatan">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th scope="col">Cut Off Date</th>
                                        <th scope="col">Invoice</th>
                                        <th scope="col">Due Date</th>
                                        <th scope="col">Trans Date</th>
                                        <th scope="col">Prediksi Piutang Customer</th>
                                        <th scope="col" class="no-sort">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pencatatan as $p)
                                        <tr>
                                            <td>{{ $p->cutoff_date }}</td>
                                            <td>{{ $p->invoice }}</td>
                                            <td>{{ $p->due_date }}</td>
                                            <td>{{ $p->trans_date }}</td>
                                            <td>{{ $p->p_piutang }}</td>

                                            <td>
                                                <a href="/delete-pencatatan/{{ $p->id }}"><button
                                                        class="btn btn2 btn-danger"><i
                                                            class="fas fa-trash-alt"></i></button></a>
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
