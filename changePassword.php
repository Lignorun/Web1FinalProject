<?php
require_once("connect.php");
require_once("function.php");
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
  echo json_encode([
    'status' => 'error',
    'message' => 'You must be logged in to change your password.',
    'class' => 'text-bg-danger'
  ]);
  exit();
}

if (isset($_POST['change_password'])) {
  $user_id = $_SESSION['user_id'];  // O ID do usuário deve estar na sessão
  $old_password = santize($_POST['old_password']);
  $new_password = santize($_POST['new_password']);
  $confirm_password = santize($_POST['confirm_password']);

  // Verificar se as senhas coincidem
  if ($new_password !== $confirm_password) {
    echo json_encode([
      'status' => 'error',
      'message' => 'The new passwords do not match.',
      'class' => 'text-bg-danger'
    ]);
    exit();
  }

  // Obter a senha atual do banco de dados
  $sql = "SELECT password FROM users WHERE id = '$user_id'";
  $result = mysqli_query($conn, $sql);
  if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $current_password = $row['password'];

    // Verificar se a senha antiga está correta
    if (md5($old_password) !== $current_password) {
      echo json_encode([
        'status' => 'error',
        'message' => 'The old password is incorrect.',
        'class' => 'text-bg-danger'
      ]);
      exit();
    }

    // Atualizar a senha no banco de dados
    $new_password_hashed = md5($new_password);
    $update_sql = "UPDATE users SET password = '$new_password_hashed' WHERE id = '$user_id'";

    if (mysqli_query($conn, $update_sql)) {
      echo json_encode([
        'status' => 'success',
        'message' => 'Your password has been successfully changed.',
        'class' => 'text-bg-success'
      ]);
    } else {
      echo json_encode([
        'status' => 'error',
        'message' => 'Failed to change the password.',
        'class' => 'text-bg-danger'
      ]);
    }
  } else {
    echo json_encode([
      'status' => 'error',
      'message' => 'User not found.',
      'class' => 'text-bg-danger'
    ]);
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Change Password</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
  <section class="main-section">
    <div class="container">
      <div class="row justify-content-center align-items-center" style="height:100vh;">
        <div class="col-md-7 col-lg-4">
          <div class="box rounded">
            <div class="login-box p-5">
              <h2 class="pb-4">Change Password</h2>
              <form id="change-password-form" action="" method="post">
                <div class="mb-4">
                  <input type="password" class="form-control" placeholder="Enter Old Password" name="old_password" required>
                </div>
                <div class="mb-4">
                  <input type="password" class="form-control" placeholder="Enter New Password" name="new_password" required>
                </div>
                <div class="mb-4">
                  <input type="password" class="form-control" placeholder="Confirm New Password" name="confirm_password" required>
                </div>
                <div class="d-grid gap-2">
                  <button type="submit" class="btn btn-primary-1" name="change_password">Change Password</button>
                </div>
              </form>

              <div class="py-4 text-center">
                <a href="index.php" class="link">Back to Login</a>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <div>
    <?php include 'footer.php'; ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  
  <script>
    $(document).ready(function() {
      $('#change-password-form').submit(function(e) {
        e.preventDefault(); // Prevent the form from submitting normally

        // Collect the form data
        var formData = $(this).serialize();

        // Perform the AJAX request
        $.ajax({
          type: 'POST',
          url: '', // Same file
          data: formData,
          dataType: 'json',
          success: function(response) {
            // Show success or error message
            alert(response.message);
            if (response.status === 'success') {
              // Optionally, redirect or perform additional actions
              window.location.href = 'index.php';
            }
          },
          error: function() {
            alert('An error occurred while processing the request.');
          }
        });
      });
    });
  </script>
</body>

</html>
