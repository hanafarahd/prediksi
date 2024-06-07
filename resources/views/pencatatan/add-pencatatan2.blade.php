@extends('layouts.app')
@section('title', 'Tambah Pencatatan')
@section('content')
    <div class="container-fluid">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-4"><a href="{{ '/pencatatan' }}"><button class="btn btn2 btn-primary"><i
                                    class="ti ti-arrow-left"></i></button></a> <b class="mx-2">Tambah Pencatatan</b>
                    </h5>
                    <div class="card">
                        <div class="card-body">
                            <form id="myForm" method="POST" action="/add-pencatatan/store"
                                enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="row">
                                    <h5 class="mb-4 text-center"><b>Data Piutang</b></h5>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="cutoff_date" class="form-label">Cut Off Date <label
                                                    class="text-red">*</label></label>
                                            <input type="date" class="form-control" id="cutoff_date" name="cutoff_date"
                                                value="{{ now()->toDateString() }}" required disabled>
                                            <input type="date" class="form-control" value="{{ now()->toDateString() }}"
                                                id="cutoff_date" name="cutoff_date" required hidden>

                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="invoice" class="form-label">Invoice<label class="text-red">*</label></label>
                                            <select class="form-control" id="invoice"
                                                name="invoice" required>
                                                <option value=""  selected>Pilih Invoice</option>
                                                @foreach ($piutang as $item)
                                                    <option value="{{ $item->id }}">
                                                        {{ $item->invoice }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="validation" style="color:red;"></span>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="due_date" class="form-label">Due Date<label
                                                    class="text-red">*</label></label>
                                            <input type="date" class="form-control" id="due_date" name="due_date">
                                            <span class="validation" style="color:red;"></span>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="trans_date" class="form-label">Trans Date<label
                                                    class="text-red">*</label></label>
                                            <input type="date" class="form-control" id="trans_date" name="trans_date">
                                            <span class="validation" style="color:red;"></span>
                                        </div>
                                    </div>
                                </div>
                                <h1 id="hasil_prediksi">HASIL DISINI</h1>
                                <button class="btn btn-danger mt-3" type="button" onclick="sendColab()">Tampilkan Hasil
                                    Prediksi</button>

                                <div class="row" style="display:none; " id="hiddenRow" onclick="shownAfterClick()">
                                    <div class="col-sm-12">
                                        <div class="col-sm-12 mt-3">
                                            <div class="mb-3">
                                                <label for="p_piutang" class="form-label">Prediksi Piutang<label
                                                        class="text-red">*</label></label>
                                                <input type="text" class="form-control hasil-prediksi"
                                                    id="p_piutang_display" value="" name="p_piutang_display" required
                                                    disabled>
                                                <input type="hidden" class="form-control hasil-prediksi" id="p_piutang"
                                                    value="" name="p_piutang" required>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button type="button" class="btn btn-primary mt-3" style="display: none;" id="simpanButton"
                                    onclick="showSwal()">
                                    Simpan</button>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        function sendColab() {
            let dueDate = $('#due_date').val();
            let transDate = $('#trans_date').val();
            let selectedInvoice = $('#invoice').val();
            Swal.fire({
                title: "Tunjukkan Hasil Analisa?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya",
                cancelButtonText: "Tidak"
            }).then((result) => {
                if (result.isConfirmed) {
                    $('.validation').html('');
                    $('.form-control').removeClass('is-invalid');
                    $.ajax({
                        method: "POST",
                        url: "{{ route('predict.post') }}",
                        data: {
                            due_date: dueDate,
                            trans_date: transDate,
                            invoice: selectedInvoice
                        },
                        success: function(result) {
                            //Handle Response dari controller
                            $('#hasil_prediksi').html(result.success);
                            // document.getElementById('hasil_prediksi').innerHTML = result.success;
                        },
                        error: function(error) {
                            //Menampilkan Error Validasi (Bila Form Tidak Diisi)
                            if(error.status == 422){
                                let error_validation = error.responseJSON.errors;
                                $.each(error_validation, function(field_name, error) {
                                    $('#' + field_name).addClass("is-invalid");
                                    $('#' + field_name).closest('.mb-3').find('.validation').text(error);
                                });
                            }
                        },
                    });
                }
            });
        }

        function showSwal() {
            Swal.fire({
                title: "Simpan Data?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya",
                cancelButtonText: "Tidak"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Trigger form submission after "Ya" is clicked
                    document.getElementById('myForm').submit();
                }
            });
        }
    </script>
@endpush
