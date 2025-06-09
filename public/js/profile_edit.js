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
                    // Show success modal instead of alert
                    const successModal = new bootstrap.Modal(document.getElementById('successModal'));
                    successModal.show();
                    
                    // Add event listener to redirect after clicking OK
                    document.getElementById('successModalButton').addEventListener('click', function() {
                        window.location.href = '/profil';
                    });
                } else {
                    // Show error modal with specific message
                    document.getElementById('errorMessage').textContent = 'Gagal memperbarui profil: ' + response.message;
                    const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                    errorModal.show();
                }
            },
            error: function(error) {
                console.error('Error:', error);
                // Show generic error modal
                document.getElementById('errorMessage').textContent = 'Terjadi kesalahan saat memperbarui profil.';
                const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                errorModal.show();
            }
        });
    });
    
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});