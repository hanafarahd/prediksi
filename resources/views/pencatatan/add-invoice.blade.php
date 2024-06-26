@extends('layouts.app')
@section('title', 'Tambah Pencatatan')
@section('content')

    <div class="container-fluid pt-2">
        <div class="card">
            <div class="card-body">
                <form id="myForm" method="POST" action="/add-invoice/store" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <h5 class="mb-4"><b>Data Piutang</b></h5>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">
                                    Invoice*
                                </label>
                                <input type="text" class="form-control" id="invoiceOnlyNumber"
                                    onkeypress="return isNumber(event)" name="invoice" placeholder="Masukkan Nomor Invoice"
                                    required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">Tipe Jual*</label>
                                <select class="form-control text-capitalize" id="invoice" name="sale_type" required>
                                    @foreach ($sales as $sale)
                                        <option value={{ $sale->id }}>{{ $sale->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">Kode Salesman*</label>
                                <select class="form-control text-capitalize" id="invoice" name="salesman_code" required>
                                    @foreach ($salesmans as $salesman)
                                        <option value={{ $salesman->code }}>{{ $salesman->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">Customer Group*</label>
                                <select class="form-control text-capitalize" id="invoice" name="customer_group_id"
                                    required>
                                    @foreach ($customerGroups as $csGroup)
                                        <option value={{ $csGroup->id }}>{{ $csGroup->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">Kode Wilayah*</label>
                                <select class="form-control text-capitalize" name="territory_code" required>
                                    @foreach ($territories as $territory)
                                        <option value={{ $territory->code }}>{{ $territory->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">Invoice Amount*</label>
                                <input type="text" class="form-control" onkeypress="return isNumber(event)"
                                    name="invoice_amount" placeholder="Masukkan Invoice Amount" required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">Outstanding*</label>
                                <input type="text" class="form-control" name="outstanding"
                                    onkeypress="return isNumber(event)" placeholder="Masukkan Outstanding" required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">Frekuensi Tukar*</label>
                                <input type="text" class="form-control" onkeypress="return isNumber(event)"
                                    name="exchange_freq" placeholder="Masukkan Frekuensi Tukar" required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">Frekuensi Tagih*</label>
                                <input type="text" class="form-control" onkeypress="return isNumber(event)"
                                    name="bill_freq" placeholder="Masukkan Frekuensi Tagih" required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">Garansi Letter*</label>
                                <select class="form-control" id="invoice" name="guarantee" required>
                                    <option value="ada">Ada</option>
                                    <option value="tidak ada">Tidak Ada</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="due_date" class="form-label">Due Date*</label>
                                <input type="date" class="form-control" id="due_date" name="due_date">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="trans_date" class="form-label">
                                    Trans Date*
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
