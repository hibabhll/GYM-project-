<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user']  = $user['fullname'];
            $_SESSION['email'] = $user['email'];

            header("Location: home.php");
            exit();
        } else {
            $error = "Wrong password.";
        }
    } else {
        $error = "No account found with that email.";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>ADRENA — Login</title>
  <link rel="stylesheet" href="login.css"/>
</head>
<body>

<div class="bg-photo">
  <img src="login.jpg" alt="bg"/>
</div>

<div class="page">

  <div class="logo">
    <div class="logo-dot"></div>
    ADRENA
  </div>

  <div class="tagline">
    <span class="pre">✦ Premium Fitness</span>
    <p>The only bad workout is the one that didn't happen.</p>
  </div>

  <!-- ✅ FORM -->
  <form method="POST" action="">
    
    <div class="right">

      <div class="form-heading">
        <p class="step">Step 01 / 01</p>
        <h2>SIGN <span>IN</span></h2>
      </div>

      <div class="field">
        <label>Email</label>
        <div class="input-wrap">
          <input type="email" name="email" required/>
        </div>
      </div>

      <div class="field">
        <label>Password</label>
        <div class="input-wrap">
          <input type="password" name="password" id="pwd" required/>
        </div>
      </div>

      <button type="submit" class="btn-cta">
        ENTER THE GYM
      </button>

      <?php if (!empty($error)): ?>
        <p style="color:red;"><?php echo $error; ?></p>
      <?php endif; ?>

    </div>

  </form>

</div>

<script>
function togglePwd() {
  const i = document.getElementById('pwd');
  i.type = i.type === 'password' ? 'text' : 'password';
}
</script>

</body>
</html>