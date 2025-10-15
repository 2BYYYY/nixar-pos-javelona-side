<?php
    $PageTitle = "Login | NIXAR POS";
    $CssPath = "assets/css/styles.css";
?>
<?php include_once '../includes/head.php'; ?>
<div class="container-fluid p-0 m-0 row h-100">
  <div class="col-xl-4 bg-light d-flex justify-content-center align-items-center ">
    <div class="d-flex flex-column gap-4 px-5">
      <img src="assets/svg/nixar-logo-red.svg" alt="nixar-logo" class="w-50 ratio ratio-1x1 max-w-50">
      <div>
        <h2 class="mb-1 fs-1">Welcome to NIXAR POS</h2>
        <p class="text-muted">Manage sales, inventory, and transactions efficiently all in one place.</p>
      </div>
      <form action="handlers/handle_login.php" method="post" class="d-flex flex-column gap-3">
        <div class="mb-1">
          <label for="username" class="text-muted fw-medium mb-2">Username</label>
          <input type="text" class="login-input" id="username" name="username" placeholder="username123" required>
        </div>
        <div class="mb-1">
          <label for="password" class="text-muted fw-medium mb-2">Password</label>
          <input type="password" class="login-input" id="password" name="password" placeholder="••••••••" required>
        </div>
        <button type="submit" class="login-submit">Login</button>
      </form>
    </div>
  </div>
  <div class="col bg-danger d-none fs-1 text-white d-xl-flex justify-content-center align-items-center">[Placeholder]</div>
</div>
<?php include_once '../includes/footer.php'; ?>