
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

    fetch('/dsn/absenmahasiswa', {
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
        
        let data = response.data
        let mahasiswa = data.mahasiswa
        
      
        let content = '';

        

        data.mahasiswa.forEach((mhs, index) => {
            const riwayatAbsensArray = Object.values(mhs.riwayat_absen);

            content += `
                <tr  id="dataAbsen">
                    <td class="text-center" style="width: 50px;">${index + 1}</td>
                    <td class="text-center">${mhs.nim}</td>
                    <td class="text-center">${mhs.nama}</td>  
            `
            riwayatAbsensArray.forEach((absen, index) => {
                content += `
                    <td class="text-center">${absen.ket}</td>
                `
            })
            // for (let i = mhs.ket.length; i < 14; i++) {
            //     content += `
            //         <td class="text-center" style="width: 50px;"></td>
            //     `;
            // }
            content += '</tr>';

        });
        document.getElementById('tableBody').innerHTML = '';
        document.getElementById('tableBody').innerHTML = content;
        
        if (mahasiswa.length === 0) {
            document.getElementById('tableBody').innerHTML = `<tr><td colspan='17' class='text-center'>Belum Ada Data Mahasiswa!</td></tr>`
        }

    })
    .catch(error => {
        console.error('Gagal mengambil data:', error);
    });
}
