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

</style>


<!-- Custom styles for this template -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
<!-- Custom styles for this template -->
<link href="{{ asset('/css/dashboard.css') }}" rel="stylesheet">
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
@include('admin/sidebar')

{{-- CONTENT --}}
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dosen</h1>
  </div>

  <div class="card border-0">
    <div class="card-body">
        <button type="button" class="btn btn-md btn-success mb-3" id="showModalBtn">Tambah Dosen</button>
        <table class="table table-striped table-bordered">
            <thead>
                <tr class="text-center">
                    <th scope="col">NIDN</th>
                    <th scope="col">Nama Lengkap</th>
                    <th scope="col">Fakultas</th>
                    {{-- <th scope="col">TTL</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">Agama</th> --}}
                    <th scope="col">No. Telp</th>
                    <th scope="col">Email</th>
                    <th scope="col">Jenis Kelamin</th>
                    <th scope="col" style="width:12%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($dosens as $dosen)
                    <tr>
                        <td class="text-center">{{ $dosen->nidn }}</td>
                        <td class="text">{{ $dosen->nama }}</td>
                        <td class="text-center">{{ Str::title($dosen->fakultas->nama_fakultas) }}</td>
                        <td class="text-center">{{ $dosen->notelp }}</td>
                        <td class="text-center">{{ $dosen->email }}</td>
                        <td class="text-center">{{ Str::title($dosen->jk) }}</td>
                        <td>
                          <div class="d-flex justify-content-center">
                            <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="#" method="POST">
                                <button class="btn btn-icon-primary"><i class="fa fa-info-circle"></i></button>
                                <button class="btn btn-icon-primary"><i class="fa fa-pencil-square-o"></i></button>
                                @csrf
                                @method('DELETE')
                                {{-- <button type="submit" class="btn btn-sm btn-danger">HAPUS</button> --}}
                                <button type="submit" class="btn btn-sm btn-icon-danger"><i class="fa fa-trash"></i></button>
                            </form>
                          </div>
                        </td>
                    </tr>
                @empty
                    <div class="alert alert-danger">
                        Data Fakultas Belum Tersedia
                    </div>
                @endforelse
            </tbody>
        </table>
    </div>
  </div>

  {{-- Modal Tambah Fakultas --}}
  <!-- Modal -->
    <!-- Modal -->
<div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Daftar Data Dosen</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('dosen.store') }}" method="POST" enctype="multipart/form-data">
                <div class="modal-body"> 
                    @csrf
                    <div class="form-group mb-3">
                        <label class="font-weight-bold">NIDN</label>
                        <input type="text" class="form-control mt-2 @error('nidn') is-invalid @enderror" name="nidn" value="" placeholder="NIDN">
                        <!-- error message untuk fakultas -->
                        @error('nidn')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Nama Lengkap</label>
                        <input type="text" class="form-control mt-2 @error('nama') is-invalid @enderror" name="nama" value="" placeholder="Nama Lengkap">
                        <!-- error message untuk fakultas -->
                        @error('nama')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Email</label>
                        <input type="email" class="form-control mt-2 @error('email') is-invalid @enderror" name="email" value="" placeholder="Email">
                        <!-- error message untuk fakultas -->
                        @error('email')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Nomor Telepon</label>
                        <input type="text" class="form-control mt-2 @error('no_telp') is-invalid @enderror" name="no_telp" value="" placeholder="No Telp">
                        <!-- error message untuk fakultas -->
                        @error('no_telp')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Nama Fakultas</label>
                        <select class="form-select mt-2" aria-label="fakultas" name="fakultas" id="fakultas">
                          <option selected>-- Pilih Fakultas --</option>
                          @foreach ($fakultas as $fakul)
                              <option value="{{ $fakul->id }}">{{ $fakul->nama_fakultas }}</option>
                          @endforeach
                          
                        </select>
                    
                        <!-- error message untuk fakultas -->
                        @error('fakultas')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Tempat Lahir</label>
                        <input type="text" class="form-control mt-2 @error('tempat_lahir') is-invalid @enderror" name="tempat_lahir" value="" placeholder="Tempat Lahir">
                        <!-- error message untuk fakultas -->
                        @error('tempat_lahir')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Tanggal Lahir</label>
                        <input type="Date" class="form-control mt-2 @error('tanggal_lahir') is-invalid @enderror" name="tanggal_lahir" value="" placeholder="Tanggal Lahir">
                        <!-- error message untuk fakultas -->
                        @error('tanggal_lahir')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Alamat Lengkap</label>
                        <textarea  type="text" class="form-control mt-2 @error('alamat') is-invalid @enderror" name="alamat" value="" placeholder="Alamat"></textarea>
                        <!-- error message untuk fakultas -->
                        @error('alamat')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                      <label class="font-weight-bold">Agama</label>
                      <select class="form-select mt-2" aria-label="fakultas" name="agama" id="agama">
                          <option selected>-- Pilih Agama --</option>
                          <option value="islam">Islam</option>
                          <option value="kristen">Kristen</option>
                          <option value="katolik">Katolik</option>
                          <option value="hindu">Hindu</option>
                          <option value="budha">Budha</option>
                          <option value="khonghucu">khonghucu</option>
                      </select>
                  
                      <!-- error message untuk fakultas -->
                      @error('agama')
                          <div class="alert alert-danger mt-2">
                              {{ $message }}
                          </div>
                      @enderror
                  </div>

                    <div class="form-group mb-3">
                      <label class="font-weight-bold">Jenis Kelamin</label>
                      <select class="form-select mt-2" aria-label="jk" name="jk" id="jk">
                          <option selected>-- Jenis Kelamin --</option>
                          <option value="laki-laki">Laki-Laki</option>
                          <option value="perempuan">Perempuan</option>
                      </select>
                  
                      <!-- error message untuk fakultas -->
                      @error('jk')
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
<script src="{{ asset('/js/fakultas.js') }}"></script>
<script src="{{ asset('/js/dashboard.js') }}"></script>

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

    // document.addEventListener("DOMContentLoaded", function(event) { 
    //     // const tambahModal = document.getElementById('exampleModal')
    //     const myModal = new bootstrap.Modal(document.getElementById('exampleModal'), options)
    // });



</script>


@endsection

@endsection

