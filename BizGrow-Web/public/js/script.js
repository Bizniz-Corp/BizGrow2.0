$(document).ready(function () {
    const hamBurger = document.querySelector(".toggle-btn");

    hamBurger.addEventListener("click", function () {
        document.querySelector("#sidebar").classList.toggle("expand");
    });

    // Mengecek apakah ada token di localStorage
    var token = localStorage.getItem("token");

    // Jika tidak ada token, alihkan ke halaman login
    if (!token) {
        $("#loginModal").modal("show");
    } else {
        // Tampilkan halaman atau lanjutkan dengan logika lainnya
        console.log("Token ditemukan, menampilkan halaman...");

        // $.ajax({
        //     url: "/api/profile",
        //     type: "GET",
        //     headers: {
        //         Authorization: `Bearer ${token}`,
        //     },
        //     success: function (response) {
        //         console.log("Berhasil memuat profile", response);
        //         // Update nama user di navbar
        //         $("#userName").text(response.data.name);
        //     },
        //     error: function () {
        //         console.log("Gagal memuat profile.");
        //     },
        // });
    }

    // Menangani klik logout untuk menampilkan modal
    $("#logoutButton").click(function (e) {
        e.preventDefault(); // Mencegah navigasi default

        // Tampilkan modal konfirmasi logout
        $("#logoutModal").modal("show");
    });

    // Menangani klik "Keluar" di modal untuk logout
    $("#confirmLogoutButton").click(function () {
        // Kirim API logout ke backend
        $.ajax({
            url: "/api/logout", // API endpoint untuk logout
            type: "POST", // Logout menggunakan metode POST
            headers: {
                Authorization: "Bearer " + localStorage.getItem("token"), // Pastikan token sudah ada di header
            },
            success: function (response) {
                console.log("Logout berhasil", response);
                localStorage.removeItem("Authorization");
                localStorage.removeItem("token");

                // Arahkan pengguna ke halaman login
                window.location.href = "/login";
            },
            error: function (xhr, status, error) {
                console.error("Logout gagal", error);
                alert("Terjadi kesalahan, coba lagi.");
            },
        });

        // Tutup modal setelah logout
        $("#logoutModal").modal("hide");
    });

    $("#batalButton").click(function () {
        $("#logoutModal").modal("hide");
    });

    // Tombol Oke pada modal login (redirect ke login page)
    $("#redirectToLoginButton").click(function () {
        window.location.href = "/login";
    });
});
