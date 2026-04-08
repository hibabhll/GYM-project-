<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit();
}

$cartJson = $_POST['cart'] ?? '[]';
$cart     = json_decode($cartJson, true);

// Validate cart is an array
if (!is_array($cart)) {
    $cart = [];
}

// Calculate total
$total = 0;
foreach ($cart as $item) {
    $total += (float)($item['price'] ?? 0) * (int)($item['qty'] ?? 1);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>ADRENA — Order Confirmed</title>
  <link rel="stylesheet" href="home.css"/>
  <style>
    body { display:flex; align-items:center; justify-content:center; min-height:100vh; padding:2rem; }
    .checkout-card {
      background:#111; border:1px solid rgba(200,240,0,.12);
      border-radius:16px; padding:2.5rem 3rem;
      max-width:500px; width:100%; text-align:center;
    }
    .check-icon { font-size:3rem; margin-bottom:1rem; }
    h1 { font-family:'Anton',sans-serif; letter-spacing:3px; font-size:1.6rem; margin-bottom:.5rem; }
    h1 span { color:#c8f000; }
    .sub { font-size:.85rem; color:#555; margin-bottom:2rem; }
    .order-items { text-align:left; margin-bottom:1.5rem; }
    .order-item { display:flex; justify-content:space-between;
      padding:.65rem 0; border-bottom:1px solid #1a1a1a; font-size:.88rem; }
    .order-item .name { color:#f5f5f5; }
    .order-item .qty  { color:#555; margin:0 .75rem; }
    .order-item .price { color:#c8f000; font-family:'Anton',sans-serif; }
    .order-total { display:flex; justify-content:space-between; padding:1rem 0;
      font-family:'Anton',sans-serif; font-size:1.2rem; letter-spacing:1px; }
    .order-total span:last-child { color:#c8f000; }
    .empty-msg { color:#555; font-size:.9rem; margin:1.5rem 0; }
    .btn-back { display:inline-block; margin-top:1.5rem; font-size:.8rem; letter-spacing:2px;
      text-transform:uppercase; color:#c8f000; text-decoration:none;
      border:1px solid rgba(200,240,0,.2); padding:10px 24px; border-radius:6px; transition:.2s; }
    .btn-back:hover { background:rgba(200,240,0,.07); }
  </style>
</head>
<body>
  <div class="checkout-card">
    <div class="check-icon">✅</div>
    <h1>ORDER <span>CONFIRMED</span></h1>
    <p class="sub">
      Thank you, <strong><?php echo htmlspecialchars($_SESSION['user']); ?></strong>!
      Your order has been placed successfully.
    </p>

    <?php if (empty($cart)): ?>
      <p class="empty-msg">No order details available.</p>
    <?php else: ?>
      <div class="order-items">
        <?php foreach ($cart as $item): ?>
          <div class="order-item">
            <span class="name"><?php echo htmlspecialchars($item['name'] ?? ''); ?></span>
            <span class="qty">x<?php echo (int)($item['qty'] ?? 1); ?></span>
            <span class="price">
              <?php echo number_format((float)($item['price'] ?? 0) * (int)($item['qty'] ?? 1), 0); ?> TND
            </span>
          </div>
        <?php endforeach; ?>
        <div class="order-total">
          <span>Total</span>
          <span><?php echo number_format($total, 0); ?> TND</span>
        </div>
      </div>
    <?php endif; ?>

    <a href="shop.php" class="btn-back">← Continue Shopping</a>
    <a href="home.php" class="btn-back" style="margin-left:.5rem;">Home</a>
  </div>
</body>
</html>
