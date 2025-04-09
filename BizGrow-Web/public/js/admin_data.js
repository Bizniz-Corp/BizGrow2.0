$(document).ready(function () {
    let currentFilters = {};
    loadTableData();

    // Load data dari JSON dan tampilkan di tabel
    function loadTableData(page = 1, filters = {}) {
        currentFilters = filters;

        // Data dummy
        const dummyData = [
            {
                name: "UMKM A",
                duration: 30,
                forecasting_demand: true,
                buffer_stock: false,
                demand_accuracy: "95%",
                stock_accuracy: "90%",
                status: "Aktif",
            },
            {
                name: "UMKM B",
                duration: 45,
                forecasting_demand: false,
                buffer_stock: true,
                demand_accuracy: "92%",
                stock_accuracy: "88%",
                status: "Nonaktif",
            },
            {
                name: "UMKM C",
                duration: 60,
                forecasting_demand: true,
                buffer_stock: true,
                demand_accuracy: "98%",
                stock_accuracy: "85%",
                status: "Aktif",
            },
            {
                name: "UMKM D",
                duration: 25,
                forecasting_demand: false,
                buffer_stock: false,
                demand_accuracy: "89%",
                stock_accuracy: "80%",
                status: "Nonaktif",
            },
            {
                name: "UMKM E",
                duration: 50,
                forecasting_demand: true,
                buffer_stock: true,
                demand_accuracy: "97%",
                stock_accuracy: "93%",
                status: "Aktif",
            },
        ];

        // Pagination dummy
        const pagination = {
            current_page: page,
            last_page: 2, // Misalnya ada 2 halaman
        };

        // Filter data dummy berdasarkan filter yang diterapkan
        let filteredData = dummyData;
        if (filters.name && filters.name !== "all") {
            filteredData = filteredData.filter(item => item.name === filters.name);
        }

        // Simulasikan data per halaman
        const itemsPerPage = 3;
        const startIndex = (page - 1) * itemsPerPage;
        const paginatedData = filteredData.slice(startIndex, startIndex + itemsPerPage);

        // Render tabel dan kontrol pagination
        renderTable(paginatedData);
        updatePaginationControls(pagination);
    }

    function renderTable(data) {
        let rows = "";
        data.forEach((item) => {
            rows += `
                <tr>
                    <td>${item.name}</td>
                    <td>${item.duration} Menit</td>
                    <td>${item.forecasting_demand ? '<button class="btn btn-success btn-sm"><i class="bi bi-check-lg"></i></button>' : '<button class="btn btn-danger btn-sm"><i class="bi bi-x-lg"></i></button>'}</td>
                    <td>${item.buffer_stock ? '<button class="btn btn-success btn-sm"><i class="bi bi-check-lg"></i></button>' : '<button class="btn btn-danger btn-sm"><i class="bi bi-x-lg"></i></button>'}</td>
                    <td>${item.demand_accuracy}</td>
                    <td>${item.stock_accuracy}</td>
                    <td>${item.status}</td>
                    <td>
                        <button class="btn btn-danger btn-sm delete-button">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
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

        paginationHTML += `<span>${pagination.current_page} dari ${pagination.last_page}</span>`;

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

    $("#resetButton").on("click", function () {
        currentFilters = {}; // Reset filter
        loadTableData(1); // Muat ulang data awal
    });
});

$(document).on("click", ".delete-button", function () {
    $(this).closest("tr").remove();
});


