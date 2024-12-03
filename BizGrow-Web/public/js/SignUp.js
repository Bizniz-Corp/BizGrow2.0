function validateForm() {
    // Get form fields
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const npwp = document.getElementById('npwp').value;
    const upload = document.getElementById('upload').files;
  
    // Check if required fields are filled
    if (name === "" || email === "" || password === "") {
      alert("Please fill out all required fields.");
      return false;
    }
  
    // Check if NPWP is in a valid format (example only; replace with actual format if needed)
    if (npwp !== "" && !/^\d{15}$/.test(npwp)) {
      alert("Please enter a valid NPWP number (15 digits).");
      return false;
    }
  
    // Check if a file is uploaded
    if (upload.length === 0) {
      alert("Please upload a file for Surat Izin Usaha.");
      return false;
    }
  
    // If form is valid, show success alert and redirect to the home page
    if (confirm("Sign Up Successful! Click OK to go to the Sign In.")) {
      window.location.href="indexsignin.html"; 
    }
    return false; // Prevent default form submission
  }
  
  