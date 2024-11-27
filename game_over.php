<?php
session_start();
if (!isset($_SESSION['login_active'])) {
    header("Location: index.php");
    exit();
}

$msg = isset($_SESSION['msg']) ? $_SESSION['msg'] : "Game Over! Try again.";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Game Over</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <div class="container text-center">
    <h1 class="py-5"><?php echo $msg; ?></h1>
    <a href="dashboard.php" class="btn btn-primary">Back to Dashboard</a>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
