// document.addEventListener('DOMContentLoaded', function () {
// });
console.log('scripts-main.js')
console.log( document.querySelector('.table'))
function updateClassBasedOnSize() {
    var element = document.querySelector('.table');
    if (window.innerWidth < 768) {
        element.classList.add('scroll-table');
        // element.classList.remove('large-screen');
    } else {
        // element.classList.add('large-screen');
        element.classList.remove('scroll-table');
    }
}

// Initial check
updateClassBasedOnSize();

// Update on resize
window.addEventListener('resize', updateClassBasedOnSize);

