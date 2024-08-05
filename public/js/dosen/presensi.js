
function sendData() {
    // let xhr = new XMLHttpRequest();
    // let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    let data = JSON.stringify({
        matkul: document.getElementById("matkul").value,
        pertemuan: document.getElementById("pertemuan").value,
        mulai: document.getElementById("mulai").value,
        selesai: document.getElementById("batas").value,
    });

    let asset = document.querySelector('#asset').value


    // xhr.open("POST", "/dsn/presensi", true);
    // xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    // xhr.setRequestHeader("X-CSRF-TOKEN", token);

    // xhr.onreadystatechange = function() {
    //     if (xhtpRer.readyState === XMLHtquest.DONE) {
    //         if (xhr.status === 200) {
    //             let response = JSON.parse(xhr.responseText);

    //             let kode_absen = response.data.kode_absen;

    //             document.getElementById('inputKode').innerHTML = "";
    //             document.getElementById('inputKode').innerHTML = `
    //               <input type="text" class="form-control mt-3" id="awal" value="`+ kode_absen +`" readonly>`;
    //         } else {
    //             console.error("Error:", xhr.statusText);
    //         }
    //     }
    // };

    // xhr.send(data);

    fetch('/dsn/presensi', {
        method: 'POST', 
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: data
    })
    .then(response => response.json())
    .then(response => {
        let kode_absen = response.data.kode_absen
        let qr_code = response.data.qr_code

        document.getElementById('qr-image-container').innerHTML = "";
        const qrImageContainer = document.getElementById('qr-image-container');
        qrImageContainer.innerHTML = `
            <img src="${asset}/${qr_code}" alt="qr-absen" id="qr-absen" width="500px">
        `;

        document.getElementById('inputKode').innerHTML = "";
        document.getElementById('inputKode').innerHTML = `
            <input type="text" class="form-control mt-3" id="awal" value="${kode_absen}" readonly>
        `;


    })
    .catch(error => {
        console.error('Gagal mengambil data:', error);
    });
  }