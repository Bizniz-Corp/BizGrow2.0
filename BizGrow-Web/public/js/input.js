function showAlert(type) {
    if (type === 'manual') {
        alert("Anda memilih Input Data Manual. Anda dapat melakukan input untuk setiap produk pada suatu tanggal.");
    } else if (type === 'file') {
        alert("Anda memilih Input Data File. Anda dapat melakukan input secara mudah dengan mengupload file dengan format .csv atau .xlsx .");
    }
}

function navigateToPage(type) {
    if (type === 'manual') {
        window.location.href = '../pages/input_penjualan_manual.html';
    } else if (type === 'file') {
        window.location.href = "../pages/input_penjualan_file.html";
    }
}
