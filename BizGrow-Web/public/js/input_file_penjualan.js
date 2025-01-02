// const fileInputStok = document.getElementById('fileInputStok');
// const infoMessageStok = document.getElementById('infoMessageStok');
// const submitButtonStok = document.getElementById('submitButtonStok');

// fileInputStok.addEventListener('change', function() {
//     if (fileInputStok.files.length > 0) {
//         infoMessageStok.textContent = `File yang dipilih: ${fileInputStok.files[0].name}`;
//         submitButtonStok.disabled = false;
//     } else {
//         infoMessageStok.textContent = 'File belum dipilih';
//         submitButtonStok.disabled = true;
//     }
// });

const fileInputPenjualan = document.getElementById('fileInputPenjualan');
const infoMessagePenjualan = document.getElementById('infoMessagePenjualan');
const submitButtonPenjualan = document.getElementById('submitButtonPenjualan');

fileInputPenjualan.addEventListener('change', function() {
    if (fileInputPenjualan.files.length > 0) {
        infoMessagePenjualan.textContent = `File yang dipilih: ${fileInputPenjualan.files[0].name}`;
        submitButtonPenjualan.disabled = false;
    } else {
        infoMessagePenjualan.textContent = 'File belum dipilih';
        submitButtonPenjualan.disabled = true;
    }
});