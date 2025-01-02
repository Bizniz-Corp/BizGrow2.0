function showAlertAndNavigate(type) {
    let message;
    if (type === "manual") {
        message =
            "Anda memilih Input Data Manual. Anda dapat melakukan input untuk setiap produk pada suatu tanggal.";
    } else if (type === "file") {
        message =
            "Anda memilih Input Data File. Anda dapat melakukan input secara mudah dengan mengupload file dengan format .csv atau .xlsx.";
    }

    if (confirm(message)) {
        navigateToPage(type);
    }
}

function navigateToPage(type) {
    if (type === "manual") {
        window.location.href = "/stok/input-manual";
    } else if (type === "file") {
        window.location.href = "/stok/input-file";
    }
}
