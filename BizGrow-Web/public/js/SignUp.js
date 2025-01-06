$(document).ready(function () {
    $("#registerForm").submit(function (e) {
        e.preventDefault(); // Mencegah form untuk refresh halaman saat submit

        var formData = new FormData(this); // Mengambil semua data form termasuk file
        console.log("Data yang dikirim:", formData);

        $.ajax({
            url: "/api/register",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.message === "Register berhasil!") {
                    alert("Register:" + response.data);
                    alert("Pendaftaran berhasil!");
                    // Lakukan redirect atau tindakan lainnya sesuai kebutuhan
                    window.location.href = "/login";
                }
            },
            error: function (xhr, status, error) {
                var errorMessage =
                    xhr.responseJSON?.error ||
                    "Terjadi kesalahan saat register";
                alert(errorMessage);
            },
        });
    });
});
