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

  .datatable-info {
    visibility: hidden;
  }
</style>


<!-- Custom styles for this template -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
<!-- Custom styles for this template -->
<link href="{{ asset('/css/dashboard.css') }}" rel="stylesheet">
{{-- <link href="{{ asset('/css/krstables.css') }}" rel="stylesheet"> --}}
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
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
@include('mahasiswa/sidebar')

{{-- CONTENT --}}
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kartu Rencana Studi</h1>
  </div>

  {{-- <button type="button" class="btn btn-md btn-success mb-3" id="showModalBtn">Tambah Jadwal</button> --}}
  <a href="/std/krs/daftarmatkul" class="btn btn-md btn-success mb-3">Daftar Matkul</a>
  @if ($periodeKrs == 'aktif' && $status_krs == 'belum-acc' || $periodeKrs == 'aktif' && $status_krs == null)
      <a href="/std/krs/tambahkrs" class="btn btn-md btn-success mb-3">Tambah Krs</a>
  @endif

  <div class="card">
    <div class="card-header">
      @foreach ($ta as $ak)
        <p class="fs-6 m-0">Kartu Rencana Studi | Tahun Akademik {{ $ak->tahun_ajaran }} - Semseter {{ Str::title($ak->semester) }}</p>
      @endforeach
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped" id="jadwalTable">
            <thead>
                <tr>
                    <th class="text-center" scope="col">No</th>
                    <th class="text-center" scope="col" style="min-width: 50">Kode MK</th>
                    <th class="text-center" scope="col" style="min-width: 360px">Matakuliah</th>
                    <th class="text-center" scope="col" style="min-width: 50">SKS</th>
                    <th class="text-center" scope="col" style="min-width: 50">SMT</th>
                    <th class="text-center" scope="col" style="min-width: 50">Tahun Ajar</th>
                    <th class="text-center" scope="col" style="min-width: 50">Kelas</th>
                    {{-- <th class="text-center" scope="col" style="min-width: 50px">Sisa Kuota</th> --}}
                    <th class="text-center" scope="col" style="min-width: 360px">Jadwal/Ruang</th>
                    <th class="text-center" scope="col" style="min-width: 50">Status</th>
                  </tr>
            </thead>
            <tbody>
              @foreach ($krs as $index => $kr)       
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $kr->jadwal->matkul->kode_matkul }}</td>
                    <td class="">{{ $kr->jadwal->matkul->nama_matkul }}</td>
                    <td class="text-center">{{ $kr->jadwal->matkul->sks }}</td>
                    <td class="text-center">{{ $kr->jadwal->matkul->semester }}</td>
                    <td class="text-center">{{ $kr->jadwal->tahun_akademik->tahun_ajaran}}</td>
                    <td class="text-center">{{ $kr->jadwal->kls}}</td>
                    {{-- <td class="text-center">{{ $kr->jadwal->kuota }}</td> --}}
                    <td class="text-center">({{ Str::title($kr->jadwal->hari) }}) {{ $kr->formatted_jam_mulai }}-{{ $kr->formatted_jam_selesai }} ({{ $kr->jadwal->gedungs->gedung }}-{{ $kr->jadwal->gedungs->no_ruang }})</td>
                    <td class="text-center">
                      @if ($kr->krs->status == 'belum-acc')
                        <a href="{{ route('krs.delete', $kr->id) }}" type="submit" class="btn btn-sm btn-icon-danger"><i class="fa fa-trash"></i></a>
                        @else
                        <p class="fs-5 m-0 text-success"><i class="fa fa-check-square-o" aria-hidden="true"></i></p>
                      @endif
                    </td>
                </tr>  
              @endforeach
            </tbody>
          </table>
          @if ($krs->isEmpty())
              <div class="alert alert-secondary text-center" role="alert">
                  Anda belum input KRS Semester ini
              </div>
          @endif
    </div>
  </div>
</main>
{{-- CONTENT END --}}
</div>
</div>

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
<script src="{{ asset('/js/dashboard.js') }}"></script>
{{-- <script src="{{ asset('/js/mhs/krs.js') }}"></script> --}}

<script>
    //message with sweetalert
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

