<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @foreach ($mahasiswa as $mhs)
        <title>Kartu Rencana Studi_{{ $mhs->nim }}_{{ $mhs->nama }}</title>
    @endforeach
    <style>
        .table-bordered {
          border: 5px;
        }
    
        ul {
          list-style: none;
          padding-left: 0;
        }
    
        .alignMe p {
          display: inline-block;
          width: 15%;
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
          display: inline-block;
          vertical-align: top;
        }
    
        .alignMe span {
            position: absolute;
            font-size: 14px;
            margin-top: 13px;
        }
    
        @media (max-width: 1327px) {
          .alignMe p {
            width: 31%;
            margin-right: 5px;
          }
    
          .alignMe p::after {
            content: ":";
            position: absolute;
            right: 5px;
          }
        }
    
        .container {
          width: 100%;
          padding-right: 25px;
          padding-left: 15px;
          margin-right: auto;
          margin-left: auto;
        }
    
        .row {
          display: table;
          width: 100%;
          table-layout: fixed;
        }
    
        .col-2, .col {
          display: table-cell;
          padding: 0 15px;
        }
    
        .col-2 {
          width: 16.666667%;
        }
    
        .col {
          width: auto;
        }
    
        .m-0 {
          margin: 0;
        }
    
        .p-0 {
          padding: 0;
        }
    
        .fs-3 {
          font-size: 1.75rem;
        }
    
        .fw-bold {
          font-weight: bold;
        }
    
        .ms-3 {
          margin-left: 1rem;
        }
    
        .my-1 {
          margin-top: 0.25rem;
          margin-bottom: 0.25rem;
        }
    
        .mx-2 {
          margin-left: 0.5rem;
          margin-right: 0.5rem;
        }
    
        .line {
          border: 0;
          border-top: 0.1px solid black;
        }
    
        .text-center {
          text-align: center;
        }
    
        .fs-6 {
          font-size: 1rem;
        }

        .fs-5 {
          font-size: 14px;
        }
    
        .table {
          width: 100%;
          margin-bottom: 1rem;
          border-collapse: collapse;
        }
    
        .table-bordered th, .table-bordered td {
          border: 1px solid #000000;
          padding: 8px;
        }
    
        .table th {
          text-align: center;
        }
      </style>
    </head>
    <body>
    
      <div class="container">
        <div class="row">
          <div class="col-2">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents($path)) }}" alt="logo" width="120px">
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
      <p class="text-center fs-6 fw-bold" style="margin-bottom: 0px">KARTU RENCANA STUDI SEMESTER {{ strtoupper($ta->semester) }} TA. {{ $ta->tahun_ajaran }}</p>
      <div class="container" style="margin-top: 0px !important;">
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
      </div>
      <div class="container" style="margin-right: 500px !important">
        <table class="table table-bordered" id="jadwalTable" style="margin-right: 50px">
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
    
    </body>
</html>