$(document).ready(function () {
    let currentFilters = {};
    loadTableData();

    // Load data dari API dan tampilkan di tabel
    function loadTableData(page = 1, filters = {}) {
        currentFilters = filters;

        // Lakukan permintaan AJAX ke API
        $.ajax({
            url: `/api/feedback?page=${page}`, // Endpoint API untuk mendapatkan feedback
            method: "GET",
            headers: {
                Authorization: `Bearer ${localStorage.getItem("token")}`, // Pastikan token autentikasi disertakan
            },
            data: filters, 
            success: function (response) {
                console.log("API Response:", response); // Log seluruh respons API
                console.log("Feedback Data:", response.data); // Log data feedback
                console.log("Pagination Data:", response.pagination); // Log data pagination

                const feedbackData = response.data; // Data feedback
                const pagination = response.pagination; // Data pagination

                renderTable(feedbackData);
                updatePaginationControls(pagination);
            },
            error: function (xhr) {
                console.error("Gagal memuat data:", xhr.responseText); // Log error
                alert("Terjadi kesalahan saat memuat data.");
            },
        });
    }

    function renderTable(data) {
        let rows = "";
        data.forEach((item) => {
            rows += `
                <tr>
                    <td>${item.nama_umkm}</td>
                    <td>${item.deskripsi}</td>
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
        loadTableData(page, currentFilters);
    });

    // Tampilkan data awal
    loadTableData();
    $("#submitFeedbackButton").on("click", function () {
        const deskripsi = $("#feedbackInput").val().trim();

        if (!deskripsi) {
            alert("Feedback tidak boleh kosong!");
            return;
        }

        $.ajax({
            url: "/api/feedback-post",
            method: "POST",
            headers: {
                Authorization: `Bearer ${localStorage.getItem("token")}`,
            },
            data: { deskripsi },
            success: function (response) {
                console.log("Feedback berhasil dikirim:", response); // Log respons sukses
                alert("Feedback berhasil dikirim. Terima kasih!");
                $("#feedbackModal").modal("hide");
                $("#feedbackInput").val("");
            },
            error: function (xhr, status, error) {
                console.error("Error submitting feedback:", xhr.responseText); // Log error
                console.error("Status:", status);
                console.error("Error:", error);
                alert("Terjadi kesalahan saat mengirim feedback. Silakan coba lagi.");
            },
        });
    });

    $("#umkmNameInput").on("input", function () {
        const searchQuery = $(this).val().trim();
        console.log("Pencarian:", searchQuery);
        currentFilters.umkm = searchQuery; 
        loadTableData(1, currentFilters); 
    });

    $("#resetButton").on("click", function () {
        $("#umkmNameInput").val(""); 
        currentFilters = {};
        loadTableData(1);
    });

});
