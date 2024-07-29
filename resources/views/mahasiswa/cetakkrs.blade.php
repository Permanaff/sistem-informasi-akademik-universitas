@extends('layout/layout')

@section('head')

<!-- Custom styles for this template -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
<!-- Custom styles for this template -->
<link href="{{ asset('/css/dashboard.css') }}" rel="stylesheet">
{{-- <link href="{{ asset('/css/krstables.css') }}" rel="stylesheet"> --}}
<style>
  .table-bordered {
    border: 5px;
  }

  ul {
        list-style: none;
        padding-left: 0;
        flex-wrap: wrap;
    }

  .alignMe p {
      display: inline-block;
      width: 18%;
      position: relative;
      padding-right: 5px; 
      margin-bottom: 5px;
      
  }

  .alignMe p::after {
      content: ":";
      position: absolute;
      right: 10px;
  }

  .alignMe li {
      width: 100%;
      display: flex;
      align-items: flex-start;
      text-align: justify;
  }

  .alignMe span {
      font-size: 14px;
  }

  @media (max-width: 1327px) {
    .alignMe p {
      width: 30%;
    }

    .alignMe p::after {
      content: ":";
      position: absolute;
      right: 5px;
    }
  }


</style>
@endsection

@section('content')
    

{{-- CONTENT --}}
<div class="d-flex">
  <div class="row">
    <div class="col-2">
      <img src="{{ url('/images/logo.png') }}" alt="logo" width="120px">
    </div>
    <div class="col">
      <div class="row m-0 p-0">
          <p class="fs-3 fw-bold ms-3 m-0 p-0">U UNIVERSITAS</p>
          @foreach ($mahasiswa as $mhs)
          <p class="fs-3 fw-bold ms-3 m-0 p-0">FAKULTAS {{ strtoupper($mhs->fakultas) }}</p>
          @endforeach
      </div>
    </div>
  </div>
</div>
<hr class="my-1 mx-2 line" color="black" size="4">
<p class="text-center fs-6 fw-bold">KARTU RENCANA STUDI SEMESTER GENAP</p>
<div class="row">
  @foreach ($mahasiswa as $mhs)
    <div class="col">
      <ul class="alignMe">
        <li><p style="font-size: 14px;">Nama</p> <span class="fw-bold">{{ $mhs->nama }}</span></li>
        <li><p style="font-size: 14px;">No. Mahasiswa</p> <span class="fw-bold">{{ $mhs->nim }}</span></li>
      </ul>
    </div>
    <div class="col">
      <ul class="alignMe">
        <li><p style="font-size: 14px;">Program Studi</p> <span class="fw-bold">{{ Str::title($mhs->jenjang) }} - {{ $mhs->prodi }}</span></li>
        <li><p style="font-size: 14px;">Dosen Wali</p> <span class="fw-bold">{{ $mhs->dosen }}</span></li>
      </ul>
    </div>
  @endforeach
</div>
<div class="me-2 mt-0">
  <table class="table table-bordered" id="jadwalTable">
    <thead>
      <tr>
        <th class="text-center">No</th>
        <th class="text-center">Kode MK</th>
        <th class="text-center">Nama Matkuliah</th>
        <th class="text-center">SKS</th>
        <th class="text-center">Kls</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($krs as $index => $item)
          <tr>
            <td class="text-center">{{ $index + 1 }}</td>
            <td>{{ $item->kode_mk }}</td>
            <td>{{ $item->matkul }}</td>
            <td class="text-center">{{ $item->sks }}</td>
            <td class="text-center">{{ $item->kls }}</td>
          </tr>
      @endforeach
    </tbody>
  </table>
</div>




@section('scripts')
<script src="{{ asset('/js/dashboard.js') }}"></script>
{{-- <script src="{{ asset('/js/dosen/riwayat-absen.js') }}"></script> --}}
@endsection
@endsection

