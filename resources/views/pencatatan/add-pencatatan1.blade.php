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

                                <button class="btn btn-danger mt-3" onclick="sendColab()">Tampilkan Hasil
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

                                <button type="submit" class="btn btn-primary mt-3" style="display: none;" id="simpanButton"
                                    onclick="showSwal()">
                                    Simpan</button>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
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

        function sendColab(e => preventDefault) {
            e.preventDefault()
            // Menghentikan perilaku default dari tombol submit

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
                    // Ambil nilai dari form input

                    const Trans_Date = document.getElementById('trans_date').value;
                    let Trans_Year;

                    if (Trans_Date.includes('Tahun')) {
                        Trans_Year = parseInt(Trans_Date);
                    } else {
                        Trans_Year = 0;
                    }

                    const Trans_Date = document.getElementById('trans_date').value;

                    let Trans_Month;

                    if (Trans_Date.includes('Tahun') && Trans_Date.includes('Bulan')) {
                        const ageParts = Trans_Date.split(' ');
                        const day = parseInt(ageParts[0]);
                        const years = parseInt(ageParts[0]);
                        const months = parseInt(ageParts[2]);
                        Trans_Month = years * 12 + months;
                    } else if (Trans_Date.includes('Tahun')) {
                        const years = parseInt(Trans_Date);
                        Trans_Month = years * 12;
                    } else if (Trans_Date.includes('Bulan')) {
                        const months = parseInt(Trans_Date);
                        Trans_Month = months;
                    } else {
                        Trans_Month = 0;
                    }

                    const Trans_Date = document.getElementById('trans_date').value;
                    let Trans_Day;

                    if (Trans_Date.includes('Tahun') && Trans_Date.includes('Bulan')) {
                        const ageParts = Trans_Date.split(' ');
                        const years = parseInt(ageParts[0]);
                        const months = parseInt(ageParts[2]);
                        Trans_Day = (years * 365) + (months * 30);
                    } else if (Trans_Date.includes('Tahun')) {
                        const years = parseInt(Trans_Date);
                        Trans_Day = years * 365;
                    } else if (Trans_Date.includes('Bulan')) {
                        const months = parseInt(Trans_Date);
                        Trans_Day = months * 30;
                    } else {
                        Trans_Day = 0;
                    }

                    console.log(Trans_Day);

                    const Due_Date = document.getElementById('due_date').value;
                    let Due_Year;

                    if (Due_Date.includes('Tahun')) {
                        Due_Year = parseInt(Due_Date);
                    } else {
                        Due_Year = 0;
                    }

                    const Due_Date = document.getElementById('due_date').value;
                    let Due_Month;

                    if (Due_Date.includes('Tahun') && Due_Date.includes('Bulan')) {
                        const ageParts = Due_Date.split(' ');
                        const day = parseInt(ageParts[0]);
                        const years = parseInt(ageParts[0]);
                        const months = parseInt(ageParts[2]);
                        Due_Month = years * 12 + months;
                    } else if (Due_Date.includes('Tahun')) {
                        const years = parseInt(Due_Date);
                        Due_Month = years * 12;
                    } else if (Due_Date.includes('Bulan')) {
                        const months = parseInt(Due_Date);
                        Due_Month = months;
                    } else {
                        Due_Month = 0;
                    }

                    const Due_Date = document.getElementById('due_date').value;
                    let Due_Day;

                    if (Due_Date.includes('Tahun') && Due_Date.includes('Bulan')) {
                        const ageParts = Due_Date.split(' ');
                        const years = parseInt(ageParts[0]);
                        const months = parseInt(ageParts[2]);
                        Due_Day = (years * 365) + (months * 30);
                    } else if (Due_Date.includes('Tahun')) {
                        const years = parseInt(Due_Date);
                        Due_Day = years * 365;
                    } else if (Due_Date.includes('Bulan')) {
                        const months = parseInt(Due_Date);
                        Due_Day = months * 30;
                    } else {
                        Due_Day = 0;
                    }

                    // console.log(Due_Day);

                    const Cutoff_Date = document.getElementById('cutoff_date').value;
                    let Cutoff_Year;

                    if (Cutoff_Date.includes('Tahun')) {
                        Cutoff_Year = parseInt(Cutoff_Date);
                    } else {
                        Cutoff_Year = 0;
                    }

                    const Cutoff_Date = document.getElementById('cutoff_date').value;
                    let Cutoff_Month;

                    if (Cutoff_Date.includes('Tahun') && Cutoff_Date.includes('Bulan')) {
                        const ageParts = Cutoff_Date.split(' ');
                        const day = parseInt(ageParts[0]);
                        const years = parseInt(ageParts[0]);
                        const months = parseInt(ageParts[2]);
                        Cutoff_Month = years * 12 + months;
                    } else if (Cutoff_Date.includes('Tahun')) {
                        const years = parseInt(Cutoff_Date);
                        Cutoff_Month = years * 12;
                    } else if (Cutoff_Date.includes('Bulan')) {
                        const months = parseInt(Cutoff_Date);
                        Cutoff_Month = months;
                    } else {
                        Cutoff_Month = 0;
                    }

                    const Cutoff_Date = document.getElementById('cutoff_date').value;
                    let Cutoff_Day;

                    if (Cutoff_Date.includes('Tahun') && Cutoff_Date.includes('Bulan')) {
                        const ageParts = Cutoff_Date.split(' ');
                        const years = parseInt(ageParts[0]);
                        const months = parseInt(ageParts[2]);
                        Cutoff_Day = (years * 365) + (months * 30);
                    } else if (Cutoff_Date.includes('Tahun')) {
                        const years = parseInt(Cutoff_Date);
                        Cutoff_Day = years * 365;
                    } else if (Cutoff_Date.includes('Bulan')) {
                        const months = parseInt(Cutoff_Date);
                        Cutoff_Day = months * 30;
                    } else {
                        Cutoff_Day = 0;
                    }

                    console.log(Cutoff_Day);

                    const data = {
                        "0": Trans_Month,
                        "1": Trans_Day,
                        "2": Trans_Year,
                        "3": Due_Month,
                        "4": Due_Day,
                        "5": Due_Year,
                        "6": Cutoff_Month,
                        "7": Cutoff_Day,
                        "8": Cutoff_Year
                    };

                    console.log("Data yang akan dikirim:", data);

                    // Kirim permintaan POST ke endpoint /predict
                    fetch('/predict', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(numericData)
                        })

                        .then(response => {
                            response.json();

                        })
                        .then(data => {

                            // Tampilkan hasil prediksi jika diperlukan
                            document.getElementById("hiddenRow").style.display = "block";
                            document.getElementById("p_piutang").value = data["Hasil Prediksi Piutang"];
                            document.getElementById("simpanButton").style.display = "block";
                            document.getElementById("p_piutang_display").value = data["Hasil Prediksi Piutang"];
                        })
                        .catch(error => {
                            // Tangani kesalahan jika terjadi
                            console.error('Error:', error);
                        });

                }
            });
        }

        document.addEventListener('DOMContentLoaded', (event) => {
            const invoice = document.getElementById('invoice');

            invoice.addEventListener('change', function() {
                const selectedOption = invoice.options[invoice.selectedIndex];

                const data = {
                    Trans_Day: selectedOption.getAttribute('data-transday'),
                    Trans_Month: selectedOption.getAttribute('data-transmonth'),
                    Trans_Year: selectedOption.getAttribute('data-transyear'),
                    Due_Day: selectedOption.getAttribute('data-dueday'),
                    Due_Month: selectedOption.getAttribute('data-duemonth'),
                    Due_Year: selectedOption.getAttribute('data-dueyear'),
                    Cutoff_Day: selectedOption.getAttribute('data-cutoffday'),
                    Cutoff_Month: selectedOption.getAttribute('data-cutoffmonth'),
                    Cutoff_Year: selectedOption.getAttribute('data-cutoffyear')
                };


                // Set the values of the inputs
                document.getElementById('trans_day').value = data.transday;
                document.getElementById('trans_month').value = data.transmonth;
                document.getElementById('trans_year').value = data.transyear;
                document.getElementById('due_day').value = data.dueday;
                document.getElementById('due_month').value = data.duemonth;
                document.getElementById('due_year').value = data.dueyear;
                document.getElementById('cutoff_day').value = data.cutoffday;
                document.getElementById('cutoff_month').value = data.cutoffmonth;
                document.getElementById('cutoff_day').value = data.cutoffday;
            });
        });
    </script>

@endsection
