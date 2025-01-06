document.addEventListener("DOMContentLoaded", function () {
    // Ambil elemen profit box
    const profitPembelian = document.getElementById("profit-pembelian");
    const profitPenjualan = document.getElementById("profit-penjualan");

    var token = localStorage.getItem("token");

    $.ajax({
        url: "/api/profile",
        type: "GET",
        headers: {
            Authorization: `Bearer ${token}`,
        },
        success: function (response) {
            $("#welcome").text("Selamat Datang, " + response.data.name);
        },
        error: function () {
            console.log("Gagal memuat profile.");
        },
    });

    // Tambahkan event listener untuk profit pembelian
    if (profitPembelian) {
        profitPembelian.addEventListener("click", function () {
            alert(
                "Angka total pembelian yang ditampilkan hanya untuk bulan ini."
            );
        });
    }

    // Tambahkan event listener untuk profit penjualan
    if (profitPenjualan) {
        profitPenjualan.addEventListener("click", function () {
            alert(
                "Angka total penjualan yang ditampilkan hanya untuk bulan ini."
            );
        });
    }
});
