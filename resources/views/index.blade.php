@extends('layouts.main')
@push('css')
    <link rel="icon" type="image/x-icon" href="asset/favicon.ico" />
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <link href="assets/css/theme.min.css" rel="stylesheet" id="style-default">
    <style>
        .loader {
            width: 80px;
            aspect-ratio: 2;
            --c:no-repeat linear-gradient(#fff 0 0);
            background: var(--c),var(--c),var(--c),var(--c),var(--c),var(--c),var(--c);
            animation: 
                l4-1 1.5s infinite,
                l4-2 1.5s infinite;
            display: none; /* Sembunyikan loading screen secara default */
            position: fixed;
            top: 50%; /* Posisikan di tengah vertikal */
            left: 50%; /* Posisikan di tengah horizontal */
            transform: translate(-50%, -50%); /* Geser ke tengah */
            z-index: 9999; /* Atur tumpukan z-index untuk memastikan loading screen muncul di atas elemen lain */
        }
        @keyframes l4-1 {
        0%      {background-size: 0   4px,4px 0  ,0   4px,4px 0   ,0   4px,4px 0  ,0   4px}
        7.14%   {background-size: 25% 4px,4px 0  ,0   4px,4px 0   ,0   4px,4px 0  ,0   4px}
        14.29%  {background-size: 25% 4px,4px 50%,0   4px,4px 0   ,0   4px,4px 0  ,0   4px}
        21.43%  {background-size: 25% 4px,4px 50%,25% 4px,4px 0   ,0   4px,4px 0  ,0   4px}
        28.57%  {background-size: 25% 4px,4px 50%,25% 4px,4px 100%,0   4px,4px 0  ,0   4px}
        35.71%  {background-size: 25% 4px,4px 50%,25% 4px,4px 100%,25% 4px,4px 0  ,0   4px}
        42.86%  {background-size: 25% 4px,4px 50%,25% 4px,4px 100%,25% 4px,4px 50%,0   4px}
        49%,
        51%     {background-size: 25% 4px,4px 50%,25% 4px,4px 100%,25% 4px,4px 50%,25% 4px}
        57.14%  {background-size: 0   4px,4px 50%,25% 4px,4px 100%,25% 4px,4px 50%,25% 4px}
        64.29%  {background-size: 0   4px,4px 0  ,25% 4px,4px 100%,25% 4px,4px 50%,25% 4px}
        71.43%  {background-size: 0   4px,4px 0  ,0   4px,4px 100%,25% 4px,4px 50%,25% 4px}
        78.57%  {background-size: 0   4px,4px 0  ,0   4px,4px 0   ,25% 4px,4px 50%,25% 4px}
        85.71%  {background-size: 0   4px,4px 0  ,0   4px,4px 0   ,0   4px,4px 50%,25% 4px}
        92.86%  {background-size: 0   4px,4px 0  ,0   4px,4px 0   ,0   4px,4px 0  ,25% 4px}
        100%    {background-size: 0   4px,4px 0  ,0   4px,4px 0   ,0   4px,4px 0  ,0   4px}
        }

        @keyframes l4-2 {
        0%,49.9% {background-position:0 50%,bottom 20px left 16px,20px 0,50% 0,40px 100%,bottom 0 right 16px,60px 50% }
        50%,100% {background-position:right 60px top 50%,16px 0,right 40px top 0,50% 100%,right 20px bottom 0,right 16px top 20px,100% 50%}
        }

        .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5); /* Warna latar belakang gelap dengan transparansi 50% */
        z-index: 9998; /* Atur tumpukan z-index agar berada di bawah loader */
        display: none; /* Sembunyikan secara default */
        }
    </style>
@endpush
@push('js')
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
    <script>
        document.getElementById('generatePdfForm').addEventListener('submit', function(event) {
            event.preventDefault();
            var form = event.target;
            var formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    document.getElementById('pdfContainer').innerHTML = `<embed src="${data.pdfUrl}" type="application/pdf" width="276" height="420" />`;
                } else {
                    alert('Failed to generate PDF');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred, please try again later');
            });
        });
    </script>
    <script>
        document.getElementById('generatePdfForm').addEventListener('submit', function(event) {
            event.preventDefault();
            var form = event.target;
            var formData = new FormData(form);

            // Tampilkan overlay
            document.querySelector('.overlay').style.display = 'block';
            // Tampilkan loader
            document.querySelector('.loader').style.display = 'block';

            fetch(form.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Sembunyikan overlay dan loader setelah permintaan selesai
                document.querySelector('.overlay').style.display = 'none';
                document.querySelector('.loader').style.display = 'none';

                if(data.success) {
                    document.getElementById('pdfContainer').innerHTML = `<embed src="${data.pdfUrl}" type="application/pdf" width="276" height="420" />`;
                } else {
                    alert('Failed to generate PDF');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred, please try again later');

                // Sembunyikan overlay dan loader jika ada kesalahan
                document.querySelector('.overlay').style.display = 'none';
                document.querySelector('.loader').style.display = 'none';
            });
        });
    </script>
