$(document).ready(function () {
    $("#feedbackButton").on("click", function () {
        $("#feedbackModal").modal("show");
    });

    $("#submitFeedbackButton").on("click", function () {
        const feedback = $("#feedbackInput").val().trim();

        if (!feedback) {
            alert("Feedback tidak boleh kosong!");
            return;
        }

        $.ajax({
            url: "/api/feedback",
            method: "POST",
            headers: {
                Authorization: `Bearer ${localStorage.getItem("token")}`,
            },
            data: { feedback },
            success: function (response) {
                alert("Feedback berhasil dikirim. Terima kasih!");
                $("#feedbackModal").modal("hide");
                $("#feedbackInput").val("");
            },
            error: function (xhr, status, error) {
                console.error("Error submitting feedback:", xhr.responseText);
                alert("Terjadi kesalahan saat mengirim feedback. Silakan coba lagi.");
            },
        });
    });
});