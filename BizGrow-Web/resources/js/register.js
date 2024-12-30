$(document).ready(function() {
    $('#registerForm').submit(function(e) {
        e.preventDefault();  // Mencegah form untuk refresh halaman saat submit

        var formData = new FormData(this);  // Mengambil semua data form termasuk file

        $.ajax({
            url: '/api/register',  // Endpoint API untuk registrasi
            type: 'POST',  // Menggunakan metode POST
            data: formData,  // Data yang dikirim (termasuk file)
            processData: false,  // Menonaktifkan pengolahan data secara otomatis oleh jQuery
            contentType: false,  // Menonaktifkan pengaturan header Content-Type secara otomatis
            success: function(response) {
                if (response.message === 'Register berhasil!') {
                    alert('Pendaftaran berhasil!');
                    // Lakukan redirect atau tindakan lainnya sesuai kebutuhan
                }
            },
            error: function(xhr, status, error) {
                var errorMessage = xhr.responseJSON?.error || 'Terjadi kesalahan saat register';
                alert(errorMessage);
            }
        });
    });
});
