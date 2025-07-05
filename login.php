<?php
session_start();
$conn = new mysqli("localhost", "root", "", "your_database");

if (isset($_POST['login'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT * FROM admin_users WHERE username=?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($user = $result->fetch_assoc()) {
    if (password_verify($password, $user['password'])) {
      $_SESSION['admin'] = $user['username'];
      header("Location: admin.php");
      exit;
    } else {
      $error = "Incorrect password!";
    }
  } else {
    $error = "User not found!";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Login</title>
  <style>
    body { font-family: Poppins, sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; background: #f2f2f2; }
    form { background: white; padding: 2rem; border-radius: 10px; width: 300px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
    input { width: 100%; margin: 0.5rem 0; padding: 0.6rem; border: 1px solid #ccc; border-radius: 6px; }
    button { width: 100%; padding: 0.6rem; background: #000; color: white; border: none; border-radius: 6px; }
    .error { color: red; font-size: 0.9rem; }
  </style>
</head>
<body>
  <form method="POST">
    <h2>Admin Login</h2>
    <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>
    <input type="text" name="username" placeholder="Username" required />
    <input type="password" name="password" placeholder="Password" required />
    <button type="submit" name="login">Login</button>
  </form>
</body>
</html>