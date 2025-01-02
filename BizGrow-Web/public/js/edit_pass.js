$(document).ready(function () {
    const token = localStorage.getItem("token");

    // Toggle visibility for "Password Lama"
    $("#togglePassLama").on("click", function () {
        const input = $("#passLama");
        const icon = $(this).find("i");

        if (input.attr("type") === "password") {
            input.attr("type", "text");
            icon.removeClass("bi-eye").addClass("bi-eye-slash");
        } else {
            input.attr("type", "password");
            icon.removeClass("bi-eye-slash").addClass("bi-eye");
        }
    });

    // Toggle visibility for other password inputs
    $("#togglePassBaru").on("click", function () {
        const input = $("#passBaru");
        const icon = $(this).find("i");

        if (input.attr("type") === "password") {
            input.attr("type", "text");
            icon.removeClass("bi-eye").addClass("bi-eye-slash");
        } else {
            input.attr("type", "password");
            icon.removeClass("bi-eye-slash").addClass("bi-eye");
        }
    });

    // Toggle visibility for other password inputs
    $("#togglePassBaruConfirm").on("click", function () {
        const input = $("#passBaruConfirm");
        const icon = $(this).find("i");

        if (input.attr("type") === "password") {
            input.attr("type", "text");
            icon.removeClass("bi-eye").addClass("bi-eye-slash");
        } else {
            input.attr("type", "password");
            icon.removeClass("bi-eye-slash").addClass("bi-eye");
        }
    });

    //Check Password lama
    $("#berikutnyaBtn").on("click", function () {
        const enteredPassword = $("#passLama").val();

        // Kirim request ke server untuk cek password lama
        $.ajax({
            url: "/api/profile/edit-password", // Endpoint validasi password lama
            type: "POST",
            headers: {
                Accept: "application/json",
                Authorization: `Bearer ${token}`, // Pastikan token diambil sesuai implementasi Anda
            },
            data: {
                passLama: enteredPassword,
            },
            success: function (response) {
                $("#passLama").removeClass("is-invalid");
                $("#passLama").addClass("is-valid");
                $("#notePassLama, #berikutnyaBtn").addClass("d-none");
                $(
                    ".inputFieldBaru, .inputFieldBaruConfirm, #simpanBtn"
                ).removeClass("d-none");
            },
            error: function (xhr) {
                $("#passLama").addClass("is-invalid");
                $("#notePassLama")
                    .removeClass("d-none")
                    .text(xhr.responseJSON?.message || "Terjadi kesalahan.");
            },
        });
    });

    // Event untuk tombol simpan
    $("#simpanBtn").on("click", function () {
        const newPassword = $("#passBaru").val();
        const confirmPassword = $("#passBaruConfirm").val();

        const hasUpperCase = /[A-Z]/.test(newPassword);
        const hasLowerCase = /[a-z]/.test(newPassword);
        const hasNumber = /[0-9]/.test(newPassword);
        const hasSpecialChar = /[!@#$%^&*]/.test(newPassword);
        const isValidLength =
            newPassword.length >= 8 && newPassword.length <= 25;

        $("#notePassBaruConfirm").addClass("d-none");
        $("#notePassBaruUpConfirm").addClass("d-none");
        $("#notePassBaruLowConfirm").addClass("d-none");
        $("#notePassBaruCharConfirm").addClass("d-none");
        $("#notePassBaruRangeConfirm").addClass("d-none");
        $("#notePassBaruAngkaConfirm").addClass("d-none");

        if (
            newPassword === confirmPassword &&
            hasLowerCase &&
            hasUpperCase &&
            hasSpecialChar &&
            isValidLength &&
            hasNumber
        ) {
            $("#passBaru, #passBaruConfirm").removeClass("is-invalid");

            $("#confirmModal").modal("show");
            $("#gantiButton").on("click", function () {
                $.ajax({
                    url: "/api/profile/edit-password",
                    type: "PUT",
                    headers: {
                        // Accept: "application/json",
                        // // "Content-Type": "application/json",
                        Authorization: `Bearer ${token}`,
                    },
                    data: {
                        passBaru: newPassword,
                    },
                    success: function (response) {
                        $("#successModal").modal("show");
                        $("#confirmButton").on("click", function () {
                            $("#successModal").modal("hide");
                            window.location.href = "/profil";
                        });
                        $("#confirmModal").modal("hide");
                    },
                    error: function (xhr) {
                        alert(
                            xhr.responseJSON?.message ||
                                "Gagal memperbarui password."
                        );
                    },
                });
            });

            $("#batalButton").on("click", function () {
                $("#confirmModal").modal("hide");
            });
            // Kirim request ke API untuk ubah password
        } else {
            $("#passBaru, #passBaruConfirm").addClass("is-invalid");
            if (newPassword !== confirmPassword) {
                $("#notePassBaruConfirm").removeClass("d-none");
            } else if (!hasLowerCase) {
                $("#notePassBaruLowConfirm").removeClass("d-none");
            } else if (!hasUpperCase) {
                $("#notePassBaruUpConfirm").removeClass("d-none");
            } else if (!hasSpecialChar) {
                $("#notePassBaruCharConfirm").removeClass("d-none");
            } else if (!isValidLength) {
                $("#notePassBaruRangeConfirm").removeClass("d-none");
            } else if (!hasNumber) {
                $("#notePassBaruAngkaConfirm").removeClass("d-none");
            }
        }
    });
});
