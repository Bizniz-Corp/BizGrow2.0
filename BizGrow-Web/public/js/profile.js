fetch('../user.json')
  .then(response => response.json())
  .then(users => {
    const user = users[0];

    const nameInput = document.getElementById('umkmNameInput');
    nameInput.value = user.nama;
    nameInput.setAttribute('data-original', user.nama);

    const emailInput = document.getElementById('umkmEmailInput');
    emailInput.value = user.email;
    emailInput.setAttribute('data-original', user.email);

    const npwp = document.getElementById('umkmNPWP');
    npwp.value = user.npwp;
    npwp.setAttribute('data-original', user.npwp);

    nameInput.addEventListener('focus', handleFocus);
    nameInput.addEventListener('blur', handleBlur);

    emailInput.addEventListener('focus', handleFocus);
    emailInput.addEventListener('blur', handleBlur);
  })
  .catch(error => console.error('Error loading JSON:', error));

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

//document.getElementById("fileInput").addEventListener("change", function(event) {
//  const file = event.target.files[0];
//  if (file) {
//    const reader = new FileReader();
//    reader.onload = function(e) {
//      document.getElementById("profileImage").src = e.target.result;
//    };
//    reader.readAsDataURL(file);
//  }
//});

document.addEventListener("DOMContentLoaded", function() {
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
    // sementara, belum ke backend
    if (confirmation) {
      window.location.href = "indexsignin.html";
    }
    //window.location.href = "indexsignin.html";
  });
});


document.addEventListener('DOMContentLoaded', function () {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.forEach(function (tooltipTriggerEl) {
      new bootstrap.Tooltip(tooltipTriggerEl);
    });
  });