@endpush
@section('content')
    <header class="masthead text-center text-white">
        <div class="masthead-content">
            <div class="container px-5">
                <img id="logo" src="{{ @asset('img/logo-ptpn.png') }}" alt="PTPN IV REGIONAL III">
                {{-- <h2 class="masthead-subheading mb-0">Buat ID Card secara otomatis</h2> --}}
                <h1 class="masthead-heading mb-0 mt-5">ID CARD MAGANG</h1>
                <div class="mb-5">
                    <a id="buat" class="btn btn-primary btn-xl mt-5" href="#scroll">Buat Sekarang</a>
                </div>
            </div>
        </div>
    </header>
    <section >
        <div class="overlay"></div>
        <div class="loader"></div>    
        <div class="container px-5 d-flex justify-content-center">
            <div class="col-lg-8">
                <div class="text-center">
                    <h2 id="scroll" class="display-4 mb-4">Input Data Peserta Magang</h2>
                    <p class="mb-4">Masukkan data Anda di sini agar dapat digenerate secara otomatis ke dalam ID Card</p>
                </div>
                <div class="card mb-3">
                    <div class="card-header" style="background-color: #344050;">
                        <div class="row flex-between-end">
                            <div class="col-auto align-self-center">
                                <h5 class="mb-0" style="color: white" data-anchor="data-anchor">Input Data</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body bg-light">
                        <div class="tab-content">
                            <div class="tab-pane preview-tab-pane active" role="tabpanel" aria-labelledby="tab-dom-d4ebf6c5-74b4-4308-8c64-cda718c9b324" id="dom-d4ebf6c5-74b4-4308-8c64-cda718c9b324">
                                <form id="generatePdfForm" method="post" action="{{ route('generatePdf') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label" for="nama">Nama</label>
                                        <input class="form-control @error('nama')is-invalid @enderror" id="nama" type="text" placeholder="Nama" name="nama" maxlength="27" value="{{ old('nama') }}" required/>
                                        @error('nama')
                                        <div class="invalid-feedback mb-1">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="penempatan">Divisi/Penempatan</label>
                                        {{-- <input class="form-control" id="penempatan" type="text" placeholder="Divisi/Penempatan" name="penempatan"/> --}}
                                        <select class="form-select @error('penempatan')is-invalid @enderror" id="penempatan" aria-label="Default select example" name="penempatan" value="{{ old('penempatan') }}" required>
                                            <option selected disabled>Pilih Divisi/Penempatan</option>
                                            <option value="TI">TI</option>
                                            <option value="TANAMAN">TANAMAN</option>
                                            <option value="SDM">SDM</option>
                                            <option value="TEKPOL">TEKPOL</option>
                                            <option value="PLP">PLP</option>
                                            <option value="KEUANGAN">KEUANGAN</option>
                                            <option value="HUMAS">HUMAS</option>
                                            <option value="HUKUM">HUKUM</option>
                                            <option value="PST">PST</option>
                                        </select>
                                        @error('penempatan')
                                        <div class="invalid-feedback mb-1">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="asal">Asal Sekolah/Universitas</label>
                                        <input class="form-control @error('asal')is-invalid @enderror" id="asal" type="text" placeholder="Asal Sekolah/Universitas" name="asal" maxlength="28" value="{{ old('asal') }}" required/>
                                        @error('asal')
                                        <div class="invalid-feedback mb-1">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="noHp">Nomor HP</label>
                                        <input class="form-control @error('noHp')is-invalid @enderror" id="noHp" type="text" placeholder="Nomor HP" name="noHp" minlength="10" value="{{ old('noHp') }}" required/>
                                        @error('noHp')
                                        <div class="invalid-feedback mb-1">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="kode">Kode Pengajuan Magang</label>
                                        <input class="form-control @error('kode')is-invalid @enderror" id="kode" type="text" placeholder="Kode Pengajuan Magang" name="kode" minlength="15" maxlength="15" value="{{ old('kode') }}" required/>
                                        @error('kode')
                                        <div class="invalid-feedback mb-1">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="foto">Unggah Foto Diri (Ukuran 2:3)</label>
                                        <input class="form-control @error('foto')is-invalid @enderror" id="foto" type="file" name="foto" required>
                                        <small class="">Pastikan background foto sudah dihapus sebelum diunggah, klik <a href="{{ @asset('img/contoh_foto_id_card-removebg-preview.png') }}" download>di sini</a> untuk mendownload contoh foto</small>
                                        @error('foto')
                                        <div class="invalid-feedback mb-1">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button class="btn btn-primary mt-3" style="" type="submit">Generate</button>
                                    </div>
                                    <div id="pdfContainer" class="mt-3 d-flex justify-content-center"></div>
                                </form>
                            </div>    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
