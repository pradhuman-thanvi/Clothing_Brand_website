<?php
include 'db.php';

if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$category = $_GET['category'] ?? '';
$order = $_GET['order'] ?? 'DESC';

$sql = "SELECT * FROM products";
if ($category) $sql .= " WHERE category = '$category'";
$sql .= " ORDER BY id $order";

$products = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Shop Now - The Girly House</title>
  <link rel="stylesheet" href="styles.css" />
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />
  <style>
    .shop-container {
      padding: 7rem 1rem 2rem;
      max-width: var(--max-width);
      margin: auto;
    }

    .filter-bar {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      margin-bottom: 2rem;
      gap: 1rem;
    }

    .filter-bar select {
      padding: 0.7rem;
      border-radius: 8px;
      border: 1px solid #ccc;
    }

    .grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 2rem;
    }

    .product__card {
      width: 100%;
      max-width: 500px;
      height: 480px;
      background-color: var(--white);
      border-radius: 1rem;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      padding: 1rem;
      margin: auto;
      position: relative;
    }

    .product__card img {
      width: 100%;
      height: 300px;
      object-fit: cover;
      border-radius: 1rem;
    }

    .product__card h3 {
      font-size: 1.5rem;
      margin: 1rem 0 0.5rem;
      text-align: center;
      color: var(--text-dark);
    }

    .product__card .price {
      text-align: center;
      margin-bottom: 1rem;
    }

    .product__card .price s {
      color: #999;
      margin-right: 0.5rem;
    }

    .product__card .price strong {
      color: green;
      font-size: 1.2rem;
    }

    .product__card .whatsapp-btn {
      background-color: #25d366;
      color: white;
      padding: 0.7rem 1.2rem;
      border-radius: 8px;
      text-align: center;
      font-weight: 600;
      display: block;
      margin: 0 auto;
      width: fit-content;
      text-decoration: none;
    }
    .badge1{
       position: absolute;
      top: 80px;
      left: 50px;
      max-width:10%;
      

    }

    .product__card .badge {
      position: absolute;
      top: 10px;
      left: 10px;
      background: crimson;
      color: white;
      padding: 5px 10px;
      font-size: 0.8rem;
      border-radius: 5px;
    }

    

    h1.section__header {
      text-align: center;
      margin-bottom: 2rem;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav>
  <div class="nav__header">
    <div class="nav__logo">
      <a href="index.html">THE GIRLY HOUSE</a>
    </div>
    <div class="nav__menu__btn" id="menu-btn">
      <i class="ri-menu-line"></i>
    </div>
  </div>
  <ul class="nav__links" id="nav-links">
    <li><a href="index.html">HOME</a></li>
  </ul>
</nav>

<div class="shop-container">
  <h1 class="section__header">🛍️ Shop Now</h1>

  <div class="filter-bar">
    <form method="GET">
      <label>
        Category:
        <select name="category" onchange="this.form.submit()">
          <option value="">All</option>
          <option value="Jeans" <?= $category == "Jeans" ? 'selected' : '' ?>>Jeans</option>
          <option value="Kurti" <?= $category == "Kurti" ? 'selected' : '' ?>>Kurti</option>
          <option value="Tops" <?= $category == "Tops" ? 'selected' : '' ?>>Tops</option>
          <option value="Dress" <?= $category == "Dress" ? 'selected' : '' ?>>Dress</option>
        </select>
      </label>
      <label>
        Sort:
        <select name="order" onchange="this.form.submit()">
          <option value="DESC" <?= $order == "DESC" ? 'selected' : '' ?>>Newest</option>
          <option value="ASC" <?= $order == "ASC" ? 'selected' : '' ?>>Oldest</option>
        </select>
      </label>
    </form>
  </div>

  <div class="grid">
    <?php while ($row = $products->fetch_assoc()): ?>
      <?php
        $price = $row['price'];
        $discount = $row['discount_price'];
        $status = strtolower($row['Status']);
        $final = ($discount && $discount < $price) ? $discount : $price;
        $discountPercent = ($discount && $discount < $price)
          ? round((($price - $discount) / $price) * 100)
          : 0;
      ?>
      <div class="product__card">
        <?php if ($discountPercent): ?>
          <div class="badge"><?= $discountPercent ?>% OFF</div>
        <?php endif; ?>

        <?php if ($status === 'soldout'): ?>
          <div class=""><img src="assets/SALE.png" style="width: 200px; height: 100px; object-fit: contain; position: absolute; top: 10px; left:-60px;" />
</div>
        <?php endif; ?>

        <img src="uploads/<?= $row['image'] ?>" alt="<?= htmlspecialchars($row['name']) ?>">
        <h3><?= htmlspecialchars($row['name']) ?></h3>

        <p class="price">
          <?php if ($discount && $discount < $price): ?>
            <s>₹<?= $price ?></s>
            <strong>₹<?= $discount ?></strong>
          <?php else: ?>
            <strong>₹<?= $price ?></strong>
          <?php endif; ?>
        </p>

        <a class="whatsapp-btn <?= $status === 'soldout' ? 'disabled' : '' ?>" target="_blank"
           href="<?= $status === 'soldout' ? '#' : 'https://wa.me/123456789?text=' . urlencode("Hi, I'm interested in {$row['name']} for ₹{$final}.\nImage: https://thegirlyhouse.infinityfree.app/uploads/{$row['image']}") ?>">
          Buy on WhatsApp
        </a>
      </div>
    <?php endwhile; ?>
  </div>
</div>

<script>
  const menuBtn = document.getElementById("menu-btn");
  const navLinks = document.getElementById("nav-links");

  menuBtn.onclick = () => {
    navLinks.classList.toggle("open");
  };
</script>
</body>
</html>