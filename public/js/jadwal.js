
document.addEventListener('DOMContentLoaded', function () {
  // Ambil elemen modal dan tombol
  var myModal = new bootstrap.Modal(document.getElementById('tambahModal'), {
      keyboard: false
  });

  var showModalBtn = document.getElementById('showModalBtn');

  // Tambahkan event listener ke tombol untuk menampilkan modal
  showModalBtn.addEventListener('click', function () {
      myModal.show();
  });
});

new window.simpleDatatables.DataTable("#jadwalTable", {
  scrollX: true
})

