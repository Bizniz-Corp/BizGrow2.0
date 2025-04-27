$(document).ready(function () {
    let currentFilters = {};
    loadTableData();

    // Load data dari JSON dan tampilkan di tabel
    function loadTableData(page = 1, filters = {}) {
        currentFilters = filters;

        // Data dummy untuk feedback UMKM
        const dummyData = [
            {
                name: "Toko Jaya Abadi",
                feedback: "Pelayanan sangat baik, produk berkualitas.",
            },
            {
                name: "Toko Makmur Sentosa",
                feedback: "Pengiriman cepat, namun kemasan perlu diperbaiki.",
            },
            {
                name: "Toko Sejahtera",
                feedback: "Harga bersaing, tetapi stok sering habis.",
            },
        ];

        // Pagination
        const pagination = {
            current_page: page,
            last_page: Math.ceil(dummyData.length / 10),
        };

        // Filter data dummy berdasarkan filter yang diterapkan
        let filteredData = dummyData;
        if (filters.name && filters.name !== "all") {
            filteredData = filteredData.filter(item => item.name === filters.name);
        }

        // Simulasikan data per halaman
        const itemsPerPage = 10;
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
                    <td>${item.feedback}</td>
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
});
