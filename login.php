<?php
require_once("connect.php");
require_once("function.php");
session_start();

// Se o usuário já estiver logado, redireciona para o dashboard
if (isset($_SESSION['login_active'])) {
  header("Location: dashboard.php");
  exit();
}

// Verifica se o formulário foi enviado
if (isset($_POST['login'])) {
  $email = santize($_POST['email']);
  $inputpassword = santize($_POST['password']);
  $password = md5($inputpassword);

  // Consultar o banco de dados para validar as credenciais
  $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
  $result = mysqli_query($conn, $sql);

  // Se o usuário for encontrado
  if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      $_SESSION['login_active'] = [$row["name"], $row["email"]];
      $_SESSION['msg'] = "Welcome to Dashboard";
      $_SESSION['class'] = "text-bg-success";
      header("Location: dashboard.php");
      exit();
    }
  } else {
    // Caso as credenciais estejam incorretas
    $_SESSION['msg'] = "Check Email & Password";
    $_SESSION['class'] = "text-bg-danger";
    header("Location: index.php");
    exit();
  }
}
?>

<!-- Formulário de Login -->
<section class="main-section">
  <div class="container">
    <div class="row justify-content-center align-items-center" style="height:100vh;">
      <div class="col-md-7 col-lg-4">
        <div class="box rounded">
          <div class="login-box p-5">
            <!-- Exibir mensagens de status -->
            <?php
            if (isset($_SESSION['msg'])) : ?>
              <div class="toast-container position-fixed bottom-0 end-0 p-3">
                <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true">
                  <div class="toast-header <?php echo $_SESSION['class']; ?>">
                    <strong class="me-auto">Message</strong>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="toast" aria-label="Close"></button>
                  </div>
                  <div class="toast-body">
                    <?php
                    echo $_SESSION['msg'];
                    unset($_SESSION['msg']);
                    ?>
                  </div>
                </div>
              </div>
            <?php endif; ?>

            <!-- Login image -->
            <div class="img">
              <img src="img/bg-1.webp" class="img-fluid">
            </div>

            <h2 class="pb-4">Login</h2>
            <form action="login.php" method="post">
              <div class="mb-4">
                <input type="email" class="form-control" placeholder="Enter Email address" name="email" required>
              </div>
              <div class="mb-4">
                <input type="password" class="form-control" placeholder="Enter Password" name="password" required>
              </div>
              <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary" name="login">Login</button>
              </div>
            </form>

            <div class="py-4 text-center">
              Join now, <a href="signup.php" class="link">Sign Up</a>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>
