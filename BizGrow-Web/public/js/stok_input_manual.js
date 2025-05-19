$(document).ready(function () {
    const token = localStorage.getItem("token");
    console.log("Token: ", token);
    fetchProductList();
    // Fungsi untuk memuat daftar produk
    function fetchProductList() {
        $.ajax({
            url: "/api/products",
            method: "GET",
            headers: {
                Authorization: `Bearer ${token}`,
            },
            success: function (response) {
                if (response.success) {
                    let options = "";
                    response.data.forEach((product) => {
                        options += `<option value="${product.product_id}">${product.product_name}</option>`;
                    });
                    $("#namaProduk").html(options);
                }
            },
            error: function (xhr, status, error) {
                console.error(
                    "Failed to fetch product list:",
                    xhr.responseText
                );
            },
        });
    }

    $("#inputForm").submit(function (e) {
        e.preventDefault(); // Mencegah form untuk refresh halaman saat submit

        $.ajax({
            url: "/api/input-manual-sales", // Endpoint API untuk input manual
            type: "POST", // Menggunakan metode POST
            headers: {
                Authorization: `Bearer ${token}`,
            },
            data: {
                product_id: $("#namaProduk").val(),
                kuantitas: $("#kuantitas").val(),
                harga: $("#harga").val(),
                tanggal: $("#tanggal").val(),
            },
            success: function (response) {
                console.log("Respons API: ", response);
                // Tampilkan modal sukses
                $("#successMessageAddSales").html(
                    "Input data penjualan berhasil!"
                );
                var successModal = new bootstrap.Modal(
                    document.getElementById("successModalAddSales")
                );
                successModal.show();
            },
            error: function (xhr, status, error) {
                console.error("Error API: ", {
                    status: xhr.status,
                    responseText: xhr.responseText,
                    error: error,
                });

                var errorMessage = xhr.responseJSON.message;
                console.log("Pesan error: ", errorMessage);

                // Tampilkan modal error
                $("#errorMessageAddSales").html(errorMessage);
                var errorModal = new bootstrap.Modal(
                    document.getElementById("errorModalAddSales")
                );
                errorModal.show();
            },
        });
    });

    $("#simpanProduk").click(function () {
        $.ajax({
            url: "/api/products",
            method: "POST",
            headers: {
                Authorization: `Bearer ${token}`,
            },
            data: {
                product_name: $("#namaProdukBaru").val(),
                price: $("#hargaProdukBaru").val(),
                product_quantity: $("#quantityProdukBaru").val(),
            },
            success: function (response) {
                if (response.success) {
                    // Tampilkan modal sukses
                    $("#successMessageAddProduct").html(
                        "Input produk baur berhasil!"
                    );
                    var successModal = new bootstrap.Modal(
                        document.getElementById("successModalAddProduct")
                    );
                    successModal.show();
                }
            },
            error: function (xhr, status, error) {
                console.error(
                    "Gagal menambahkan produk baru: ",
                    xhr.responseText
                );
                // Tampilkan modal error
                $("#errorMessageAddProduct").html(errorMessage);
                var errorModal = new bootstrap.Modal(
                    document.getElementById("errorModalAddProduct")
                );
                errorModal.show();
            },
        });
    });
});
