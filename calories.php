<?php
session_start();
include 'db.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit();
}

$email = $_SESSION['email'];

$stmt = $conn->prepare("SELECT age, height, weight FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user   = $result->fetch_assoc();
$stmt->close();

if (!$user) {
    echo "No data found.";
    exit();
}

$age    = $user['age'];
$height = $user['height'];
$weight = $user['weight'];

// Mifflin-St Jeor BMR (male baseline — gender not stored in DB)
$bmr = round(10 * $weight + 6.25 * $height - 5 * $age + 5);

// Activity multipliers
$levels = [
    "Sedentary"         => ["factor" => 1.2,  "desc" => "Little or no exercise"],
    "Lightly active"    => ["factor" => 1.375,"desc" => "Light exercise 1–3 days/week"],
    "Moderately active" => ["factor" => 1.55, "desc" => "Moderate exercise 3–5 days/week"],
    "Very active"       => ["factor" => 1.725,"desc" => "Hard exercise 6–7 days/week"],
    "Extra active"      => ["factor" => 1.9,  "desc" => "Very hard exercise & physical job"],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>ADRENA — Calories</title>
  <link rel="stylesheet" href="home.css"/>
  <style>
    body { display:flex; align-items:center; justify-content:center; min-height:100vh; padding:2rem; }
    .cal-card {
      background:#111; border:1px solid rgba(200,240,0,.12);
      border-radius:16px; padding:2.5rem 3rem;
      max-width:520px; width:100%;
    }
    .cal-card h1 { font-family:'Anton',sans-serif; letter-spacing:3px; font-size:1.6rem;
      margin-bottom:1.5rem; text-align:center; }
    .cal-card h1 span { color:#c8f000; }
    .stat-row { display:flex; justify-content:space-between; margin-bottom:.75rem;
      font-size:.9rem; color:#888; border-bottom:1px solid #1e1e1e; padding-bottom:.75rem; }
    .stat-row strong { color:#f5f5f5; }
    .bmr-block { text-align:center; margin:1.5rem 0; }
    .bmr-number { font-family:'Anton',sans-serif; font-size:3.5rem; color:#c8f000; line-height:1; }
    .bmr-label { font-size:.7rem; letter-spacing:4px; text-transform:uppercase; color:#555; margin-top:.4rem; }
    .levels-title { font-size:.65rem; letter-spacing:4px; text-transform:uppercase;
      color:#555; margin:1.5rem 0 .75rem; }
    .level-row {
      display:flex; justify-content:space-between; align-items:center;
      padding:.65rem .9rem; border-radius:8px; border:1px solid #1e1e1e;
      margin-bottom:.5rem; transition:.2s;
    }
    .level-row:hover { border-color:rgba(200,240,0,.2); }
    .level-name { font-size:.82rem; color:#f5f5f5; }
    .level-desc { font-size:.72rem; color:#555; }
    .level-cal { font-family:'Anton',sans-serif; font-size:1.1rem; color:#c8f000; white-space:nowrap; }
    .note { font-size:.72rem; color:#444; margin-top:1.25rem; line-height:1.6; }
    .back-link { display:inline-block; margin-top:1.5rem; font-size:.8rem; letter-spacing:2px;
      text-transform:uppercase; color:#c8f000; text-decoration:none;
      border:1px solid rgba(200,240,0,.2); padding:10px 24px; border-radius:6px; transition:.2s; }
    .back-link:hover { background:rgba(200,240,0,.07); }
  </style>
</head>
<body>
  <div class="cal-card">
    <h1>CALORIE <span>CALCULATOR</span></h1>

    <div class="stat-row"><span>Age</span><strong><?php echo $age; ?> yrs</strong></div>
    <div class="stat-row"><span>Height</span><strong><?php echo $height; ?> cm</strong></div>
    <div class="stat-row"><span>Weight</span><strong><?php echo $weight; ?> kg</strong></div>

    <div class="bmr-block">
      <div class="bmr-number"><?php echo $bmr; ?></div>
      <div class="bmr-label">Base Metabolic Rate (kcal/day)</div>
    </div>

    <p class="levels-title">Daily needs by activity level</p>

    <?php foreach ($levels as $name => $data): ?>
      <div class="level-row">
        <div>
          <div class="level-name"><?php echo $name; ?></div>
          <div class="level-desc"><?php echo $data['desc']; ?></div>
        </div>
        <div class="level-cal"><?php echo round($bmr * $data['factor']); ?> kcal</div>
      </div>
    <?php endforeach; ?>

    <p class="note">* Calculated using the Mifflin-St Jeor formula (male baseline). Results are estimates — consult a nutritionist for a personalised plan.</p>

    <a href="dashboard.php" class="back-link">← Back to Dashboard</a>
  </div>
</body>
</html>
