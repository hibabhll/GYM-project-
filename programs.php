<?php
session_start();
include 'db.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit();
}

$sql    = "SELECT * FROM programs ORDER BY id ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>ADRENA — Programs</title>
  <link href="https://fonts.googleapis.com/css2?family=Anton&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --gold: #c8f000; --gold2: #9dba00;
      --dark: #0a0a0a; --dark2: #111; --dark3: #181818;
      --white: #f5f5f5; --muted: #555;
      --border: rgba(200,240,0,.1); --border2: rgba(255,255,255,.06);
    }
    body { background: var(--dark); color: var(--white); font-family: 'DM Sans', sans-serif; min-height: 100vh; }

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
    .btn-back {
      font-size: .72rem; letter-spacing: 2px; text-transform: uppercase;
      color: var(--muted); text-decoration: none;
      border: 1px solid #222; border-radius: 6px; padding: 7px 16px;
      transition: color .2s, border-color .2s;
    }
    .btn-back:hover { color: var(--gold); border-color: var(--border); }

    /* PAGE */
    .page { max-width: 1000px; margin: 0 auto; padding: 4rem 1.5rem; }

    /* HEADER */
    .page-head { text-align: center; margin-bottom: 3rem; }
    .eyebrow { font-size: .65rem; letter-spacing: 5px; text-transform: uppercase; color: var(--gold); margin-bottom: .75rem; }
    .page-head h1 { font-family: 'Anton', sans-serif; font-size: clamp(2.2rem, 5vw, 4rem); letter-spacing: 2px; text-transform: uppercase; line-height: 1; }
    .page-head h1 span { color: var(--gold); }
    .page-head p { margin-top: .75rem; font-size: .9rem; color: var(--muted); font-weight: 300; }

    /* LEVEL BADGE colors */
    .badge {
      display: inline-block; font-size: .6rem; letter-spacing: 3px; text-transform: uppercase;
      padding: 4px 12px; border-radius: 20px; font-family: 'Anton', sans-serif;
    }
    .badge-beginner  { background: rgba(46,204,113,.12);  color: #2ecc71; border: 1px solid rgba(46,204,113,.2); }
    .badge-intermediate { background: rgba(230,126,34,.12); color: #e67e22; border: 1px solid rgba(230,126,34,.2); }
    .badge-advanced  { background: rgba(231,76,60,.12);   color: #e74c3c; border: 1px solid rgba(231,76,60,.2); }
    .badge-default   { background: rgba(200,240,0,.1);    color: var(--gold); border: 1px solid var(--border); }

    /* GRID */
    .programs-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.25rem; }

    .program-card {
      background: var(--dark2); border: 1px solid var(--border2);
      border-radius: 14px; padding: 1.75rem;
      display: flex; flex-direction: column; gap: .75rem;
      transition: transform .25s, border-color .25s, box-shadow .25s;
      position: relative; overflow: hidden;
    }
    .program-card::before {
      content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px;
      background: var(--gold); transform: scaleX(0); transform-origin: left; transition: transform .3s;
    }
    .program-card:hover { transform: translateY(-5px); border-color: var(--border); box-shadow: 0 16px 40px rgba(0,0,0,.4); }
    .program-card:hover::before { transform: scaleX(1); }

    .program-card h3 { font-family: 'Anton', sans-serif; font-size: 1.15rem; letter-spacing: 1px; text-transform: uppercase; }
    .program-card p  { font-size: .85rem; color: var(--muted); line-height: 1.65; font-weight: 300; flex: 1; }

    /* EMPTY STATE */
    .empty {
      text-align: center; padding: 4rem; color: var(--muted);
      background: var(--dark2); border: 1px solid var(--border2); border-radius: 14px;
    }
    .empty p { font-size: .9rem; margin-top: .5rem; }
  </style>
</head>
<body>

  <nav class="navbar">
    <a href="home.php" class="nav-logo"><span class="logo-dot"></span>ADRENA</a>
    <a href="dashboard.php" class="btn-back">← Dashboard</a>
  </nav>

  <div class="page">
    <div class="page-head">
      <p class="eyebrow">✦ Entraînement</p>
      <h1>TRAINING <span>PROGRAMS</span></h1>
      <p>Choisis le programme adapté à ton niveau et tes objectifs.</p>
    </div>

    <?php if ($result && $result->num_rows > 0): ?>
      <div class="programs-grid">
        <?php while ($row = $result->fetch_assoc()): ?>
          <?php
            $level = strtolower($row['level'] ?? '');
            if (str_contains($level, 'beginner') || str_contains($level, 'débutant')) {
                $badgeClass = 'badge-beginner';
            } elseif (str_contains($level, 'intermediate') || str_contains($level, 'intermédiaire')) {
                $badgeClass = 'badge-intermediate';
            } elseif (str_contains($level, 'advanced') || str_contains($level, 'avancé')) {
                $badgeClass = 'badge-advanced';
            } else {
                $badgeClass = 'badge-default';
            }
          ?>
          <div class="program-card">
            <span class="badge <?php echo $badgeClass; ?>"><?php echo htmlspecialchars($row['level'] ?? 'All levels'); ?></span>
            <h3><?php echo htmlspecialchars($row['name']); ?></h3>
            <p><?php echo htmlspecialchars($row['description']); ?></p>
          </div>
        <?php endwhile; ?>
      </div>
    <?php else: ?>
      <div class="empty">
        <div style="font-size:2.5rem; margin-bottom:1rem;">💪</div>
        <h3 style="font-family:'Anton',sans-serif; letter-spacing:2px;">NO PROGRAMS YET</h3>
        <p>Les programmes d'entraînement seront bientôt disponibles.</p>
      </div>
    <?php endif; ?>
  </div>

</body>
</html>