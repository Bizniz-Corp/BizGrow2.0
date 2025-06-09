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

        $.ajax({
            url: "/api/profile",
            type: "GET",
            headers: {
                Authorization: `Bearer ${token}`,
            },
            success: function (response) {
                const user = response.data;

                const profilePicture =
                    document.getElementById("profilePicture");
                profilePicture.src = user.profile_picture
                    ? user.profile_picture
                    : /storage/profile_pict/default_avatar.jpg;
                    // : "/img/default-profile.png";

                const userName = document.getElementById("userName");
                userName.textContent = user.name;
            },
            error: function () {
                console.log("Gagal memuat profile.");
            },
        });
    }

    // Menangani klik logout untuk menampilkan modal
    $("#logoutButton").click(function (e) {

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

    $("#redirectToLoginButtonAutoLog").click(function () {
        window.location.href = "/login";
    });

    // Auto logout setelah 1 menit tidak ada aktivitas
    let idleTime = 0;
    let idleInterval = setInterval(timerIncrement, 60000); // 1 menit

    function timerIncrement() {
        idleTime += 1;
        if (idleTime >= 1) {
            // 1 menit
            autoLogout();
        }
    }

    // Reset idle timer jika ada aktivitas
    $(document).on("mousemove keydown click scroll", function () {
        idleTime = 0;
    });

    function autoLogout() {
        // Panggil endpoint logout via AJAX
        $.ajax({
            url: "/api/logout",
            method: "POST",
            headers: {
                Authorization: `Bearer ${token}`, // pastikan token sudah tersedia di JS
            },
            success: function () {
                // Tampilkan modal auto logout
                $("#autoLogoutModal").modal("show");
            },
            error: function () {
                console.error("Gagal melakukan auto logout");
                alert("Terjadi kesalahan saat melakukan auto logout.");
            },
        });
        clearInterval(idleInterval);
        localStorage.removeItem("token");
    }
});
