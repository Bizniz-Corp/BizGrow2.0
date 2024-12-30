$(document).ready(function() {
    $('#loginForm').submit(function(e) {
        e.preventDefault();  // Mencegah form untuk refresh halaman saat submit

        var email = $('#email').val();  // Ambil nilai email dari input
        var password = $('#password').val();  // Ambil nilai password dari input

        $.ajax({
            url: '/api/login',  // Endpoint API untuk login
            type: 'POST',  // Menggunakan metode POST
            data: {
                email: email,  // Data email
                password: password  // Data password
            },
            success: function(response) {
                if (response.token) {
                    localStorage.setItem('token', response.token);  // Simpan token di localStorage
                    alert('Login berhasil!');
                    // Lakukan redirect atau tindakan lainnya sesuai kebutuhan
                }
            },
            error: function(xhr, status, error) {
                alert('Email atau password salah!');
            }
        });
    });
});
