


// document.addEventListener('DOMContentLoaded', function () {
//   // Ambil elemen modal dan tombol
//   var myModal = new bootstrap.Modal(document.getElementById('tambahModal'), {
//       keyboard: false
//   });

//   var showModalBtn = document.getElementById('showModalBtn');

//   // Tambahkan event listener ke tombol untuk menampilkan modal
//   showModalBtn.addEventListener('click', function () {
//       myModal.show();
//   });
// });


document.addEventListener('DOMContentLoaded', function () {
  // Get all nav-link elements
  const navLinks = document.querySelectorAll('.nav-link');

  // Function to set the active class based on the current URL
  function setActiveLink() {
    const currentPath = window.location.pathname;

    navLinks.forEach(function (link) {
      // Remove 'active' class from all nav-links
      link.classList.remove('active');

      // Add 'active' class to the link with matching href
      if (link.getAttribute('href') === currentPath) {
        link.classList.add('active');
      }
    });
  }

  // Set the active link on page load
  setActiveLink();

  // Optional: Update active link when navigating within a single-page application
  // navLinks.forEach(function (link) {
  //   link.addEventListener('click', function () {
  //     setTimeout(setActiveLink, 0);
  //   });
  // });
});
