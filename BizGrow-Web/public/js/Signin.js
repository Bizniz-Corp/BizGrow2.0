$(document).ready(function () {
    $("#loginForm").submit(function (e) {
        e.preventDefault(); // Mencegah form untuk refresh halaman saat submit

        var email = $("#email").val(); // Ambil nilai email dari input
        var password = $("#password").val(); // Ambil nilai password dari input

        $.ajax({
            url: "/api/login", // Endpoint API untuk login
            type: "POST", // Menggunakan metode POST
            data: {
                email: email,
                password: password,
            },
            success: function (response) {
                console.log("Respons API: ", response);

                if (response.data.token) {
                    localStorage.setItem(
                        "Authorization",
                        `Bearer ${response.data.token}`
                    );
                    localStorage.setItem("token", response.data.token); // Simpan token di localStorage

                    // Tampilkan modal sukses
                    $("#successMessage").html("Login berhasil! Anda akan diarahkan ke halaman utama.");
                    var successModal = new bootstrap.Modal(document.getElementById("successModal"));
                    successModal.show();

                    // Redirect setelah beberapa detik
                    setTimeout(() => {
                        window.location.href = "/home";
                    }, 2000);
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

                // Tampilkan modal error
                $("#errorMessage").html("Email atau password salah!");
                var errorModal = new bootstrap.Modal(document.getElementById("errorModal"));
                errorModal.show();
            },
        });
    });
});
