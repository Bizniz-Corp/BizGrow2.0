$(document).ready(function () {
    console.log("Sign Up page ready!");
    $("#registerForm").submit(function (e) {
        e.preventDefault(); // Mencegah form untuk refresh halaman saat submit

        var formData = new FormData(this); // Mengambil semua data form termasuk file
        console.log("Data yang dikirim:", formData);

        formData.forEach((value, key) => {
            console.log(key + ": " + value);
        });

        $.ajax({
            url: "/api/register",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.message === "Register berhasil!") {
                    console.log("DATANYA WOI:", response); // jangan dihapus buat nyari nama susah bgt
                    $("#successMessage").html("Selamat, " + response.data.user.name + "! Register berhasil.");
        
                    var successModal = new bootstrap.Modal(document.getElementById('successModal'));
                    successModal.show();
                }
            },
    
          error: function (xhr, status, error) {
            let errorMessages = "";
            let uniqueErrors = new Set(); // Gunakan Set agar tidak ada duplikasi
        
            if (xhr.responseJSON?.errors) {
                Object.keys(xhr.responseJSON.errors).forEach((key) => {
                    let messages = xhr.responseJSON.errors[key];
                    if (Array.isArray(messages)) {
                        messages.forEach(msg => uniqueErrors.add(msg)); // Tambah ke Set
                    } else {
                        uniqueErrors.add(messages);
                    }
                });
            } else if (xhr.responseJSON?.error) {
                uniqueErrors.add(xhr.responseJSON.error);
            } else {
                uniqueErrors.add("Kesalahan tidak diketahui.");
            }
        
            // Tampilkan pesan error unik di modal
            $("#errorList").html([...uniqueErrors].map(msg => `<li>${msg}</li>`).join(""));
            
            // Tampilkan modal error
            var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
            errorModal.show();
          },
  

        });
    });
});
