@extends('layout/layout')

@section('head')
<style>
  .bd-placeholder-img {
    font-size: 1.125rem;
    text-anchor: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    user-select: none;
  }

  @media (min-width: 768px) {
    .bd-placeholder-img-lg {
      font-size: 3.5rem;
    }
  }

  .b-example-divider {
    width: 100%;
    height: 3rem;
    background-color: rgba(0, 0, 0, .1);
    border: solid rgba(0, 0, 0, .15);
    border-width: 1px 0;
    box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
  }

  .b-example-vr {
    flex-shrink: 0;
    width: 1.5rem;
    height: 100vh;
  }

  .bi {
    vertical-align: -.125em;
    fill: currentColor;
  }

  .nav-scroller {
    position: relative;
    z-index: 2;
    height: 2.75rem;
    overflow-y: hidden;
  }

  .nav-scroller .nav {
    display: flex;
    flex-wrap: nowrap;
    padding-bottom: 1rem;
    margin-top: -1px;
    overflow-x: auto;
    text-align: center;
    white-space: nowrap;
    -webkit-overflow-scrolling: touch;
  }

  .btn-bd-primary {
    --bd-violet-bg: #712cf9;
    --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

    --bs-btn-font-weight: 600;
    --bs-btn-color: var(--bs-white);
    --bs-btn-bg: var(--bd-violet-bg);
    --bs-btn-border-color: var(--bd-violet-bg);
    --bs-btn-hover-color: var(--bs-white);
    --bs-btn-hover-bg: #6528e0;
    --bs-btn-hover-border-color: #6528e0;
    --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
    --bs-btn-active-color: var(--bs-btn-hover-color);
    --bs-btn-active-bg: #5a23c8;
    --bs-btn-active-border-color: #5a23c8;
  }

  .bd-mode-toggle {
    z-index: 1500;
  }

  .bd-mode-toggle .dropdown-menu .active .bi {
    display: block !important;
  }

  .card-rounded-bottom {
    border-top-left-radius: 0px; 
    border-top-right-radius: 0px;
  }

  .card-rounded-top {
    border-bottom-left-radius: 0px; 
    border-bottom-right-radius: 0px;
  }

  .column-absen {
    width: 50px
  }
</style>


<!-- Custom styles for this template -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
<!-- Custom styles for this template -->
<link href="{{ asset('/css/dashboard.css') }}" rel="stylesheet">
{{-- <link href="{{ asset('/css/krstables.css') }}" rel="stylesheet"> --}}
@endsection

@section('content')
    
<div class="dropdown position-fixed bottom-0 end-0 mb-3 me-3 bd-mode-toggle">
  <button class="btn btn-bd-primary py-2 dropdown-toggle d-flex align-items-center"
          id="bd-theme"
          type="button"
          aria-expanded="false"
          data-bs-toggle="dropdown"
          aria-label="Toggle theme (auto)">
    <svg class="bi my-1 theme-icon-active" width="1em" height="1em"><use href="#circle-half"></use></svg>
    <span class="visually-hidden" id="bd-theme-text">Toggle theme</span>
  </button>
  <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-text">
    <li>
      <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light" aria-pressed="false">
        <svg class="bi me-2 opacity-50" width="1em" height="1em"><use href="#sun-fill"></use></svg>
        Light
        <svg class="bi ms-auto d-none" width="1em" height="1em"><use href="#check2"></use></svg>
      </button>
    </li>
    <li>
      <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark" aria-pressed="false">
        <svg class="bi me-2 opacity-50" width="1em" height="1em"><use href="#moon-stars-fill"></use></svg>
        Dark
        <svg class="bi ms-auto d-none" width="1em" height="1em"><use href="#check2"></use></svg>
      </button>
    </li>
    <li>
      <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto" aria-pressed="true">
        <svg class="bi me-2 opacity-50" width="1em" height="1em"><use href="#circle-half"></use></svg>
        Auto
        <svg class="bi ms-auto d-none" width="1em" height="1em"><use href="#check2"></use></svg>
      </button>
    </li>
  </ul>
</div>
@include('admin/navbar')



<div class="container-fluid">
{{-- SIDEBARD --}}
<div class="row">
@include('dosen/sidebar')

