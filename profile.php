<?php
session_start();
include 'db.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit();
}

$email = $_SESSION['email'];

$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user   = $result->fetch_assoc();
$stmt->close();

if (!$user) {
    echo "User not found.";
    exit();
}

// Helper to safely output data
function e($val) {
    return htmlspecialchars($val, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>ADRENA — My Profile</title>
  <link rel="stylesheet" href="home.css"/>
  <style>
    body { display:flex; align-items:center; justify-content:center; min-height:100vh; padding:2rem; }
    .profile-card {
      background:#111; border:1px solid rgba(200,240,0,.12);
      border-radius:16px; padding:2.5rem 3rem;
      max-width:440px; width:100%;
    }
    .profile-card h1 { font-family:'Anton',sans-serif; letter-spacing:3px; font-size:1.6rem;
      margin-bottom:1.75rem; }
    .profile-card h1 span { color:#c8f000; }
    .row { display:flex; justify-content:space-between; align-items:center;
      padding:.75rem 0; border-bottom:1px solid #1a1a1a; font-size:.9rem; }
    .row:last-of-type { border-bottom:none; }
    .row .label { color:#555; font-size:.7rem; letter-spacing:3px; text-transform:uppercase; }
    .row .value { color:#f5f5f5; font-weight:500; }
    .actions { display:flex; gap:.75rem; margin-top:1.75rem; }
    .btn-back { flex:1; text-align:center; text-decoration:none; padding:12px;
      border:1px solid rgba(200,240,0,.2); border-radius:6px; color:#c8f000;
      font-size:.78rem; letter-spacing:2px; text-transform:uppercase; transition:.2s; }
    .btn-back:hover { background:rgba(200,240,0,.07); }
    .btn-logout { flex:1; text-align:center; text-decoration:none; padding:12px;
      border:1px solid #222; border-radius:6px; color:#666;
      font-size:.78rem; letter-spacing:2px; text-transform:uppercase; transition:.2s; }
    .btn-logout:hover { border-color:#e74c3c; color:#e74c3c; }
  </style>
</head>
<body>
  <div class="profile-card">
    <h1>MY <span>PROFILE</span></h1>

    <div class="row"><span class="label">Full Name</span><span class="value"><?php echo e($user['fullname']); ?></span></div>
    <div class="row"><span class="label">Email</span><span class="value"><?php echo e($user['email']); ?></span></div>
    <div class="row"><span class="label">Phone</span><span class="value"><?php echo e($user['phone']); ?></span></div>
    <div class="row"><span class="label">Age</span><span class="value"><?php echo e($user['age']); ?> yrs</span></div>
    <div class="row"><span class="label">Height</span><span class="value"><?php echo e($user['height']); ?> cm</span></div>
    <div class="row"><span class="label">Weight</span><span class="value"><?php echo e($user['weight']); ?> kg</span></div>

    <div class="actions">
      <a href="dashboard.php" class="btn-back">← Dashboard</a>
      <a href="logout.php" class="btn-logout">Logout</a>
    </div>
  </div>
</body>
</html>
