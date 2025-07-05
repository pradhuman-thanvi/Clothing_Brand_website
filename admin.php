
<?php
// Only start session if not already started
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit;
}

include 'db.php';

// Ensure uploads folder exists
if (!is_dir("uploads")) {
  mkdir("uploads", 0777, true);
}

$error = "";

if (isset($_POST['add'])) {
  $name = $_POST['name'];
  $category = $_POST['category'];
      $Status = $_POST['Status'];

  $price = $_POST['price'];
  $discount_price = !empty($_POST['discount_price']) ? $_POST['discount_price'] : "NULL";
  $image = $_FILES['image']['name'];
  $target = "uploads/" . basename($image);

  if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
    $sql = "INSERT INTO products (name, category, price, discount_price, image, Status)
            VALUES ('$name', '$category', '$price', $discount_price, '$image', '$Status')";
    if (!$conn->query($sql)) {
      $error = "Database error: " . $conn->error;
    }
  } else {
    $error = "Failed to upload image.";
  }
}

// Handle deletion
if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $conn->query("DELETE FROM products WHERE id=$id");
  header("Location: admin.php");
  exit;
}

$products = $conn->query("SELECT * FROM products ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <style>
    body { font-family: Poppins, sans-serif; padding: 2rem; }
    h1 { margin-bottom: 1rem; }
    input, select { width: 100%; padding: 0.5rem; margin: 0.5rem 0; }
    form { background: #f7f7f7; padding: 1rem; border-radius: 10px; margin-bottom: 2rem; }
    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 1rem; border: 1px solid #ddd; text-align: center; }
    .btn { padding: 0.5rem 1rem; background: #000; color: white; border: none; border-radius: 5px; }
    .delete { background: crimson; }
    img { width: 80px; }
    .error { color: red; margin: 1rem 0; }
  </style>
</head>
<body>

<a href="logout.php" class="btn" style="float:right;">Logout</a>
<h1>Admin Dashboard</h1>

<?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>

<form method="POST" enctype="multipart/form-data">
  <h2>Add Product</h2>
  <input type="text" name="name" placeholder="Name" required>
  <select name="category" required>
    <option value="Jeans">Jeans</option>
    <option value="Kurti">Kurti</option>
    <option value="Tops">Tops</option>
    <option value="Dress">Dress</option>
  </select>
  <input type="number" step="0.01" name="price" placeholder="Price ₹" required>
  <input type="number" step="0.01" name="discount_price" placeholder="Discounted Price ₹">
  <h2>Stock</h2>
  <select name="category" required>
    <option value="available">Available</option>
    <option value="soldout">Sold Out</option>
   
  </select>
  <input type="file" name="image" required>
  <button type="submit" name="add" class="btn">Add</button>
</form>

<h2>All Products</h2>
<table>
  <tr>
    <th>ID</th><th>Image</th><th>Name</th><th>Category</th><th>Price</th><th>Discount</th><th>Stock</th><th>Actions</th>
  </tr>
  <?php while($row = $products->fetch_assoc()): ?>
    <tr>
      <td><?= $row['id'] ?></td>
      <td><img src="uploads/<?= $row['image'] ?>"></td>
      <td><?= $row['name'] ?></td>
      <td><?= $row['category'] ?></td>
      <td>₹<?= $row['price'] ?></td>
      <td><?= $row['discount_price'] ? "₹" . $row['discount_price'] : '-' ?></td>
                  <td><?= $row['Status'] ?></td>

      <td>
        <a href="edit.php?id=<?= $row['id'] ?>" class="btn">Edit</a>
        <a href="admin.php?delete=<?= $row['id'] ?>" class="btn delete" onclick="return confirm('Delete product?')">Delete</a>
      </td>
    </tr>
  <?php endwhile; ?>
</table>

</body>
</html>
