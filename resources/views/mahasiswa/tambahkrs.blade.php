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
<link href="{{ asset('/css/krstables.css') }}" rel="stylesheet">
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
    <h1 class="h2">Kartu Rencana Studi <span class="fs-5 fw-normal text-secondary">Tambah Krs</span></h1>
  </div>
  <div class="card">
    <div class="card-header">
      <p class="fs-6 m-0">Daftar Matakuliah</p>
    </div>
    <div class="card-body">
      <form action="{{ route('std.krs.store') }}" method="POST">
          @csrf
          <table class="table table-bordered table-striped" id="jadwalTable">
              <thead>
                  <tr>
                      <th class="text-center" scope="col">Status</th>
                      <th class="text-center" scope="col">Kode MK</th>
                      <th class="text-center" scope="col" style="min-width: 350px">Matakuliah</th>
                      <th class="text-center" scope="col">SKS</th>
                      <th class="text-center" scope="col">SMT</th>
                      <th class="text-center" scope="col">Tahun Ajar</th>
                      <th class="text-center" scope="col">Kelas</th>
                      <th class="text-center" scope="col">Sisa Kuota</th>
                      <th class="text-center" scope="col" style="min-width: 350px">Jadwal/Ruang</th>
                  </tr>
              </thead>
              <tbody>
                @foreach ($jadwals as $jadwal)
                  <tr>
                    @if ($jadwal->kuota > 0)
                      <td class="d-flex justify-content-center fw-bold text-danger">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" name="matkul_ids[]" value="{{ $jadwal->id }}" id="flexCheckDefault">
                        </div>
                      </td>
                    @else
                    <td class="text-center fw-bold text-danger">FULL</td>
                    @endif
                      
                      
                      <td class="text-center">{{ $jadwal->matkul->kode_matkul }}</td>
                      <td class="">{{ $jadwal->matkul->nama_matkul }}</td>
                      <td class="text-center">{{ $jadwal->matkul->sks }}</td>
                      <td class="text-center">{{ $jadwal->matkul->semester }}</td>
                      <td class="text-center">{{ $jadwal->tahun_akademik->tahun_ajaran}}</td>
                      <td class="text-center">{{ $jadwal->kls}}</td>
                      <td class="text-center">{{ $jadwal->kuota }}</td>
                      <td class="text-center">({{ Str::title($jadwal->hari) }}) {{ $jadwal->formatted_jam_mulai }}-{{ $jadwal->formatted_jam_selesai }} ({{ $jadwal->gedungs->gedung }}-{{ $jadwal->gedungs->no_ruang }})</td>
                      
                  </tr>  
                @endforeach
              </tbody>
          </table>
          <button type="submit" class="btn btn-primary">Simpan KRS</button>
      </form>
    </div>
  </div>


  <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModal" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
              <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Fakultas</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form action="{{ route('jadwal.store') }}" method="POST" enctype="multipart/form-data">
                  <div class="modal-body"> 
                      @csrf
                      <div class="form-group mb-3">
                          <label class="font-weight-bold">Matakuliah</label>
                          <select class="form-select mt-2 @error('matkul') is-invalid @enderror" aria-label="matkul" name="matkul">
                            <option selected>--- Pilih Matakuliah ---</option>
                            {{-- @foreach ($matkuls as $matkul)
                              <option value="{{ $matkul->id }}">{{ $matkul->nama_matkul }}</option>
                            @endforeach --}}
                            
                          </select>
                          <!-- error message untuk fakultas -->
                          @error('matkul')
                              <div class="alert alert-danger mt-2">
                                  {{ $message }}
                              </div>
                          @enderror
                      </div>

                      <div class="form-group mb-3">
                          <label class="font-weight-bold">Dosen</label>
                          <select class="form-select mt-2 @error('dosen') is-invalid @enderror" aria-label="dosen" name="dosen">
                            <option selected>--- Pilih Dosen Pengampu ---</option>
                            {{-- @foreach ($dosen as $dsn)
                              <option value="{{ $dsn->id }}">{{ $dsn->nama }}</option>
                            @endforeach --}}
                          </select>
                          <!-- error message untuk fakultas -->
                          @error('dosen')
                              <div class="alert alert-danger mt-2">
                                  {{ $message }}
                              </div>
                          @enderror
                      </div>
                    
                      <div class="form-group mb-3">
                          <label class="font-weight-bold">Ruang Kelas</label>
                          <select class="form-select mt-2 @error('ruang') is-invalid @enderror" aria-label="ruang" name="ruang">
                            <option selected>--- Pilih Ruang Kelas ---</option>
                            {{-- @foreach ($kelas as $kls)
                              <option value="{{ $kls->id }}">{{ $kls->gedung }}-{{ $kls->no_ruang }}</option>
                            @endforeach --}}
                          </select>
                          <!-- error message untuk fakultas -->
                          @error('ruang')
                              <div class="alert alert-danger mt-2">
                                  {{ $message }}
                              </div>
                          @enderror
                      </div>
                    
                      <div class="form-group mb-3">
                          <label class="font-weight-bold">Kelas</label>
                          <input type="text" class="form-control mt-2 @error('kelas') is-invalid @enderror" name="kelas" value="" placeholder="Masukkan Kelas Jadwal">
                          <!-- error message untuk fakultas -->
                          @error('kelas')
                              <div class="alert alert-danger mt-2">
                                  {{ $message }}
                              </div>
                          @enderror
                      </div>

                      <div class="form-group mb-3">
                          <label class="font-weight-bold">Hari</label>
                          <select class="form-select mt-2 @error('hari') is-invalid @enderror" aria-label="hari" name="hari">
                            <option selected>--- Pilih Hari ---</option>
                            <option value="senin">Senin</option>
                            <option value="selasa">Selasa</option>
                            <option value="rabu">Rabu</option>
                            <option value="kamis">Kamis</option>
                            <option value="jumat">Jumat</option>
                            <option value="sabtu">Sabtu</option>
                           
                          </select>
                          <!-- error message untuk fakultas -->
                          @error('ruang')
                              <div class="alert alert-danger mt-2">
                                  {{ $message }}
                              </div>
                          @enderror
                      </div>

                      <div class="row">
                        <div class="col">
                          <div class="form-group mb-3">
                              <label class="font-weight-bold">Jam Mulai</label>
                              <input type="time" class="form-control mt-2 @error('mulai') is-invalid @enderror" name="mulai" value="" placeholder="Masukkan jam mulai">
                              <!-- error message untuk fakultas -->
                              @error('mulai')
                                  <div class="alert alert-danger mt-2">
                                      {{ $message }}
                                  </div>
                              @enderror
                          </div>
                        </div>
                        <div class="col">
                          <div class="form-group mb-3">
                              <label class="font-weight-bold">Jam Selesai</label>
                              <input type="time" class="form-control mt-2 @error('selesai') is-invalid @enderror" name="selesai" value="" placeholder="Masukkan jam selesai">
                              <!-- error message untuk fakultas -->
                              @error('selesai')
                                  <div class="alert alert-danger mt-2">
                                      {{ $message }}
                                  </div>
                              @enderror
                          </div>
                        </div>
                      </div>

                      <div class="form-group mb-3">
                          <label class="font-weight-bold">Kuota</label>
                          <input type="number" class="form-control mt-2 @error('kuota') is-invalid @enderror" name="kuota" value="" placeholder="Masukkan kuota">
                          <!-- error message untuk fakultas -->
                          @error('kuota')
                              <div class="alert alert-danger mt-2">
                                  {{ $message }}
                              </div>
                          @enderror
                      </div>
                  </div>
                  <div class="modal-footer">
                      <button type="submit" class="btn btn-success">Simpan</button>
                  </div>
              </form> 
          </div>
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

