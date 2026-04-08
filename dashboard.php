<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>ADRENA — Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Anton&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --gold: #c8f000; --gold2: #9dba00;
      --dark: #0a0a0a; --dark2: #111; --dark3: #181818;
      --white: #f5f5f5; --muted: #555;
      --border: rgba(200,240,0,.1); --border2: rgba(255,255,255,.06);
    }
    body {
      background: var(--dark); color: var(--white);
      font-family: 'DM Sans', sans-serif; min-height: 100vh;
      display: flex; flex-direction: column;
    }

    /* NAV */
    .navbar {
      background: rgba(10,10,10,.97); border-bottom: 1px solid var(--border2);
      padding: 0 2rem; height: 64px;
      display: flex; align-items: center; justify-content: space-between;
    }
    .nav-logo {
      display: flex; align-items: center; gap: 9px;
      font-family: 'Anton', sans-serif; font-size: 1.2rem;
      letter-spacing: 4px; color: var(--white); text-decoration: none;
    }
    .logo-dot { width: 9px; height: 9px; background: var(--gold); border-radius: 50%; }
    .nav-right { display: flex; align-items: center; gap: 1rem; }
    .nav-user { font-size: .8rem; color: var(--muted); letter-spacing: 1px; }
    .nav-user span { color: var(--gold); }
    .btn-logout {
      font-size: .72rem; letter-spacing: 2px; text-transform: uppercase;
      color: var(--muted); text-decoration: none;
      border: 1px solid #222; border-radius: 6px; padding: 7px 16px;
      transition: color .2s, border-color .2s;
    }
    .btn-logout:hover { color: #e74c3c; border-color: #e74c3c; }

    /* MAIN */
    .main {
      flex: 1; display: flex; flex-direction: column;
      align-items: center; justify-content: center;
      padding: 3rem 1.5rem;
    }
    .welcome {
      text-align: center; margin-bottom: 3rem;
    }
    .welcome .eyebrow {
      font-size: .65rem; letter-spacing: 5px; text-transform: uppercase;
      color: var(--gold); margin-bottom: .75rem;
    }
    .welcome h1 {
      font-family: 'Anton', sans-serif; font-size: clamp(2rem, 5vw, 3.5rem);
      letter-spacing: 2px; text-transform: uppercase; line-height: 1;
    }
    .welcome h1 span { color: var(--gold); }
    .welcome p { margin-top: .75rem; font-size: .9rem; color: var(--muted); font-weight: 300; }

    /* GRID */
    .dash-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
      gap: 1.25rem; width: 100%; max-width: 900px;
    }
    .dash-card {
      background: var(--dark2); border: 1px solid var(--border2);
      border-radius: 14px; padding: 1.75rem 1.5rem;
      text-decoration: none; color: var(--white);
      display: flex; flex-direction: column; gap: .75rem;
      transition: transform .25s, border-color .25s, box-shadow .25s;
      position: relative; overflow: hidden;
    }
    .dash-card::before {
      content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px;
      background: var(--gold); transform: scaleX(0); transform-origin: left; transition: transform .3s;
    }
    .dash-card:hover { transform: translateY(-5px); border-color: var(--border); box-shadow: 0 16px 40px rgba(0,0,0,.4); }
    .dash-card:hover::before { transform: scaleX(1); }
    .dash-icon {
      width: 48px; height: 48px; background: rgba(200,240,0,.07);
      border: 1px solid var(--border); border-radius: 10px;
      display: flex; align-items: center; justify-content: center; font-size: 1.4rem;
    }
    .dash-card h3 { font-family: 'Anton', sans-serif; font-size: 1rem; letter-spacing: 1px; text-transform: uppercase; }
    .dash-card p { font-size: .78rem; color: var(--muted); font-weight: 300; line-height: 1.5; }
    .dash-arrow { margin-top: auto; font-size: .72rem; color: var(--gold); letter-spacing: 2px; text-transform: uppercase; }

    /* FOOTER */
    footer { text-align: center; padding: 1.5rem; font-size: .75rem; color: #2a2a2a; border-top: 1px solid var(--border2); }
  </style>
</head>
<body>

  <nav class="navbar">
    <a href="home.php" class="nav-logo"><span class="logo-dot"></span>ADRENA</a>
    <div class="nav-right">
      <span class="nav-user">Bonjour, <span><?php echo htmlspecialchars($_SESSION['user']); ?></span></span>
      <a href="logout.php" class="btn-logout">Logout</a>
    </div>
  </nav>

  <main class="main">
    <div class="welcome">
      <p class="eyebrow">✦ Espace membre</p>
      <h1>WELCOME <span><?php echo htmlspecialchars(strtoupper(explode(' ', $_SESSION['user'])[0])); ?></span></h1>
      <p>Que veux-tu faire aujourd'hui ?</p>
    </div>

    <div class="dash-grid">

      <a href="profile.php" class="dash-card">
        <div class="dash-icon">👤</div>
        <h3>My Profile</h3>
        <p>Voir et gérer tes informations personnelles.</p>
        <span class="dash-arrow">Ouvrir →</span>
      </a>

      <a href="bmi.php" class="dash-card">
        <div class="dash-icon">⚖️</div>
        <h3>BMI Calculator</h3>
        <p>Calcule ton indice de masse corporelle.</p>
        <span class="dash-arrow">Calculer →</span>
      </a>

      <a href="calories.php" class="dash-card">
        <div class="dash-icon">🔥</div>
        <h3>Calories</h3>
        <p>Découvre tes besoins caloriques quotidiens.</p>
        <span class="dash-arrow">Voir →</span>
      </a>

      <a href="programs.php" class="dash-card">
        <div class="dash-icon">💪</div>
        <h3>Training Programs</h3>
        <p>Explore nos programmes d'entraînement.</p>
        <span class="dash-arrow">Explorer →</span>
      </a>

      <a href="shop.html" class="dash-card">
        <div class="dash-icon">🛍️</div>
        <h3>Shop</h3>
        <p>Protéines, vêtements et équipements.</p>
        <span class="dash-arrow">Acheter →</span>
      </a>

      <a href="home.php" class="dash-card">
        <div class="dash-icon">🏠</div>
        <h3>Home</h3>
        <p>Retourner à la page principale ADRENA.</p>
        <span class="dash-arrow">Accueil →</span>
      </a>

    </div>
  </main>

  <footer>© 2026 ADRENA — Tunisie</footer>

</body>
</html>