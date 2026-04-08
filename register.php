<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fullname = trim($_POST['fullname']);
    $email    = trim($_POST['email']);
    $phone    = trim($_POST['phone']);
    $age      = intval($_POST['age']);
    $height   = intval($_POST['height']);
    $weight   = intval($_POST['weight']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $error = "An account with this email already exists.";
        $check->close();
    } else {
        $check->close();

        $stmt = $conn->prepare(
            "INSERT INTO users (fullname, email, phone, age, height, weight, password)
             VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("sssiiis", $fullname, $email, $phone, $age, $height, $weight, $password);

        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            header("Location: login.html");
            exit();
        } else {
            $error = "Registration failed. Please try again.";
            $stmt->close();
        }
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>ADRENA — Register</title>
  <link rel="stylesheet" href="register.CSS"/>
</head>
<body>

  <div class="bg-photo">
    <img src="login.jpg" alt="bg"/>
  </div>

  <nav class="top-nav">
    <a href="login.html" class="logo">
      <div class="logo-dot"></div>
      ADRENA
    </a>
    <a href="login.html" class="back-btn">← Back to Login</a>
  </nav>

  <div class="page">
    <div class="card">

      <div class="card-header">
        <p class="step">Step 01 — New Member</p>
        <h1>JOIN <span>US</span></h1>
        <p>Already a member? <a href="login.html">Sign In →</a></p>
      </div>

      <form action="register.php" method="POST">

        <div class="form-grid">

          <div class="field field-full">
            <label>Full Name</label>
            <div class="input-wrap">
              <input type="text" name="fullname" placeholder="John Doe" required/>
            </div>
          </div>

          <div class="field field-full">
            <label>Email Address</label>
            <div class="input-wrap">
              <input type="email" name="email" placeholder="you@example.com" required/>
            </div>
          </div>

          <div class="field field-full">
            <label>Phone Number</label>
            <div class="input-wrap">
              <input type="tel" name="phone" placeholder="+216" required/>
            </div>
          </div>

          <div class="field">
            <label>Age</label>
            <div class="input-wrap">
              <input type="number" name="age" min="10" max="100" required/>
            </div>
          </div>

          <div class="field">
            <label>Height (cm)</label>
            <div class="input-wrap">
              <input type="number" name="height" min="100" max="250" required/>
            </div>
          </div>

          <div class="field field-full">
            <label>Weight (kg)</label>
            <div class="input-wrap">
              <input type="number" name="weight" min="30" max="300" required/>
            </div>
          </div>

          <div class="field field-full">
            <label>Password</label>
            <div class="input-wrap">
              <input type="password" name="password" minlength="6" required/>
            </div>
          </div>

        </div>

        <button type="submit" class="btn-cta">START MY JOURNEY</button>

      </form>

    </div>
  </div>

</body>
</html>