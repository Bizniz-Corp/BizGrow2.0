$(document).ready(function () {
    const filterModal = new bootstrap.Modal($("#filterModal")[0]);
    const token = "9|8h5vfax7jPtZff4xFAw78GqYdZHCzJWKMvU1TDwwba6f6d63";
    // const token = localStorage.getItem('token');
    let currentPage = 1;
    let currentFilters = {};

    // konversi tanggal dari format yyyy-mm-dd ke dd-mm-yyyy
    function formatDate(dateString) {
        const date = new Date(dateString);
        const day = String(date.getDate()).padStart(2, "0");
        const month = String(date.getMonth() + 1).padStart(2, "0");
        const year = date.getFullYear();
        return `${day}-${month}-${year}`;
    }

    // Load data dari JSON dan tampilkan di tabel
    function loadTableData(page = 1, filters = {}) {
        currentFilters = filters;
        const { product_name, start_date, end_date } = currentFilters;
        let queryParams = `page=${page}`;

        if (product_name && product_name !== "all") {
            queryParams += `&product_name=${encodeURIComponent(product_name)}`;
        }
        if (start_date) {
            queryParams += `&start_date=${encodeURIComponent(start_date)}`;
        }
        if (end_date) {
            queryParams += `&end_date=${encodeURIComponent(end_date)}`;
        }
        $.ajax({
            url: `/api/stocks-history?${queryParams}`,
            method: "GET",
            headers: {
                Authorization: `Bearer ${token}`,
            },
            success: function (response) {
                if (response.success) {
                    renderTable(response.data);
                    updatePaginationControls(response.pagination);
                }
            },
            error: function (xhr, status, error) {
                console.error(
                    "Failed to fetch stock history:",
                    xhr.responseText
                );
            },
        });
    }

    function renderTable(data) {
        let rows = "";
        data.forEach((item, index) => {
            rows += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${formatDate(item.changes_date)}</td>
                    <td>${item.product_name}</td>
                    <td>${
                        item.changes_quantity > 0 ? "+" : ""
                    }${item.changes_quantity.toLocaleString()}</td>
                    <td>${item.total_stock.toLocaleString()} Stok</td>
                </tr>
            `;
        });
        $("tbody").html(rows);
    }

    // Fungsi untuk memperbarui kontrol pagination
    function updatePaginationControls(pagination) {
        const paginationContainer = $("#pagination");
        let paginationHTML = "";

        if (pagination.current_page > 1) {
            paginationHTML += `<button class="btn btn-primary m-2" data-page="${
                pagination.current_page - 1
            }"><</button>`;
        }

        paginationHTML += `<span>Hal ${pagination.current_page} dari ${pagination.last_page}</span>`;

        if (pagination.current_page < pagination.last_page) {
            paginationHTML += `<button class="btn btn-primary m-2" data-page="${
                pagination.current_page + 1
            }">></button>`;
        }

        paginationContainer.html(paginationHTML);
    }

    // Listener untuk tombol pagination
    $("#pagination").on("click", "button", function () {
        const page = $(this).data("page");
        currentPage = page;
        loadTableData(page, currentFilters);
    });

    // Tampilkan data awal
    loadTableData();

    // Tampilkan filter modal
    $("#filterButton").on("click", function () {
        filterModal.show();
        fetchProductList();
    });

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
                    let options = '<option value="all">Semua Produk</option>';
                    response.data.forEach((product) => {
                        options += `<option value="${product.product_name}">${product.product_name}</option>`;
                    });
                    $("#productFilter").html(options);
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

    // Menerapkan filter
    $("#applyFilter").on("click", function () {
        const selectedProduct = $("#productFilter").val();
        const startDate = $("#startDate").val();
        const endDate = $("#endDate").val();
        const filters = {
            product_name: selectedProduct,
            start_date: startDate,
            end_date: endDate,
        };

        loadTableData(1, filters); // Kirim filter ke API saat mengambil data
        filterModal.hide();
    });

    // Reset filter
    $("#resetButton").on("click", function () {
        $("#productFilter").val("all");
        $("#startDate").val("");
        $("#endDate").val("");
        currentFilters = {};
        loadTableData(1); // Memuat ulang semua data tanpa filter
    });
});
