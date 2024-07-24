
document.addEventListener('DOMContentLoaded', function () {
    let kelasInput = document.getElementById('kelasInput');
    let btnContainer = document.getElementById('buttonContainer');
    

    // if (kelasInput.value == '0') {
    //     btnContainer.innerHTML='';
    //     btnContainer.innerHTML= '<button class="btn btn-success" disabled>Tampilkan</button>'
    // }

    kelasInput.addEventListener('change', buttonChange);

    function buttonChange() {
        if (kelasInput.value != '0') {
            btnContainer.innerHTML='';
            btnContainer.innerHTML= '<button class="btn btn-success" id="tampilBtn" onclick="tampilData()">Tampilkan</button>'
        } else {
            btnContainer.innerHTML='';
            btnContainer.innerHTML= '<button class="btn btn-success" disabled>Tampilkan</button>'
        }
    }

});

function tampilData() {
    let tableContainer = document.getElementById('tableContainer');
    let data = {
        'id_jadwal' : kelasInput.value
      }

    fetch('/dsn/daftarmahasiswa', {
        method: 'POST', 
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(response => {

        tableContainer.innerHTML = `
            <div class="card mt-3 card-rounded-bottom">
                <div class="card-body" id="tableMahasiswa">
                    <table class="table  table-bordered" id="jadwalTable">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col">No</th>
                                <th class="text-center" scope="col">NPM</th>
                                <th class="text-center" scope="col">Nama Mahasiswa</th>
                                <th class="text-center" scope="col">Angkatan</th>
                                <th class="text-center" scope="col">DPA</th>
                                <th class="text-center" scope="col">L/P</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                        </tbody>
                    </table>
                </div>
            </div>
        `
        let data = response.data

        let content = '';

        data.mahasiswa.forEach((mhs, index) => {
            content += `
                <tr>
                    <td class="text-center">${index + 1}</td>
                    <td class="text-center">${mhs.nim}</td>
                    <td class="text-center">${mhs.nama}</td>
                    <td class="text-center">${mhs.angkatan}</td>
                    <td class="text-center">${mhs.dpa}</td>
                    <td class="text-center">${mhs.jk === 'laki-laki' ? 'L' : 'P'}</td>
                </tr>      
            `
        });
        document.getElementById('tableBody').innerHTML = content;

    })
    .catch(error => {
        console.error('Gagal mengambil data:', error);
    });
}