{{-- CONTENT --}}
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Presensi Mahasiswa <span class="fs-5 fw-normal text-secondary">Ubah Presensi</span></h1>
  </div>
  <div class="card card-rounded-top">
    <div class="card-header">
      <p class="fs-6 m-0">Daftar Presensi</p>
    </div>
    <div class="card-body">
      <form action="{{ route('getDataMahasiswa') }}" method="POST">
        @csrf
        <div class="container col-md-8">
            <select class="form-select" aria-label="Default select example" name='id_jadwal' id="kelasInput">
              <option value="0" selected>--- Pilih Kelas ---</option>
              @foreach ($jadwal as $jdwl)
                <option value="{{ $jdwl->id }}">{{ $jdwl->matkul->nama_matkul }} - Kelas {{ $jdwl->kls }}</option>
              @endforeach
            </select>

            <select class="form-select my-3" name="pertemuan" id="pertemuanInput" value="8">
              <option value="0" selected>--- Pilih Pertemuan ---</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
              <option value="7">7</option>
              <option value="8">8</option>
              <option value="1">9</option>
              <option value="2">10</option>
              <option value="3">11</option>
              <option value="4">12</option>
              <option value="5">13</option>
              <option value="6">14</option>
            </select>

          <div class="d-flex justify-content-end mt-2" id="buttonContainer">
            <button class="btn btn-success" disabled>Tampilkan</button>
          </div>
      </form>
      </div>
    </div>
  </div>
  <div id="tableContainer">
    @if (isset($dataAbsen) && !empty($dataAbsen))
      <div class="card mt-3 card-rounded-bottom">
        <div class="card-body" id="tableMahasiswa">
            <table class="table table-striped table-bordered" id="jadwalTable">
              <thead>
                <tr>
                  <th class="header text-center" style="width: 90px;">No</th>
                  <th class="header text-center" style="width: 200px;">NPM</i></th>
                  <th class="header text-center" style="width: 300px;">Nama Mahasiswa</th>
                  <th class="header text-center">Keterangan</th>
                </tr>
              </thead>
              <tbody id="tableBody">
                <form action="{{ route('ubahabsen.update') }}" method="POST">
                  @csrf
                  {{-- @method('PUT') --}}
                @forelse ($dataAbsen as $index => $absen)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td >{{ $absen->nim }}</td>
                        <td>{{ $absen->nama }}</td>
                        <td class="" style="width: 100px;">
                            <input type="hidden" name="presensi[{{ $absen->nim }}][nim]" value="{{ $absen->nim }}">
                            <select class="form-select ket-select" name="presensi[{{ $absen->nim }}][ket]">
                                <option value="-" {{ $absen->ket == '-' ? 'selected' : '' }}>-</option>
                                <option value="A" {{ $absen->ket == 'A' ? 'selected' : '' }}>Alpha</option>
                                <option value="H" {{ $absen->ket == 'H' ? 'selected' : '' }}>Hadir</option>
                                <option value="I" {{ $absen->ket == 'I' ? 'selected' : '' }}>Izin</option>
                            </select>
                        </td>  
                    </tr>
                @empty
                    <tr><td colspan='17' class='text-center'>Pilih Matakuliah!</td></tr>
                @endforelse
              </tbody>
            </table>

            <input type="hidden" name="jadwal_id" value="{{ $old_data->id_jadwal }}">
            <input type="hidden" name="pert" value="{{ $old_data->pertemuan }}">
            <div class="d-flex justify-content-end">
              <button type="submit" class="btn btn-success">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    @endif
  </div>

  {{-- <div class="d-flex justify-content-end my-3">
    <button class="btn btn-success" id="saveBtn" onclick="test()">Simpan</button>
  </div> --}}
  


</main>
{{-- CONTENT END --}}
</div>
</div>

@section('scripts')
<script src="{{ asset('/js/dashboard.js') }}"></script>
<script src="{{ asset('/js/dosen/ubah-absen.js') }}"></script>
<script>
   @if(session('success'))
        Swal.fire({
            icon: "success",
            title: "BERHASIL",
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2000
        });
    @elseif(session('error'))
        Swal.fire({
            icon: "error",
            title: "GAGAL!",
            text: "{{ session('error') }}",
            showConfirmButton: false,
            timer: 2000
        });
    @endif
</script>
@endsection
@endsection

