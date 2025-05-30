$(document).ready(function () {
    const token = localStorage.getItem("token");

    $("#inputStockForm").submit(function (e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: "/api/input-file-stock",
            type: "POST",
            headers: {
                Authorization: `Bearer ${token}`,
            },
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                $("#successMessageAddStock").html(
                    "Input data perubahan stok berhasil!"
                );
                var successModal = new bootstrap.Modal(
                    document.getElementById("successModalAddStock")
                );
                successModal.show();
            },
            error: function (xhr, status, error) {
                var errorMessage =
                    xhr.responseJSON?.message || "Terjadi kesalahan";
                $("#errorMessageAddStock").html(errorMessage);
                var errorModal = new bootstrap.Modal(
                    document.getElementById("errorModalAddStock")
                );
                errorModal.show();
            },
        });
    });
});
