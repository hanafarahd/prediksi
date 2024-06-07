@extends('layouts.app')
@section('title', 'Tambah Pencatatan')
@section('content')

    <div class="container-fluid">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-4">
                        <a href="{{ '/pencatatan' }}"></a>
                        <b class="mx-2">
                            Tambah Invoice
                        </b>
                    </h5>
                    <div class="card">
                        <div class="card-body">
                            <form id="myForm" method="POST" action="/add-invoice/store" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="row">
                                    <h5 class="mb-4 text-center"><b>Data Piutang</b></h5>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="cutoff_date" class="form-label">
                                                Cut Off Date <label class="text-red">*</label>
                                            </label>
                                            <input type="date" class="form-control" id="cutoff_date" name="cutoff_date"
                                                value="{{ now()->toDateString() }}" required disabled>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="invoice" class="form-label">
                                                Invoice
                                                <label class="text-red">*</label>
                                            </label>
                                            <input type="text" class="form-control" id="invoiceOnlyNumber"
                                                onkeypress="return isNumber(event)" name="invoice"
                                                placeholder="Masukkan Nomor Invoice" required>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="due_date" class="form-label">
                                                Due Date
                                                <label class="text-red">*</label>
                                            </label>
                                            <input type="date" class="form-control" id="due_date" name="due_date">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="trans_date" class="form-label">
                                                Trans Date
                                                <label class="text-red">*</label>
                                            </label>
                                            <input type="date" class="form-control" id="trans_date" name="trans_date">
                                        </div>
                                    </div>
                                </div>

                                <button class="btn btn-danger mt-3">Simpan Invoice</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const isNumber = (evt) => /\d/.test(evt.key);

        function sendColab(e) {
            e.preventDefault();

            Swal.fire({
                title: "Simpan Invoice ?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya",
                cancelButtonText: "Tidak"
            }).then((result) => result.isConfirmed && document.getElementById('myForm').submit());
        }
    </script>

@endsection
