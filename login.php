<?php
require_once("connect.php");
require_once("function.php");
session_start();

if (isset($_SESSION['login_active'])) {
  header("Location: dashboard.php");
  exit();
}

if (isset($_POST['login'])) {
  $email = santize($_POST['email']);
  $inputpassword = santize($_POST['password']);
  $password = md5($inputpassword);

  $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      $_SESSION['login_active'] = [$row["name"], $row["email"]];
      $_SESSION['msg'] = "Welcome to Dashboard";
      $_SESSION['class'] = "text-bg-success";
      header("Location: dashboard.php");
      exit();
    }
  } else {
    $_SESSION['msg'] = "Check Email & Password";
    $_SESSION['class'] = "text-bg-danger";
    header("Location: index.php");
    exit();
  }
}
?>
