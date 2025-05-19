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
  
                    const profilePicture = document.getElementById('profile-picture');
                    profilePicture.src = user.profile_picture;
  
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
});

function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function() {
        const output = document.getElementById('profile-picture');
        output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}

$(document).ready(function() {
    $('#profileForm').on('submit', function(event) {
        event.preventDefault();

        const token = localStorage.getItem("token");
        if (!token) {
            console.error('Token tidak ditemukan.');
            return;
        }

        const formData = new FormData(this);
        $.ajax({
            url: '/api/profile/edit',
            type: 'POST',
            headers: {
                Authorization: `Bearer ${token}`
            },
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    alert('Profil berhasil diperbarui.');
                    window.location.href = '/profil';
                } else {
                    alert('Gagal memperbarui profil: ' + response.message);
                }
            },
            error: function(error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memperbarui profil.');
            }
        });
    });
});