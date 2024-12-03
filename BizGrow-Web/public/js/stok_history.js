$(document).ready(function() {
    const filterModal = new bootstrap.Modal($('#filterModal')[0]);

    // Load data dari JSON dan tampilkan di tabel
    function loadTableData() {
        $.getJSON('../stok.json', function(data) {
            let rows = '';
            data.forEach((item, index) => {
                rows += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.tanggal}</td>
                        <td>${item.id}</td>
                        <td>${item.produk}</td>
                        <td>${item.perubahan.toLocaleString()}</td>
                        <td>${item.total.toLocaleString()} Stok</td>
                    </tr>
                `;
            });
            $('tbody').html(rows);

            rows = '<option value="all">Semua Produk</option>';
            const listNamaProduk = new Set();
            data.forEach((item) => {
                if (!listNamaProduk.has(item.produk)){
                    listNamaProduk.add(item.produk);
                    rows += `
                    <option value="${item.produk}">${item.produk}</option>
                `;
                }
            })
            $('#productFilter').html(rows);
        });
    }

    // Tampilkan data awal
    loadTableData();

    // Tampilkan filter modal
    $('#filterButton').on('click', function() {
        filterModal.show();
    });

    // Terapkan filter
    $('#applyFilter').on('click', function() {
        const selectedProduct = $('#productFilter').val();
        const startDate = $('#startDate').val();
        const endDate = $('#endDate').val();
        applyFilter(selectedProduct, startDate, endDate);
        filterModal.hide();
    });

    // Reset filter
    $('#resetButton').on('click', function() {
        $('#productFilter').val('all');
        $('#startDate').val('');
        $('#endDate').val('');
        loadTableData();
    });

    // Fungsi untuk menerapkan filter
    function applyFilter(selectedProduct, startDate, endDate) {
        $.getJSON('../stok.json', function(data) {
            let rows = '';
            let no = 1;

            // Buat objek tanggal dari startDate dan endDate
            const startDateObj = startDate ? new Date(startDate) : null;
            const endDateObj = endDate ? new Date(endDate) : null;

            data.forEach((item) => {
                const date = new Date(item.tanggal);

                // Filter berdasarkan produk dan rentang tanggal
                const productMatch = selectedProduct === "all" || item.produk === selectedProduct;
                const dateMatch = (!startDateObj || date >= startDateObj) && (!endDateObj || date <= endDateObj);

                if (productMatch && dateMatch) {
                    rows += `
                        <tr>
                            <td>${no}</td>
                            <td>${item.tanggal}</td>
                            <td>${item.id}</td>
                            <td>${item.produk}</td>
                            <td>${item.perubahan.toLocaleString()}</td>
                            <td>${item.total.toLocaleString()} Stok</td>
                        </tr>
                    `;
                    no += 1;
                }
            });
            $('tbody').html(rows); // Tampilkan hasil filter di tabel
        });
    }
});