$(document).ready(function () {
    let currentFilters = {};
    let currentPage = 1;
    const token = localStorage.getItem("token");
    let selectedId = null; // ID UMKM yg mau dihapus

    // Panggil fungsi untuk memuat statistik UMKM dan data tabel
    loadUmkmStats();
    loadTableData();

    if (token) {
        $.ajax({
            url: "/api/umkm-active-inactive",
            type: "GET",
            headers: {
                Authorization: `Bearer ${token}`,
            },
            success: function (response) {
                $("#activeUmkmCount").text(response.data.active);
                $("#inactiveUmkmCount").text(response.data.inactive);
            },
            error: function (xhr, status, error) {
                console.error(
                    "Error fetching Actvice and Inactive UMKM data:",
                    xhr.responseText
                );
            },
        });
    }

    function loadTableData(page = 1, filters = {}) {
        currentFilters = filters;

        $.ajax({
            url: `/api/umkm?page=${page}`,
            method: "GET",
            headers: {
                Authorization: `Bearer ${token}`,
            },
            data: filters,
            success: function (response) {
                if (response.status === "success") {
                    const data = response.data;
                    const pagination = response.pagination;

                    renderTable(data);
                    updatePaginationControls(pagination);
                } else {
                    console.error("Gagal memuat data UMKM:", response);
                }
            },
            error: function (xhr, status, error) {
                console.error("Error fetching UMKM data:", xhr.responseText);
            },
        });
    }

    function renderTable(data) {
        let rows = "";
        data.forEach((item) => {
            rows += `
                <tr>
                    <td>${item.name}</td>
                    <td>${item.durasi} Menit</td>
                    <td>${
                        item.forecasting_demand
                            ? '<button class="btn btn-success btn-sm"><i class="bi bi-check-lg"></i></button>'
                            : '<button class="btn btn-danger btn-sm"><i class="bi bi-x-lg"></i></button>'
                    }</td>
                    <td>${
                        item.buffer_stock
                            ? '<button class="btn btn-success btn-sm"><i class="bi bi-check-lg"></i></button>'
                            : '<button class="btn btn-danger btn-sm"><i class="bi bi-x-lg"></i></button>'
                    }</td>
                    <td>${item.demand_accuracy || "-"}</td>
                    <td>${item.stock_accuracy || "-"}</td>
                    <td>${item.status}</td>
                    <td>
                        <button class="btn btn-danger btn-sm delete-button" data-id="${
                            item.id
                        }">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
        });
        $("tbody").html(rows);
    }

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

    $("#pagination").on("click", "button", function () {
        const page = $(this).data("page");
        currentPage = page;
        loadTableData(page, currentFilters);
    });

    $(document).on("click", ".delete-button", function () {
        selectedId = $(this).data("id");
        $("#deleteConfirmationModal").modal("show");
        selectedId = $(this).data("id");
        $("#deleteConfirmationModal").modal("show");
    });

    $("#confirmDeleteButton").on("click", function () {
        if (selectedId) {
            $.ajax({
                url: `/api/umkm/delete/${selectedId}`,
                method: "POST",
                headers: {
                    Authorization: `Bearer ${token}`,
                },
                success: function (response) {
                    loadTableData(currentPage, currentFilters); // Refresh tabel
                    loadUmkmStats(); // Refresh statistik setelah penghapusan
                    $("#deleteConfirmationModal").modal("hide");
                },
                error: function (xhr, status, error) {
                    console.error("Error deleting UMKM:", xhr.responseText);
                },
            });
        }
    });

    $("#umkmNameInput").on("input", function () {
        const searchQuery = $(this).val().trim();
        console.log("Pencarian:", searchQuery);
        currentFilters.name = searchQuery;
        loadTableData(1, currentFilters);
    });

    $("#resetButton").on("click", function () {
        $("#umkmNameInput").val("");
        currentFilters = {};
        loadTableData(1);
    });
});
