$(document).ready(function () {
    let currentFilters = {};
    let currentPage = 1;
    const token = localStorage.getItem("token");
    let actionType = "";
    let selectedId = null;

    loadTableData();

    function loadTableData(page = 1, filters = {}) {
        currentFilters = filters;

        $.ajax({
            url: `/api/umkm-verification?page=${page}`,
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
                    console.error(
                        "Gagal memuat data UMKM untuk verifikasi:",
                        response
                    );
                }
            },
            error: function (xhr, status, error) {
                console.error(
                    "Error fetching UMKM verification data:",
                    xhr.responseText
                );
            },
        });
    }

    function renderTable(data) {
        let rows = "";
        data.forEach((item) => {
            rows += `
                <tr>
                    <td>${item.name}</td>
                    <td>${
                        item.is_verified
                            ? "Terverifikasi"
                            : "Menunggu Verifikasi"
                    }</td>
                    <td>${item.npwp_no || "-"}</td>
                    <td>
                        <a href="/files/${
                            item.izin_usaha_path
                        }" target="_blank" class="text-decoration-none">
                            ${item.izin_usaha_path || "Tidak Ada"}
                        </a>
                    </td>
                    <td>
                        <button class="btn btn-success btn-sm me-2" data-id="${
                            item.id
                        }" data-action="verify">
                            <i class="bi bi-check-lg"></i>
                        </button>
                        <button class="btn btn-danger btn-sm" data-id="${
                            item.id
                        }" data-action="delete">
                            <i class="bi bi-x-lg"></i>
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

    $(document).on("click", ".btn-success, .btn-danger", function () {
        selectedId = $(this).data("id");
        actionType = $(this).data("action");

        if (actionType === "verify") {
            $("#confirmationMessage").html(
                'Apakah Anda yakin <span style="color: green; font-weight: bold;">INGIN</span> memverifikasi UMKM ini?'
            );
        } else if (actionType === "delete") {
            $("#confirmationMessage").html(
                'Apakah Anda yakin <span style="color: red; font-weight: bold;">TIDAK</span> memverifikasi UMKM ini?'
            );
        }

        $("#confirmationModal").modal("show");
    });

    $("#confirmActionButton").on("click", function () {
        if (actionType === "verify") {
            $.ajax({
                url: "/api/umkm-verification-check",
                method: "POST",
                headers: {
                    Authorization: `Bearer ${token}`,
                },
                data: { id: selectedId },
                success: function (response) {
                    loadTableData(currentPage, currentFilters); // Refresh data setelah verifikasi
                    $("#confirmationModal").modal("hide");
                },
                error: function (xhr, status, error) {
                    console.error("Error verifying UMKM:", xhr.responseText);
                },
            });
        } else if (actionType === "delete") {
            $.ajax({
                url: `/api/umkm-verification-reject`,
                method: "POST",
                headers: {
                    Authorization: `Bearer ${token}`,
                },
                data: { id: selectedId },
                success: function (response) {
                    loadTableData(currentPage, currentFilters); // Refresh data setelah penghapusan
                    $("#confirmationModal").modal("hide");
                },
                error: function (xhr, status, error) {
                    console.error("Error rejecting UMKM:", xhr.responseText);
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
