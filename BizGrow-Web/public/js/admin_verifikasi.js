$(document).ready(function () {
    let currentFilters = {};
    loadTableData();

    // Load data dari JSON dan tampilkan di tabel
    function loadTableData(page = 1, filters = {}) {
        currentFilters = filters;

        // Data dummy
        const dummyData = [
            {
                name: "Toko Jaya Abadi",
                status: "Menunggu Verifikasi",
                npwp: "15.203.001.01.112.12",
                surat_izin: "suratizin_jayaabadi.pdf",
            },
            {
                name: "Toko Makmur Sentosa",
                status: "Menunggu Verifikasi",
                npwp: "15.203.002.01.112.13",
                surat_izin: "suratizin_makmursentosa.pdf",
            },
            {
                name: "Toko Sejahtera",
                status: "Menunggu Verifikasi",
                npwp: "15.203.003.01.112.14",
                surat_izin: "suratizin_sejahtera.pdf",
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
        const itemsPerPage = 2;
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
                    <td>${item.status}</td>
                    <td>${item.npwp}</td>
                    <td>
                        <a href="/files/${item.surat_izin}" target="_blank" class="text-decoration-none">
                            ${item.surat_izin}
                        </a>
                    </td>
                    <td>
                        <button class="btn btn-warning btn-sm me-2">
                            <i class="bi bi-file-earmark-text"></i>
                        </button>
                        <button class="btn btn-success btn-sm me-2">
                            <i class="bi bi-check-lg"></i>
                        </button>
                        <button class="btn btn-danger btn-sm">
                            <i class="bi bi-x-lg"></i>
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

    // Fungsi untuk memuat daftar produk
    function fetchUMKMList() {
        // $.ajax({
        //     url: "/api/......", // TODO : ganti nanti kalo udah ada di backend
        //     method: "GET",
        //     headers: {
        //         Authorization: `Bearer ${token}`,
        //     },
        //     success: function (response) {
        //         if (response.success) {
        //             let options = '<option value="all">Semua Produk</option>';
        //             response.data.forEach((product) => {
        //                 options += `<option value="${product.product_name}">${product.product_name}</option>`;
        //             });
        //             $("#productFilter").html(options);
        //         }
        //     },
        //     error: function (xhr, status, error) {
        //         console.error(
        //             "Failed to fetch product list:",
        //             xhr.responseText
        //         );
        //     },
        // });
    }

});

$(document).on("click", ".btn-warning", function () {
    // TODO : ini nanti diganti dengan fungsi untuk mengubah status
    alert('Tombol dokumen diklik!');
});

$(document).on('click', '.btn-success', function () {
    // TODO : ini nanti diganti dengan fungsi untuk mengubah status
    alert('Tombol ceklis diklik!');
});

$(document).on('click', '.btn-danger', function () {
    // TODO : ini nanti diganti dengan fungsi untuk menghapus data
    alert('Tombol silang diklik!');
});