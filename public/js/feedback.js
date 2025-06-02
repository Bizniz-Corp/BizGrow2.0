$(document).ready(function () {
    $("#feedbackButton").on("click", function () {
        $("#feedbackModal").modal("show");
    });

    $("#submitFeedbackButton").on("click", function () {
        const deskripsi = $("#feedbackInput").val().trim();

        if (!deskripsi) {
            showMessageModal("Feedback tidak boleh kosong!");
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
                showMessageModal("Feedback berhasil dikirim. Terima kasih!");
                $("#feedbackModal").modal("hide");
                $("#feedbackInput").val("");
            },
            error: function (xhr, status, error) {
                console.error("Error submitting feedback:", xhr.responseText);
                showMessageModal("Terjadi kesalahan saat mengirim feedback. Silakan coba lagi.");
            },
        });
    });

    // Fungsi untuk menampilkan pesan di modal
    function showMessageModal(message) {
        $("#messageModalBody").text(message);
        $("#messageModal").modal("show");
    }
});