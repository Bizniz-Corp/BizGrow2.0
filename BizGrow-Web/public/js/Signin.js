$(document).ready(function () {
    $("#loginForm").submit(function (e) {
        e.preventDefault(); // Mencegah form untuk refresh halaman saat submit

        var email = $("#email").val(); // Ambil nilai email dari input
        var password = $("#password").val(); // Ambil nilai password dari input

        $.ajax({
            url: "/api/login", // Endpoint API untuk login
            type: "POST", // Menggunakan metode POST
            data: {
                email: email, // Data email
                password: password, // Data password
            },
            success: function (response) {
                console.log("Respons API: ", response);
                if (response.data.token) {
                    localStorage.setItem(
                        "Authorization",
                        `Bearer ${response.data.token}`
                    );
                    localStorage.setItem("token", response.data.token); // Simpan token di localStorage
                    alert("Login berhasil!");
                    window.location.href = "/home";
                    //Buat kirim request authorization ke halaman lain
                    // $.ajax({
                    //     url: "/home", // Gantilah dengan route yang sesuai
                    //     type: "GET",
                    //     headers: {
                    //         Authorization: `Bearer ${response.data.token}`, // Kirimkan token dalam header
                    //     },
                    //     success: function (homeResponse) {
                    //         console.log("Berhasil ke halaman home");
                    //         window.location.href = "/home"; // Redirect ke halaman home atau halaman lain
                    //     },
                    //     error: function () {
                    //         console.error("Gagal akses halaman home");
                    //     },
                    // });
                } else {
                    console.log("Token tidak ada dalam respons API");
                }
            },
            error: function (xhr, status, error) {
                console.error("Error API: ", {
                    status: xhr.status,
                    responseText: xhr.responseText,
                    error: error,
                });
                alert("Email atau password salah!");
            },
        });
    });
});
