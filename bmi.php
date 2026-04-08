<?php
session_start();
include 'db.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit();
}

$email = $_SESSION['email'];

$stmt = $conn->prepare("SELECT height, weight FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user   = $result->fetch_assoc();
$stmt->close();

if (!$user) {
    echo "No data found.";
    exit();
}

$height_m = $user['height'] / 100;
$weight   = $user['weight'];
$bmi      = $weight / ($height_m * $height_m);
$bmi      = round($bmi, 2);

if ($bmi < 18.5) {
    $category = "Underweight";
    $color    = "#3498db";
} elseif ($bmi < 25) {
    $category = "Normal weight";
    $color    = "#2ecc71";
} elseif ($bmi < 30) {
    $category = "Overweight";
    $color    = "#e67e22";
} else {
    $category = "Obese";
    $color    = "#e74c3c";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>ADRENA — BMI</title>
  <link rel="stylesheet" href="home.css"/>
  <style>
    body { display:flex; align-items:center; justify-content:center; min-height:100vh; }
    .bmi-card {
      background: #111; border: 1px solid rgba(200,240,0,.12);
      border-radius: 16px; padding: 2.5rem 3rem;
      text-align: center; max-width: 400px; width: 100%;
    }
    .bmi-card h1 { font-family:'Anton',sans-serif; letter-spacing:3px; font-size:1.6rem; margin-bottom:1.5rem; }
    .bmi-card h1 span { color:#c8f000; }
    .stat-row { display:flex; justify-content:space-between; margin-bottom:.75rem;
      font-size:.9rem; color:#888; border-bottom:1px solid #1e1e1e; padding-bottom:.75rem; }
    .stat-row strong { color:#f5f5f5; }
    .bmi-number { font-family:'Anton',sans-serif; font-size:4rem; line-height:1;
      color:<?php echo $color; ?>; margin: 1.5rem 0 .5rem; }
    .bmi-cat { font-size:.75rem; letter-spacing:4px; text-transform:uppercase;
      color:<?php echo $color; ?>; margin-bottom:2rem; }
    .back-link { display:inline-block; margin-top:1rem; font-size:.8rem; letter-spacing:2px;
      text-transform:uppercase; color:#c8f000; text-decoration:none;
      border:1px solid rgba(200,240,0,.2); padding:10px 24px; border-radius:6px;
      transition:.2s; }
    .back-link:hover { background:rgba(200,240,0,.07); }
  </style>
</head>
<body>
  <div class="bmi-card">
    <h1>YOUR <span>BMI</span></h1>

    <div class="stat-row"><span>Height</span><strong><?php echo $user['height']; ?> cm</strong></div>
    <div class="stat-row"><span>Weight</span><strong><?php echo $user['weight']; ?> kg</strong></div>

    <div class="bmi-number"><?php echo $bmi; ?></div>
    <div class="bmi-cat"><?php echo $category; ?></div>

    <a href="home.php" class="back-link">← Back to Home</a>
  </div>
</body>
</html>
