@extends('layouts.app')
@section('title', 'Tambah Pencatatan')
@section('content')
    <div class="container-fluid pt-2">
        <div class="card ">
            <div class="card-body">
                <h5 class="card-title fw-bold mb-4">
                    <a href="{{ '/pencatatan' }}"></a>
                    <b class="mx-2">Prediksi Data Piutang</b>
                </h5>

                <form id="myForm" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <select class="form-control" id="record-invoice" name="invoice" required>
                                    <option selected disabled>Pilih Invoice</option>
                                    @foreach ($debts as $item)
                                        <option data-invoice={{ $item->invoice }} data-sale_type={{ $item->sale_type }}
                                            data-salesman_code={{ $item->salesman_code }}
                                            data-customer_group_id={{ $item->customer_group_id }}
                                            data-territory_code={{ $item->territory_code }}
                                            data-guarantee_letter={{ $item->guarantee_letter }}
                                            data-invoice_amount={{ $item->invoice_amount }}
                                            data-outstanding={{ $item->outstanding }}
                                            data-cutoff_date={{ $item->cutoff_date }}
                                            data-trans_date={{ $item->trans_date }} data-due_date={{ $item->due_date }}
                                            data-exchange_freq={{ $item->exchange_freq }}
                                            data-bill_freq={{ $item->bill_freq }}>
                                            {{ $item->invoice }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-danger mt-3" onclick="sendColab(event)">
                        Tampilkan Hasil Prediksi
                    </button>

                    <div class="row">
                        <span id="loadingSpinner" style="margin-left: 10px; display: none"
                            class="spinner-border spinner-border-lg mt-3" role="status" aria-hidden="true"></span>

                        <div class="col-sm-12" id="hiddenRow" style="display: none">
                            <div class="col-sm-12 mt-3">
                                <div class="mb-3">
                                    <label for="p_piutang" class="form-label">Prediksi Piutang<label
                                            class="text-red">*</label></label>
                                    <input type="text" class="form-control hasil-prediksi" id="p_piutang_display"
                                        value="" name="p_piutang_display" required disabled>
                                    <input type="hidden" class="form-control hasil-prediksi" id="p_piutang" value=""
                                        name="p_piutang" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3" style="display: none;"
                        id="simpanButton">Simpan</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const invoice = document.getElementById('record-invoice');

            invoice.addEventListener('change', function() {
                const selectedOption = invoice.options[invoice.selectedIndex];
                const form = document.getElementById('myForm')

                form.setAttribute('action',
                    /add-pencatatan/store / $ {
                        selectedOption.getAttribute('data-invoice')
                    })

                const data = {
                    invoice: selectedOption.getAttribute('data-invoice'),
                    sale_type: selectedOption.getAttribute('data-sale_type'),
                    salesman_code: selectedOption.getAttribute('data-salesman_code'),
                    customer_group_id: selectedOption.getAttribute('data-customer_group_id'),
                    territory_code: selectedOption.getAttribute('data-territory_code'),
                    guarantee_letter: selectedOption.getAttribute('data-guarantee_letter'),
                    invoice_amount: selectedOption.getAttribute('data-invoice_amount'),
                    outstanding: selectedOption.getAttribute('data-outstanding'),
                    cutoff_date: selectedOption.getAttribute('data-cutoff_date'),
                    due_date: selectedOption.getAttribute('data-due_date'),
                    trans_date: selectedOption.getAttribute('data-trans_date'),
                    exchange_freq: selectedOption.getAttribute('data-exchange_freq'),
                    bill_freq: selectedOption.getAttribute('data-bill_freq'),
                };

            });
        });

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
                if (result.isConfirmed) document.getElementById('myForm').submit()
            });
        }

        function sendColab(e) {
            e.preventDefault();
            const invoice = document.getElementById('record-invoice');
            const selectedOption = invoice.options[invoice.selectedIndex];

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
                    const cutoffDate = parseDate(selectedOption.getAttribute('data-cutoff_date'));
                    const dueDate = parseDate(selectedOption.getAttribute('data-due_date'));

                    const data = {
                        invoice: parseInt(selectedOption.getAttribute('data-invoice')),
                        sale_type: parseInt(selectedOption.getAttribute('data-sale_type')),
                        salesman_code: parseInt(selectedOption.getAttribute('data-salesman_code')),
                        customer_group_id: parseInt(selectedOption.getAttribute('data-customer_group_id')),
                        territory_code: parseInt(selectedOption.getAttribute('data-territory_code')),
                        guarantee_letter: selectedOption.getAttribute('data-guarantee_letter') === 'ada' ? 0 :
                            1,
                        invoice_amount: parseInt(selectedOption.getAttribute('data-invoice_amount')),
                        outstanding: parseInt(selectedOption.getAttribute('data-outstanding')),
                        exchange_freq: parseInt(selectedOption.getAttribute('data-exchange_freq')),
                        bill_freq: parseInt(selectedOption.getAttribute('data-bill_freq')),
                    };

                    const fixedData = {
                        ...data,
                        due_month: dueDate.month,
                        due_day: dueDate.day,
                        due_year: dueDate.year,
                        cutoff_month: cutoffDate.month,
                        cutoff_day: cutoffDate.day,
                        cutoff_year: cutoffDate.year,
                    }

                    document.getElementById("loadingSpinner").style.display = "inline-block";

                    // Sembunyikan hasil prediksi
                    document.getElementById("hiddenRow").style.display = "none";
                    document.getElementById("simpanButton").style.display = "none";

                    fetch('/predict', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(fixedData)
                        })
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById("loadingSpinner").style.display = "none";
                            document.getElementById("hiddenRow").style.display = "block";
                            document.getElementById("p_piutang").value = data["Hasil Prediksi Piutang"];
                            document.getElementById("simpanButton").style.display = "block";
                            document.getElementById("p_piutang_display").value = data["Hasil Prediksi Piutang"];
                        })
                        .catch(error => console.error('Error:', error))
                }
            });
        }
    </script>

@endsection
