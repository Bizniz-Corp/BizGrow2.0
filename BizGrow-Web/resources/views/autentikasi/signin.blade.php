<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Pizgrow</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="../assets/css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/Sign in.css">
</head>

<body>
  <div class="login-container">
    <div class="form-container">
      <h2>Sign In</h2>
      <form id="loginForm">
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" id="email" class="form-control" placeholder="Isi Email">
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" id="password" class="form-control" placeholder="Isi Password">
        </div>
        <button type="submit" class="btn btn-primary w-100">Sign In</button>
        <p class="mt-3">Belum Punya Akun? <a href="indexsignup.html">Klik Disini</a></p>
      </form>
    </div>
    <div class="image-container">
      <img src="../img/Sign in.png" alt="bizgrowlogo">
      <div class="overlay-logo">
        <img src="../img/logo1.png" alt="Pizgrow Logo"> <!-- Replace with your logo -->
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/script.js"></script>
  <script src="../assets/js/Sign in.js"></script>
</body>

</html>
