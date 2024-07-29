
document.addEventListener('DOMContentLoaded', function () {
    let kelasInput = document.getElementById('kelasInput');
    let pertemuanInput = document.getElementById('pertemuanInput');
    let btnContainer = document.getElementById('buttonContainer');
    

    if (kelasInput.value == '0' || pertemuanInput.value != '0') {
        btnContainer.innerHTML='';
        btnContainer.innerHTML= '<button class="btn btn-success" disabled>Tampilkan</button>'
    }

    kelasInput.addEventListener('change', buttonChange);
    pertemuanInput.addEventListener('change', buttonChange);

    function buttonChange() {
        if (kelasInput.value != '0' && pertemuanInput.value != '0') {
            btnContainer.innerHTML='';
            btnContainer.innerHTML= '<button class="btn btn-success" id="tampilBtn" onclick="tampilData()">Tampilkan</button>'
        } else {
            btnContainer.innerHTML='';
            btnContainer.innerHTML= '<button class="btn btn-success" disabled>Tampilkan</button>'
        }
    }

});

// function tampilData() {
//     if (kelasInput.value == 0) {
//         return
//     }

//     let data = {
//         'id_jadwal' : kelasInput.value,
//         'pertemuan' : pertemuanInput.value,
//       }

//     fetch('/dsn/ubahabsen', {
//         method: 'POST', 
//         headers: {
//             'Content-Type': 'application/json',
//             'Accept': 'application/json',
//             "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
//         },
//         body: JSON.stringify(data)
//     })
//     .then(response => response.json())
//     .then(response => {
        
//         let data = response.data

//         let content = '';
//         let ketPresensi = '';

//         data.mahasiswa.forEach((mhs, index) => {
//             content += `
//                 <tr>
//                     <td class="text-center" style="width: 50px;">${index + 1}</td>
//                     <td class="text-center">${mhs.nim}</td>
//                     <td class="">${mhs.nama}</td>  
//                     <td class="" style="width: 100px;">
//                         <select class="form-select ket-select" id="inputKet-${mhs.nim}">
//                             <option value="-" ${ mhs.ket == '-' ? 'selected' : '' }>-</option>
//                             <option value="A" ${ mhs.ket == 'A' ? 'selected' : '' }>Alpha</option>
//                             <option value="H" ${ mhs.ket == 'H' ? 'selected' : '' }>Hadir</option>
//                             <option value="I" ${ mhs.ket == 'I' ? 'selected' : '' }>Izin</option>
//                             <option value="S" ${ mhs.ket == 'S' ? 'selected' : '' }>Sakit</option>
//                         </select>
//                     </td>  
//                 </tr>
//             `
//         });
//         document.getElementById('tableBody').innerHTML = '';
//         document.getElementById('tableBody').innerHTML = content;
//         document.getElementById('X').value = kelasInput.value;
//         document.getElementById('Y').value = pertemuanInput.value;

//     })
//     .catch(error => {
//         console.error('Gagal mengambil data:', error);
//     });
// }

// function test() {
//     let select = document.querySelectorAll('.ket-select') 

//     let data = [];

//     let absen = {
//         'id_jadwal': document.getElementById('X').value,
//         'pertemuan': document.getElementById('Y').value,
//     };

//     select.forEach(item => {
//         let npm = item.id.split('-')[1];

//         data.push({nim : npm, ket : item.value == '-' ? '': item.value })
//     })

//     console.log(data)

//     fetch('/dsn/ubahabsen/update', {
//         method: 'PUT', 
//         headers: {
//             'Content-Type': 'application/json',
//             'Accept': 'application/json',
//             "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
//         },
//         body: JSON.stringify({absen: absen, data : data})
//     })
//     .then(response => response.json())
//     .then(response => {
//         console.log(response)
//     })
//     .catch(error => {
//         console.error('Gagal mengambil data:', error);
//     });
// }
