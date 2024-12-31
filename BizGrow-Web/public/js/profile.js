document.addEventListener('DOMContentLoaded', function() {
  axios.get('/api/profile', {
    headers: {
      'Authorization': 'Bearer ' + localStorage.getItem('auth_token')
    }
  })
  .then(function (response) {
    if (response.data.success) {
      const user = response.data.data;

      const nameInput = document.getElementById('umkmNameInput');
      nameInput.value = user.name;
      nameInput.setAttribute('data-original', user.name);

      const emailInput = document.getElementById('umkmEmailInput');
      emailInput.value = user.email;
      emailInput.setAttribute('data-original', user.email);

      const npwpInput = document.getElementById('umkmNPWP');
      npwpInput.value = user.npwp;
      npwpInput.setAttribute('data-original', user.npwp);

      nameInput.addEventListener('focus', handleFocus);
      nameInput.addEventListener('blur', handleBlur);

      emailInput.addEventListener('focus', handleFocus);
      emailInput.addEventListener('blur', handleBlur);
    }
  })
  .catch(function (error) {
    console.error('Error fetching profile data:', error);
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
