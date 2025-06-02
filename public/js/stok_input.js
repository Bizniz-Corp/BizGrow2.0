function showAlertAndNavigate(type) {
    navigateToPage(type);
}

function navigateToPage(type) {
    if (type === "manual") {
        window.location.href = "/stok/input-manual";
    } else if (type === "file") {
        window.location.href = "/stok/input-file";
    }
}
