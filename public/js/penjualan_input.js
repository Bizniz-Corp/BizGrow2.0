function showAlertAndNavigate(type) {
    navigateToPage(type);
}

function navigateToPage(type) {
    if (type === "manual") {
        window.location.href = "/penjualan/input-manual";
    } else if (type === "file") {
        window.location.href = "/penjualan/input-file";
    }
}
