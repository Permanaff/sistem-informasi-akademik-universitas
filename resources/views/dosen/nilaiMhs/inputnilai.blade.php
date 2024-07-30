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

  .col-nilai {
    width: 90px
  }
</style>


<!-- Custom styles for this template -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
<!-- Custom styles for this template -->
<link href="{{ asset('/css/dashboard.css') }}" rel="stylesheet">
{{-- <link href="{{ asset('/css/krstables.css') }}" rel="stylesheet"> --}}
@endsection

@section('content')
    
{{-- <div class="dropdown position-fixed bottom-0 end-0 mb-3 me-3 bd-mode-toggle">
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
</div> --}}
@include('admin/navbar')



<div class="container-fluid">
{{-- SIDEBARD --}}
<div class="row">
@include('dosen/sidebar')

{{-- CONTENT --}}
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Nilai Mahasiswa</h1>
  </div>

  <div class="mb-3 d-flex justify-content-end">
        <input type="text" class="form-control" id="search-bar" placeholder="Search" style="width: 250px" onkeyup="search()">
  </div>

  <div class="card card-rounded-top">
    <div class="card-header">
      <p class="fs-6 m-0">Input Nilai Mahasiswa</p>
    </div>
    <div class="card-body">
        <form action="{{ route('nilai.inputnilai') }}" method="POST">
            @csrf
            @foreach ($mahasiswa as $mhs)
                <div class="card card-mhs mb-3 rounded-0">
                    <div class="card-body">
                        <p class="fs-6 m-0 mb-3 fw-bold">{{ $mhs->nim }} - {{ $mhs->nama }}</p>
                        <div class="row">
                            <input type="hidden" name="nilai[{{ $mhs->nim }}][nim]" value="{{ $mhs->nim }}">
                            <div class="col">
                                <label for="inputEmail4" class="form-label">CPMK 1</label>
                                <input type="text" class="form-control" name="nilai[{{ $mhs->nim }}][cpmk1]" placeholder="CPMK 1" aria-label="cpmk1" value="{{ $mhs->nilai->cpmk1 }}">
                            </div>
                            <div class="col">
                                <label for="inputEmail4" class="form-label">CPMK 2</label>
                                <input type="text" class="form-control" name="nilai[{{ $mhs->nim }}][cpmk2]" placeholder="CPMK 2" aria-label="cpmk2" value="{{ $mhs->nilai->cpmk2 }}">
                            </div>
                            <div class="col">
                                <label for="inputEmail4" class="form-label">CPMK 3</label>
                                <input type="text" class="form-control" name="nilai[{{ $mhs->nim }}][cpmk3]" placeholder="CPMK 3" aria-label="cpmk3" value="{{ $mhs->nilai->cpmk3 }}">
                            </div>
                            <div class="col">
                                <label for="inputEmail4" class="form-label">CPMK 4</label>
                                <input type="text" class="form-control" name="nilai[{{ $mhs->nim }}][cpmk4]" placeholder="CPMK 4" aria-label="cpmk4" value="{{ $mhs->nilai->cpmk4 }}">
                            </div>
                            <div class="col">
                                <label for="inputEmail4" class="form-label">UTS</label>
                                <input type="text" class="form-control" name="nilai[{{ $mhs->nim }}][uts]" placeholder="UTS" aria-label="uts" value="{{ $mhs->nilai->uts }}">
                            </div>
                            <div class="col">
                                <label for="inputEmail4" class="form-label">UAS</label>
                                <input type="text" class="form-control" name="nilai[{{ $mhs->nim }}][uas]" placeholder="UAS" aria-label="uas" value="{{ $mhs->nilai->uas }}">
                            </div>
                            <div class="col">
                                <label for="inputEmail4" class="form-label">Nilai Akhir</label>
                                <input type="text" class="form-control" name="nilai[{{ $mhs->nim }}][total]" placeholder="Nilai Akhir" aria-label="total" value="{{ $mhs->nilai->nilai }}">
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </form>
    </div>
  </div>

  

</main>
{{-- CONTENT END --}}
</div>
</div>

@section('scripts')
<script src="{{ asset('/js/dashboard.js') }}"></script>
{{-- <script src="{{ asset('/js/dosen/daftar-mahasiswa.js') }}"></script> --}}
<script>
    function search() {
        let input, filter, cards, cardBody, p, i, txtValue;

        input = document.getElementById('search-bar');
        filter = input.value.toUpperCase();
        cards = document.getElementsByClassName('card-mhs');

        

        for (i = 0; i < cards.length; i++) {
            cardBody = cards[i].getElementsByClassName('card-body')[0];
            p = cardBody.getElementsByTagName('p')[0];
            txtValue = p.textContent || p.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                cards[i].style.display = "";
            } else {
                cards[i].style.display = "none";
            }
        }
    }
</script>
@endsection
@endsection
