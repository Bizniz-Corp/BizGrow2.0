$(document).ready(function () {
    const token = localStorage.getItem("token");

    $("#inputForm").submit(function (e) {
        e.preventDefault();

        var formData = new FormData(this); // Ambil semua input form, termasuk file

        $.ajax({
            url: "/api/input-file-sales",
            type: "POST",
            headers: {
                Authorization: `Bearer ${token}`,
            },
            data: formData,
            processData: false, // WAJIB untuk FormData
            contentType: false, // WAJIB untuk FormData
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
                var errorMessage =
                    xhr.responseJSON?.message || "Terjadi kesalahan";
                $("#errorMessageAddSales").html(errorMessage);
                var errorModal = new bootstrap.Modal(
                    document.getElementById("errorModalAddSales")
                );
                errorModal.show();
            },
        });
    });
});
