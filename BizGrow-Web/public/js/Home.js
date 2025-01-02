document.addEventListener("DOMContentLoaded", function () {
    // Ambil elemen profit box
    const profitPembelian = document.getElementById("profit-pembelian");
    const profitPenjualan = document.getElementById("profit-penjualan");

    // Tambahkan event listener untuk profit pembelian
    if (profitPembelian) {
        profitPembelian.addEventListener("click", function () {
            alert("Angka total pembelian yang ditampilkan hanya untuk bulan ini.");
        });
    }

    // Tambahkan event listener untuk profit penjualan
    if (profitPenjualan) {
        profitPenjualan.addEventListener("click", function () {
            alert("Angka total penjualan yang ditampilkan hanya untuk bulan ini.");
        });
    }
});
