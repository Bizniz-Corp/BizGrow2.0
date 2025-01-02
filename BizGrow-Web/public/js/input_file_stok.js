const fileInputStok = document.getElementById('fileInputStok');
const infoMessageStok = document.getElementById('infoMessageStok');
const submitButtonStok = document.getElementById('submitButtonStok');

fileInputStok.addEventListener('change', function() {
    if (fileInputStok.files.length > 0) {
        infoMessageStok.textContent = `File yang dipilih: ${fileInputStok.files[0].name}`;
        submitButtonStok.disabled = false;
    } else {
        infoMessageStok.textContent = 'File belum dipilih';
        submitButtonStok.disabled = true;
    }
});
