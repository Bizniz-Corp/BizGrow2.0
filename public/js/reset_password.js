$(document).ready(function () {
    var token = $("#token").val();
    if (!token) {
        window.location.href = "/login";
    }
    $("#forgotPasswordForm").submit(function (e) {
        e.preventDefault();

        var password = $("#password").val();
        var confirmPassword = $("#passwordConfirm").val();

        if (password !== confirmPassword) {
            console.log("Password tidak cocok");
            // Tampilkan modal error jika password tidak cocok
            $("#errorMessage").html(
                "Password dan konfirmasi password tidak cocok."
            );
            var errorModal = new bootstrap.Modal(
                document.getElementById("errorModal")
            );
            errorModal.show();
            return;
        } else {
            $.ajax({
                url: "/api/reset-password", // Endpoint API untuk reset password
                type: "POST", // Menggunakan metode POST
                data: {
                    token: token,
                    password: password,
                },
                success: function (response) {
                    console.log("Respons API: ", response);

                    // Tampilkan modal sukses
                    $("#successMessage").html(
                        "Permintaan reset password berhasil! Silakan periksa email Anda."
                    );
                    var successModal = new bootstrap.Modal(
                        document.getElementById("successModal")
                    );
                    successModal.show();

                    // Redirect setelah beberapa detik
                    setTimeout(() => {
                        window.location.href = "/login";
                    }, 2000);
                },
                error: function (xhr, status, error) {
                    console.error("Error: ", {
                        status: xhr.status,
                        responseText: xhr.responseText,
                        error: error,
                    });

                    var errorMessage = xhr.responseJSON.message;
                    console.log("Pesan error: ", errorMessage);

                    // Tampilkan modal error
                    $("#errorMessage").html(errorMessage);
                    var errorModal = new bootstrap.Modal(
                        document.getElementById("errorModal")
                    );
                    errorModal.show();
                },
            });
        }
    });
});
