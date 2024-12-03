// document.addEventListener('DOMContentLoaded', function() {
//     const filterModal = new bootstrap.Modal(document.getElementById('filterModal'));
    
//     // Filter Produk
//     document.getElementById('filterButton').addEventListener('click', function() {
//         filterModal.show();
//     });

//     document.getElementById('applyFilter').addEventListener('click', function() {
//         const selectedProduct = document.getElementById('productFilter').value;
//         filterTable(selectedProduct, getStartDate(), getEndDate());
//         filterModal.hide();
//     });

//     // Reset Filter
//     document.getElementById('resetButton').addEventListener('click', function() {
//         document.getElementById('productFilter').value = 'all';
//         document.getElementById('startDate').value = '';
//         document.getElementById('endDate').value = '';
//         filterTable();
//     });

//     // Filter Berdasarkan Rentang Tanggal
//     document.getElementById('startDate').addEventListener('change', function() {
//         filterTable(getSelectedProduct(), getStartDate(), getEndDate());
//     });

//     document.getElementById('endDate').addEventListener('change', function() {
//         filterTable(getSelectedProduct(), getStartDate(), getEndDate());
//     });

//     // Fungsi Helper
//     function filterTable(selectedProduct = "all", startDate, endDate) {
//         const rows = document.querySelectorAll('tbody tr');
//         rows.forEach(row => {
//             const productName = row.cells[3].innerText;  // Kolom produk
//             const date = row.cells[1].innerText;         // Kolom tanggal
//             const dateObj = new Date(date);

//             let productMatch = selectedProduct === "all" || productName === selectedProduct;
//             let dateMatch = (!startDate || dateObj >= new Date(startDate)) && (!endDate || dateObj <= new Date(endDate));

//             row.style.display = productMatch && dateMatch ? '' : 'none';
//         });
//     }

//     function getSelectedProduct() {
//         return document.getElementById('productFilter').value;
//     }

//     function getStartDate() {
//         return document.getElementById('startDate').value;
//     }

//     function getEndDate() {
//         return document.getElementById('endDate').value;
//     }
// });
$(document).ready(function() {
    const filterModal = new bootstrap.Modal($('#filterModal')[0]);

    // Load data dari JSON dan tampilkan di tabel
    function loadTableData() {
        $.getJSON('../penjualan.json', function(data) {
            let rows = '';
            data.forEach((item, index) => {
                rows += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.tanggal}</td>
                        <td>${item.id}</td>
                        <td>${item.produk}</td>
                        <td>${item.kuantitas}</td>
                        <td>${item.harga.toLocaleString()}</td>
                        <td>${item.total.toLocaleString()}</td>
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
        $.getJSON('../penjualan.json', function(data) {
            let rows = '';
            let no = 1; // Inisialisasi nomor urut

            // Buat objek tanggal dari startDate dan endDate
            const startDateObj = startDate ? new Date(startDate) : null;
            const endDateObj = endDate ? new Date(endDate) : null;

            data.forEach(item => {
                const date = new Date(item.tanggal);

                // Filter berdasarkan produk dan rentang tanggal
                const productMatch = selectedProduct === "all" || item.produk === selectedProduct;
                const dateMatch = (!startDateObj || date >= startDateObj) && (!endDateObj || date <= endDateObj);

                if (productMatch && dateMatch) {
                    rows += `
                        <tr>
                            <td>${no++}</td>
                            <td>${item.tanggal}</td>
                            <td>${item.id}</td>
                            <td>${item.produk}</td>
                            <td>${item.kuantitas}</td>
                            <td>${item.harga.toLocaleString()}</td>
                            <td>${item.total.toLocaleString()}</td>
                        </tr>
                    `;
                }
            });
            $('tbody').html(rows); // Tampilkan hasil filter di tabel
        });
    }
});


