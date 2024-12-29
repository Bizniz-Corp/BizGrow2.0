$(document).ready(function() {
    const filterModal = new bootstrap.Modal($('#filterModal')[0]);

    // konversi tanggal dari format yyyy-mm-dd ke dd-mm-yyyy
    function formatDate(dateString) {
        const date = new Date(dateString);
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = date.getFullYear();
        return `${day}-${month}-${year}`;
    }

    // Load data dari JSON dan tampilkan di tabel
    function loadTableData() {
        $.ajax({
            url: '/api/stocks-history',
            method: 'GET',
            headers: {
                'Authorization': `Bearer 1|HYs2oQs2vtqNgqZbKl0p8Ovjz7ULRlLTInE4XYB4fa6028aa`
            },
            success: function(response) {
                if (response.success) {
                    const data = response.data;
                    let rows = '';
                    data.forEach((item, index) => {
                        rows += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${formatDate(item.changes_date)}</td>
                                <td>${item.stock_change_id}</td>
                                <td>${item.product_name}</td>
                                <td>${item.changes_quantity > 0 ? '+' : ''}${item.changes_quantity.toLocaleString()}</td>
                                <td>${item.total_stock.toLocaleString()} Stok</td>
                            </tr>
                        `;
                    });
                    $('tbody').html(rows);

                    rows = '<option value="all">Semua Produk</option>';
                    const listNamaProduk = new Set();
                    data.forEach((item) => {
                        if (!listNamaProduk.has(item.product_name)) {
                            listNamaProduk.add(item.product_name);
                            rows += `
                                <option value="${item.product_name}">${item.product_name}</option>
                            `;
                        }
                    });
                    $('#productFilter').html(rows);
                }
            },
            error: function(xhr, status, error) {
                console.error('Failed to fetch stock history:', xhr.responseText);
            }
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
        $.ajax({
            url: '/api/stocks-history',
            method: 'GET',
            headers: {
                'Authorization': `Bearer 1|HYs2oQs2vtqNgqZbKl0p8Ovjz7ULRlLTInE4XYB4fa6028aa`
            },
            success: function(response) {
                if (response.success) {
                    const data = response.data;
                    let rows = '';
                    let no = 1; // Inisialisasi nomor urut

                    // Buat objek tanggal dari startDate dan endDate
                    const startDateObj = startDate ? new Date(startDate) : null;
                    const endDateObj = endDate ? new Date(endDate) : null;

                    data.forEach(item => {
                        const date = new Date(item.changes_date);

                        // Filter berdasarkan produk dan rentang tanggal
                        const productMatch = selectedProduct === "all" || item.product_name === selectedProduct;
                        const dateMatch = (!startDateObj || date >= startDateObj) && (!endDateObj || date <= endDateObj);

                        if (productMatch && dateMatch) {
                            rows += `
                                <tr>
                                    <td>${no++}</td>
                                    <td>${formatDate(item.changes_date)}</td>
                                    <td>${item.stock_change_id}</td>
                                    <td>${item.product_name}</td>
                                    <td>${item.changes_quantity > 0 ? '+' : ''}${item.changes_quantity.toLocaleString()}</td>
                                    <td>${item.total_stock.toLocaleString()} Stok</td>
                                </tr>
                            `;
                        }
                    });
                    $('tbody').html(rows); // Tampilkan hasil filter di tabel
                }
            },
            error: function(xhr, status, error) {
                console.error('Failed to apply filter:', xhr.responseText);
            }
        });
    }
});