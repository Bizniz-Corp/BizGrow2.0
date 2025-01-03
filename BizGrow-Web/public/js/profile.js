document.addEventListener('DOMContentLoaded', function() {
  console.log('Fetching profile data...');
  $(document).ready(function() {
      const token = localStorage.getItem("token");
      if (!token) {
          console.log('Token tidak ditemukan di profil.');
          return;
      }

      $.ajax({
          url: '/api/profile',
          type: 'GET',
          headers: {
              Authorization: `Bearer ${token}`
          },
          success: function(response) {
              if (response.success) {
                  const user = response.data;

                  console.log(user.profile_picture);
                  console.log(user.name);
                  console.log(user.email);
                  console.log(user.npwp);

                  const profilePicture = document.getElementById('profilePicture');
                  profilePicture.src = user.profile_picture ? `/storage/private/${user.profile_picture}` : '/storage/private/default_profile.jpg';

                  const nameInput = document.getElementById('umkmNameInput');
                  nameInput.value = user.name;

                  const emailInput = document.getElementById('umkmEmailInput');
                  emailInput.value = user.email;

                  const npwpInput = document.getElementById('umkmNPWP');
                  npwpInput.value = user.npwp;
              } else {
                  console.error('Gagal memuat profile:', response.message);
              }
          },
          error: function(error) {
              console.error('Error fetching profile data:', error);
          }
      });
  });

  function handleFocus(event) {
    const input = event.target;
    if (input.value === input.getAttribute('data-original')) {
      input.value = '';
    }
  }

  function handleBlur(event) {
    const input = event.target;
    if (input.value === '') {
      input.value = input.getAttribute('data-original');
    }
  }

  const deleteAccountButton = document.querySelector(".btn-danger");
  const simpan = document.querySelector(".btn-success");

  simpan.addEventListener("click", function() {
    const confirmation = confirm("Yakin ingin menyimpan perubahan?");
    if (!confirmation) {
      return;
    }
    alert("Data berhasil disimpan");
    window.location.href = "profile.html";
  });

  deleteAccountButton.addEventListener("click", function() {
    const confirmation = confirm("Yakin ingin menghapus akun?");
    if (confirmation) {
      window.location.href = "indexsignin.html";
    }
  });

  const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  tooltipTriggerList.forEach(function (tooltipTriggerEl) {
    new bootstrap.Tooltip(tooltipTriggerEl);
  });
});
