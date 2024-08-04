<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Rencana Studi</title>
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
            font-size: 12px;
            margin-top: 15px;
        }
  
        @media (max-width: 1327px) {
            .alignMe p {
                width: 10%;
            }
    
            .alignMe p::after {
                content: ":";
                position: absolute;
                right: 5px;
            }
        }

        .d-flex {
            display: flex;
        }
        
        .row {
            display: flex;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
        }
        
        .col-2 {
            flex: 0 0 16.666667%;
            max-width: 16.666667%;
            padding: 0 15px;
        }
        
        .col {
            flex: 1;
            padding: 0 15px;
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
            /* height: 5px; */
        }
        
        .text-center {
            text-align: center;
        }
        
        .fs-6 {
            font-size: 1rem;
        }
        
        
        .table {
            width: 100%;
            margin-bottom: 1rem;
            border-collapse: collapse;
        }
        
        .table-bordered th, .table-bordered td {
            border: 1px solid #dee2e6;
            padding: 8px;
        }
        
        .table th {
            text-align: center;
        }
  </style>

</head>
<body>

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
              <li><p style="font-size: 12px;">Nama</p> <span>{{ $mhs->nama }}</span></li>
              <li><p style="font-size: 12px;">No. Mahasiswa</p> <span>{{ $mhs->nim }}</span></li>
            </ul>
          </div>
          <div class="col">
            <ul class="alignMe">
              <li><p style="font-size: 12px;">Program Studi</p> <span class="fw-bold">{{ Str::title($mhs->jenjang) }} - {{ $mhs->prodi }}</span></li>
              <li><p style="font-size: 12px;">Dosen Wali</p> <span class="fw-bold">{{ $mhs->dosen }}</span></li>
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

</body>
</html>
