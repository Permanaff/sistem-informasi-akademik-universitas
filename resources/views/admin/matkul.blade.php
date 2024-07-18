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
    <h1 class="h2">Matakuliah</h1>
  </div>

  <div class="card border-0">
    <div class="card-body">
        <button type="button" class="btn btn-md btn-success mb-3" id="showModalBtn">Tambah Matkul</button>
        <table class="table table-bordered">
            <thead>
                <tr class="text-center">
                    <th scope="col">Kode MK</th>
                    <th scope="col">Prodi</th>
                    <th scope="col">Matkul</th>
                    <th scope="col">SKS</th>
                    <th scope="col">Semester</th>
                    <th scope="col" style="width:20%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($matkuls as $matkul)
                    <tr>
                        <td class="text-center">{{ $matkul->kode_matkul }}</td>
                        <td class="text-center">{{ $matkul->prodis->nama_prodi }}</td>
                        <td class="text-center">{{ $matkul->nama_matkul }}</td>
                        <td class="text-center">{{ $matkul->sks }}</td>
                        <td class="text-center">{{ $matkul->semester }}</td>
                        <td>
                            <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="#" method="POST">
                                <a href="#" class="btn btn-sm btn-primary">EDIT</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <div class="alert alert-danger">
                        Data Fakultas Belum Tersedia
                    </div>
                @endforelse
            </tbody>
              
            <p>

            </p>
        </table>
    </div>
  </div>


  <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModal" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
              <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Matkul</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form action="{{ route('matkul.store') }}" method="POST" enctype="multipart/form-data">
                  <div class="modal-body"> 
                      @csrf
                      <div class="form-group mb-3">
                          <label class="font-weight-bold">Kode Matkul</label>
                          <input type="text" class="form-control mt-2 @error('kode_matkul') is-invalid @enderror" name="kode_matkul" value="" placeholder="Masukkan Kode Matkul">
                          <!-- error message untuk fakultas -->
                          @error('kode_matkul')
                              <div class="alert alert-danger mt-2">
                                  {{ $message }}
                              </div>
                          @enderror
                      </div>

                      <div class="form-group mb-3">
                        <label class="font-weight-bold">Program Studi</label>
                        <select class="form-select mt-2 @error('prodi') is-invalid @enderror" aria-label="prodi" name="prodi">
                          <option selected>--- Pilih Program Studi ---</option>
                          @foreach ($prodis as $prodi)
                            <option value="{{ $prodi->id }}">{{ $prodi->nama_prodi }}</option>
                          @endforeach
                          
                        </select>
                        <!-- error message untuk fakultas -->
                        @error('prodi')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                      <div class="form-group mb-3">
                          <label class="font-weight-bold">Matakuliah</label>
                          <input type="text" class="form-control mt-2 @error('matkul') is-invalid @enderror" name="matkul" value="" placeholder="Masukkan Matakuliah">
                          <!-- error message untuk fakultas -->
                          @error('matkul')
                              <div class="alert alert-danger mt-2">
                                  {{ $message }}
                              </div>
                          @enderror
                      </div>
                      

                      <div class="form-group mb-3">
                          <label class="font-weight-bold">SKS</label>
                          <input type="number" class="form-control mt-2 @error('sks') is-invalid @enderror" name="sks" value="" placeholder="Masukkan Jumlah SKS">
                          <!-- error message untuk fakultas -->
                          @error('sks')
                              <div class="alert alert-danger mt-2">
                                  {{ $message }}
                              </div>
                          @enderror
                      </div>

                      <div class="form-group mb-3">
                          <label class="font-weight-bold">Semester</label>
                          <select class="form-select mt-2 @error('smt') is-invalid @enderror" aria-label="smt" name="smt">
                              <option selected>--- Pilih Semster ---</option>
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                              <option value="4">4</option>
                              <option value="5">5</option>
                              <option value="6">6</option>
                              <option value="7">7</option>
                              <option value="8">8</option>
                          </select>
                          <!-- error message untuk fakultas -->
                          @error('smt')
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
<script src="{{ asset('/js/prodi.js') }}"></script>

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

