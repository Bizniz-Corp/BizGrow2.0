document.addEventListener("DOMContentLoaded", function () {
    console.log("Fetching profile data...");
    $(document).ready(function () {
        const token = localStorage.getItem("token");
        if (!token) {
            console.log("Token tidak ditemukan di profil.");
            return;
        }

        $.ajax({
            url: "/api/profile",
            type: "GET",
            headers: {
                Authorization: `Bearer ${token}`,
            },
            success: function (response) {
                if (response.success) {
                    const user = response.data;
                    
                    const profilePicture = document.getElementById('profile-picture');
                    profilePicture.src = user.profile_picture;

                    const nameInput = document.getElementById("umkmNameInput");
                    nameInput.value = user.name;

                    const emailInput =
                        document.getElementById("umkmEmailInput");
                    emailInput.value = user.email;

                    const npwpInput = document.getElementById("umkmNPWP");
                    npwpInput.value = user.npwp;
                } else {
                    console.error("Gagal memuat profile:", response.message);
                }
            },
            error: function (error) {
                console.error("Error fetching profile data:", error);
            },
        });
    });

    function handleFocus(event) {
        const input = event.target;
        if (input.value === input.getAttribute("data-original")) {
            input.value = "";
        }
    }

    function handleBlur(event) {
        const input = event.target;
        if (input.value === "") {
            input.value = input.getAttribute("data-original");
        }
    }

  const deleteAccountButton = document.getElementById('deleteAccountButton');
  const confirmDeleteButton = document.getElementById('confirmDeleteButton');

  deleteAccountButton.addEventListener('click', function() {
      const deleteAccountModal = new bootstrap.Modal(document.getElementById('deleteAccountModal'));
      deleteAccountModal.show();
  });

  confirmDeleteButton.addEventListener('click', function() {
      const confirmation = confirm("Yakin ingin menghapus akun?");
      if (confirmation) {
          const token = localStorage.getItem("token");
          const password = document.getElementById('confirmPassword').value;

          if (!token) {
              console.error('Token tidak ditemukan.');
              return;
          }

          if (!password) {
                alert('Password tidak boleh kosong.');
                return;
          }

          $.ajax({
              url: '/api/profile/delete', // Endpoint untuk menghapus profil
              type: 'PUT',
              headers: {
                  Authorization: `Bearer ${token}`
              },
              data: {
                  password: password
              },
              success: function(response) {
                  if (response.success) {
                      alert('Akun berhasil dihapus.');
                      window.location.href = '/login'; // Redirect ke halaman login setelah akun dihapus
                  } else {
                      alert('Gagal menghapus akun: ' + response.message);
                  }
              },
              error: function(xhr) {
                  alert('Terjadi kesalahan saat menghapus akun: ' + xhr.responseJSON?.message || 'Unknown error');
              }
          });
      }
  });

  const simpan = document.querySelector(".btn-success");

    simpan.addEventListener("click", function () {
        const confirmation = confirm("Yakin ingin menyimpan perubahan?");
        if (!confirmation) {
            return;
        }
        alert("Data berhasil disimpan");
        window.location.href = "profile.html";
    });

  const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  tooltipTriggerList.forEach(function (tooltipTriggerEl) {
    new bootstrap.Tooltip(tooltipTriggerEl);
  });
});


