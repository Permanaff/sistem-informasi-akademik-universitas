function sendData() {
    let xhr = new XMLHttpRequest();
    let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    let data = JSON.stringify({
        matkul: document.getElementById("matkul").value,
        pertemuan: document.getElementById("pertemuan").value,
        mulai: document.getElementById("mulai").value,
        selesai: document.getElementById("batas").value,
    });


    xhr.open("POST", "/dsn/presensi", true);
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xhr.setRequestHeader("X-CSRF-TOKEN", token);

    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let response = JSON.parse(xhr.responseText);

                let kode_absen = response.data.kode_absen;

                document.getElementById('inputKode').innerHTML = "";
                document.getElementById('inputKode').innerHTML = `
                  <input type="text" class="form-control mt-3" id="awal" value="`+ kode_absen +`" readonly>`;
            } else {
                // Terjadi error
                console.error("Error:", xhr.statusText);
            }
        }
    };

  xhr.send(data);
  }