@extends('layouts.app')
@section('title', 'Tambah Pencatatan')
@section('content')

    <div class="container-fluid">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-4"><a href="{{ '/pencatatan' }}"></a> <b class="mx-2">Tambah
                            Pencatatan</b>
                    </h5>
                    <div class="card">
                        <div class="card-body">
                            <form id="myForm" method="POST" action="/add-pencatatan/store" enctype="multipart/form-data">
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
                                            <label for="invoice" class="form-label">Invoice<label
                                                    class="text-red">*</label></label>
                                            <select class="form-control" id="invoice" name="invoice" required>
                                                <option value="" selected disabled>Pilih Invoice</option>
                                                @foreach ($piutang as $item)
                                                    <option data-invoice="{{ $item->invoice }}"
                                                        data-duedate="{{ $item->due_date }}"
                                                        data-transdate="{{ $item->trans_date }}"
                                                        data-cutoffdate="{{ $item->cutoff_date }}">{{ $item->invoice }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="due_date" class="form-label">Due Date<label
                                                    class="text-red">*</label></label>
                                            <input type="date" class="form-control" id="due_date" name="due_date">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="trans_date" class="form-label">Trans Date<label
                                                    class="text-red">*</label></label>
                                            <input type="date" class="form-control" id="trans_date" name="trans_date">
                                        </div>
                                    </div>
                                </div>

                                <button class="btn btn-danger mt-3" onclick="sendColab(event)">Tampilkan Hasil
                                    Prediksi</button>

                                <div class="row" style="display:none;" id="hiddenRow">
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

                                <button type="submit" class="btn btn-primary mt-3" style="display: none;" id="simpanButton"
                                    onclick="showSwal()">Simpan</button>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        function parseDate(dateStr) {
            let date = new Date(dateStr);
            return {
                month: date.getMonth() + 1,
                year: date.getFullYear(),
                day: date.getDate()
            };
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
                    document.getElementById('myForm').submit();
                }
            });
        }

        function sendColab(e) {
            e.preventDefault();

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
                    let transDateStr = document.getElementById('trans_date').value;
                    let dueDateStr = document.getElementById('due_date').value;
                    let cutOffDateStr = document.getElementById('cutoff_date').value;

                    let transDate = parseDate(transDateStr);
                    let dueDate = parseDate(dueDateStr);
                    let cutOffDate = parseDate(cutOffDateStr);

                    let numericData = {
                        transMonth: transDate.month,
                        transYear: transDate.year,
                        transDay: transDate.day,
                        dueMonth: dueDate.month,
                        dueYear: dueDate.year,
                        dueDay: dueDate.day,
                        cutOffMonth: cutOffDate.month,
                        cutOffYear: cutOffDate.year,
                        cutOffDay: cutOffDate.day
                    };

                    fetch('/predict', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(numericData)
                        })
                        .then(response => response.json())
                        .then(data => {
                            // Determine the prediction based on due date and cut off date
                            let prediction;
                            if (dueDate.year > cutOffDate.year ||
                                (dueDate.year === cutOffDate.year && dueDate.month > cutOffDate.month) ||
                                (dueDate.year === cutOffDate.year && dueDate.month === cutOffDate.month &&
                                    dueDate.day > cutOffDate.day)) {
                                prediction = "Tidak Terlambat";
                            } else {
                                prediction = data['Hasil Prediksi Piutang'];
                            }

                            // Display the prediction
                            document.getElementById("hiddenRow").style.display = "block";
                            document.getElementById("p_piutang").value = prediction;
                            document.getElementById("simpanButton").style.display = "block";
                            document.getElementById("p_piutang_display").value = prediction;

                        })
                        .catch(error => {
                            // Handle errors if any
                            console.error('Error:', error);
                        });

                }
            });
        }
    </script>

@endsection
