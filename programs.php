<?php
session_start();
include 'db.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit();
}

$sql    = "SELECT * FROM programs ORDER BY id ASC";
$result = $conn->query($sql);

$static_programs = [
  [
    'name'        => 'FAT BURNER',
    'level'       => 'Débutant',
    'icon'        => '🔥',
    'duration'    => '4 semaines',
    'sessions'    => '3x / sem',
    'description' => 'Brûle un maximum de calories avec des exercices cardio accessibles.',
    'exercises'   => [
      ['name'=>'Jumping Jacks',       'sets'=>'3×30 reps',  'rest'=>'30s', 'seconds'=>30],
      ['name'=>'Burpees',             'sets'=>'3×10 reps',  'rest'=>'45s', 'seconds'=>45],
      ['name'=>'Mountain Climbers',   'sets'=>'3×20 reps',  'rest'=>'30s', 'seconds'=>30],
      ['name'=>'Corde à sauter',      'sets'=>'3×60s',      'rest'=>'30s', 'seconds'=>60],
      ['name'=>'Squat sauté',         'sets'=>'3×15 reps',  'rest'=>'45s', 'seconds'=>45],
    ],
  ],
  [
    'name'        => 'MUSCLE BUILDER',
    'level'       => 'Intermédiaire',
    'icon'        => '💪',
    'duration'    => '8 semaines',
    'sessions'    => '4x / sem',
    'description' => 'Prise de masse progressive avec surcharge et nutrition optimisée.',
    'exercises'   => [
      ['name'=>'Développé couché',    'sets'=>'4×8 reps',   'rest'=>'90s', 'seconds'=>90],
      ['name'=>'Squat barre',         'sets'=>'4×8 reps',   'rest'=>'90s', 'seconds'=>90],
      ['name'=>'Tractions',           'sets'=>'4×6 reps',   'rest'=>'90s', 'seconds'=>90],
      ['name'=>'Rowing barre',        'sets'=>'4×10 reps',  'rest'=>'60s', 'seconds'=>60],
      ['name'=>'Développé militaire', 'sets'=>'3×10 reps',  'rest'=>'60s', 'seconds'=>60],
    ],
  ],
  [
    'name'        => 'HIIT WARRIOR',
    'level'       => 'Avancé',
    'icon'        => '⚡',
    'duration'    => '6 semaines',
    'sessions'    => '5x / sem',
    'description' => 'Haute intensité par intervalles — cardio, force et endurance maximaux.',
    'exercises'   => [
      ['name'=>'Sprint 30s / repos 15s','sets'=>'×10 rounds','rest'=>'—', 'seconds'=>30],
      ['name'=>'Box Jumps',            'sets'=>'4×12 reps',  'rest'=>'45s','seconds'=>45],
      ['name'=>'Kettlebell Swing',     'sets'=>'4×20 reps',  'rest'=>'30s','seconds'=>30],
      ['name'=>'Push-ups explosifs',   'sets'=>'4×15 reps',  'rest'=>'45s','seconds'=>45],
      ['name'=>'Thrusters',            'sets'=>'4×12 reps',  'rest'=>'60s','seconds'=>60],
    ],
  ],
  [
    'name'        => 'YOGA & MOBILITY',
    'level'       => 'Tous niveaux',
    'icon'        => '🧘',
    'duration'    => 'En continu',
    'sessions'    => '2x / sem',
    'description' => 'Flexibilité, récupération active et équilibre mental au quotidien.',
    'exercises'   => [
      ['name'=>'Sun Salutation',           'sets'=>'5 cycles',   'rest'=>'—','seconds'=>60],
      ['name'=>'Pigeon Pose',              'sets'=>'2×60s/côté', 'rest'=>'—','seconds'=>60],
      ['name'=>'Warrior Sequence',         'sets'=>'3 séries',   'rest'=>'—','seconds'=>45],
      ['name'=>'Hip Flexor Stretch',       'sets'=>'2×45s',      'rest'=>'—','seconds'=>45],
      ['name'=>'Respiration & Méditation', 'sets'=>'10 min',     'rest'=>'—','seconds'=>600],
    ],
  ],
  [
    'name'        => 'BOXE CARDIO',
    'level'       => 'Débutant',
    'icon'        => '🥊',
    'duration'    => '6 semaines',
    'sessions'    => '3x / sem',
    'description' => 'Techniques de boxe + cardio pour coordination, vitesse et condition.',
    'exercises'   => [
      ['name'=>'Shadowboxing',         'sets'=>'3×2 min',    'rest'=>'30s','seconds'=>120],
      ['name'=>'Jab-Cross combo',      'sets'=>'4×30s',      'rest'=>'20s','seconds'=>30],
      ['name'=>'Sac de frappe',        'sets'=>'4×1min30',   'rest'=>'45s','seconds'=>90],
      ['name'=>'Défense & esquives',   'sets'=>'3×1 min',    'rest'=>'30s','seconds'=>60],
      ['name'=>'Corde à sauter',       'sets'=>'3×2 min',    'rest'=>'30s','seconds'=>120],
    ],
  ],
  [
    'name'        => 'ELITE ATHLETE',
    'level'       => 'Avancé',
    'icon'        => '🏆',
    'duration'    => '12 semaines',
    'sessions'    => '6x / sem',
    'description' => 'Programme élite — force maximale, explosivité et performance sportive.',
    'exercises'   => [
      ['name'=>'Squat max',           'sets'=>'5×3 reps',   'rest'=>'3 min','seconds'=>180],
      ['name'=>'Deadlift',            'sets'=>'5×3 reps',   'rest'=>'3 min','seconds'=>180],
      ['name'=>'Bench Press max',     'sets'=>'5×3 reps',   'rest'=>'3 min','seconds'=>180],
      ['name'=>'Power Clean',         'sets'=>'4×4 reps',   'rest'=>'2 min','seconds'=>120],
      ['name'=>'Sprint + Plyométrie', 'sets'=>'4×6 reps',   'rest'=>'90s',  'seconds'=>90],
    ],
  ],
];
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
      --dark: #0a0a0a; --dark2: #111111; --dark3: #181818; --dark4: #1e1e1e;
      --white: #f5f5f5; --muted: #555; --muted2: #333;
      --border: rgba(200,240,0,.12); --border2: rgba(255,255,255,.06);
      --green: #2ecc71; --orange: #e67e22; --red: #e74c3c; --blue: #3498db;
    }
    html { scroll-behavior: smooth; }
    body { background: var(--dark); color: var(--white); font-family: 'DM Sans', sans-serif; min-height: 100vh; }

    /* ── NAVBAR ── */
    .navbar {
      background: rgba(10,10,10,.95); border-bottom: 1px solid var(--border2);
      backdrop-filter: blur(12px);
      padding: 0 2rem; height: 64px; position: sticky; top: 0; z-index: 100;
      display: flex; align-items: center; justify-content: space-between;
    }
    .nav-logo { display: flex; align-items: center; gap: 9px; font-family: 'Anton', sans-serif; font-size: 1.2rem; letter-spacing: 4px; color: var(--white); text-decoration: none; }
    .logo-dot { width: 9px; height: 9px; background: var(--gold); border-radius: 50%; box-shadow: 0 0 10px var(--gold); }
    .nav-right { display: flex; align-items: center; gap: .75rem; }
    .btn-back { font-size: .72rem; letter-spacing: 2px; text-transform: uppercase; color: var(--muted); text-decoration: none; border: 1px solid var(--border2); border-radius: 6px; padding: 7px 16px; transition: color .2s, border-color .2s; display: flex; align-items: center; gap: 6px; }
    .btn-back:hover { color: var(--gold); border-color: var(--border); }

    /* ── PAGE HEADER ── */
    .page-header {
      text-align: center; padding: 60px 24px 36px; position: relative; overflow: hidden;
      animation: fadeUp .6s ease both;
    }
    .page-header::before {
      content: 'TRAIN'; position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%);
      font-family: 'Anton', sans-serif; font-size: 22vw; color: rgba(200,240,0,.025);
      pointer-events: none; white-space: nowrap; letter-spacing: -4px;
    }
    .eyebrow { font-size: .65rem; letter-spacing: 5px; text-transform: uppercase; color: var(--gold); margin-bottom: 12px; display: block; }
    .page-header h1 { font-family: 'Anton', sans-serif; font-size: clamp(2.5rem, 6vw, 5rem); letter-spacing: 2px; text-transform: uppercase; line-height: .95; }
    .page-header h1 span { color: var(--gold); }
    .page-header p { margin-top: 14px; font-size: .88rem; color: var(--muted); font-weight: 300; max-width: 440px; margin-inline: auto; line-height: 1.7; }

    /* ── STATS BAR ── */
    .stats-bar {
      display: flex; justify-content: center; gap: 2rem; flex-wrap: wrap;
      padding: 0 24px 36px;
      animation: fadeUp .5s .1s ease both;
    }
    .stat-item { display: flex; flex-direction: column; align-items: center; gap: 2px; }
    .stat-item .sn { font-family: 'Anton', sans-serif; font-size: 1.8rem; color: var(--gold); line-height: 1; }
    .stat-item .sl { font-size: .62rem; letter-spacing: 2px; text-transform: uppercase; color: var(--muted); }

    /* ── TOOLBAR ── */
    .toolbar {
      max-width: 1140px; margin: 0 auto;
      padding: 0 24px 28px;
      display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;
      animation: fadeUp .5s .15s ease both;
    }
    .search-wrap {
      flex: 1; min-width: 220px; position: relative;
    }
    .search-wrap svg { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--muted); pointer-events: none; }
    .search-input {
      width: 100%; background: var(--dark3); border: 1px solid var(--border2);
      color: var(--white); font-family: 'DM Sans', sans-serif; font-size: .88rem;
      padding: .65rem 1rem .65rem 2.6rem; border-radius: 8px; outline: none;
      transition: border-color .2s;
    }
    .search-input::placeholder { color: var(--muted); }
    .search-input:focus { border-color: var(--gold); }

    .filters { display: flex; gap: 6px; flex-wrap: wrap; }
    .f-btn {
      background: var(--dark3); border: 1px solid var(--border2); color: var(--muted);
      font-family: 'DM Sans', sans-serif; font-size: .7rem; letter-spacing: 1.5px;
      text-transform: uppercase; padding: .5rem 1.1rem; border-radius: 20px; cursor: pointer;
      transition: all .2s; white-space: nowrap;
    }
    .f-btn:hover { border-color: rgba(200,240,0,.3); color: rgba(200,240,0,.7); }
    .f-btn.active { border-color: var(--gold); color: var(--gold); background: rgba(200,240,0,.06); }

    /* ── GRID ── */
    .page-content { max-width: 1140px; margin: 0 auto; padding: 0 24px 80px; }
    .programs-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 20px; }
    .program-card {
      background: var(--dark2); border: 1px solid var(--border2); border-radius: 16px;
      overflow: hidden; display: flex; flex-direction: column;
      transition: border-color .25s, box-shadow .25s, transform .25s;
      animation: fadeUp .5s ease both;
    }
    .program-card:hover { border-color: rgba(200,240,0,.18); box-shadow: 0 20px 50px rgba(0,0,0,.45); transform: translateY(-4px); }
    .program-card.hidden { display: none; }

    /* accent top */
    .card-accent { height: 2px; background: linear-gradient(90deg, var(--gold), var(--gold2)); }

    /* card header */
    .card-head { padding: 20px 20px 14px; display: flex; align-items: flex-start; gap: 14px; border-bottom: 1px solid var(--border2); }
    .card-icon { width: 48px; height: 48px; flex-shrink: 0; background: rgba(200,240,0,.06); border: 1px solid var(--border); border-radius: 12px; display: grid; place-items: center; font-size: 1.3rem; }
    .card-head-info { flex: 1; }
    .card-title { font-family: 'Anton', sans-serif; font-size: 1.05rem; letter-spacing: 1.5px; text-transform: uppercase; line-height: 1; margin-bottom: 8px; }

    /* level badge */
    .badge { display: inline-flex; align-items: center; gap: 5px; font-size: .58rem; letter-spacing: 2px; text-transform: uppercase; padding: 3px 10px; border-radius: 20px; font-family: 'Anton', sans-serif; }
    .badge::before { content: ''; width: 5px; height: 5px; border-radius: 50%; background: currentColor; }
    .badge-beginner     { background: rgba(46,204,113,.1);  color: var(--green);  border: 1px solid rgba(46,204,113,.2); }
    .badge-intermediate { background: rgba(230,126,34,.1);  color: var(--orange); border: 1px solid rgba(230,126,34,.2); }
    .badge-advanced     { background: rgba(231,76,60,.1);   color: var(--red);    border: 1px solid rgba(231,76,60,.2); }
    .badge-all          { background: rgba(200,240,0,.1);   color: var(--gold);   border: 1px solid var(--border); }

    /* meta */
    .card-meta { display: flex; gap: 6px; margin-top: 10px; flex-wrap: wrap; }
    .meta-pill { display: flex; align-items: center; gap: 5px; background: var(--dark4); border: 1px solid var(--border2); border-radius: 20px; padding: 3px 10px; font-size: .68rem; color: var(--muted); }

    /* progress bar */
    .difficulty-bar { padding: 12px 20px; border-bottom: 1px solid var(--border2); }
    .diff-label { font-size: .6rem; letter-spacing: 2px; text-transform: uppercase; color: var(--muted); margin-bottom: 6px; display: flex; justify-content: space-between; }
    .diff-track { height: 4px; background: var(--dark4); border-radius: 2px; overflow: hidden; }
    .diff-fill { height: 100%; border-radius: 2px; transition: width 1s ease; }
    .diff-1 { width: 33%;  background: var(--green); }
    .diff-2 { width: 66%;  background: var(--orange); }
    .diff-3 { width: 100%; background: var(--red); }
    .diff-all { width: 50%; background: var(--gold); }

    /* description */
    .card-desc { padding: 12px 20px; font-size: .82rem; color: var(--muted); line-height: 1.7; font-weight: 300; }

    /* exercises — collapsible */
    .exercises-toggle {
      width: 100%; background: none; border: none; border-top: 1px solid var(--border2);
      padding: 12px 20px; display: flex; align-items: center; justify-content: space-between;
      cursor: pointer; transition: background .2s;
    }
    .exercises-toggle:hover { background: rgba(200,240,0,.03); }
    .toggle-label { font-size: .62rem; letter-spacing: 3px; text-transform: uppercase; color: var(--gold); display: flex; align-items: center; gap: 8px; }
    .toggle-count { background: var(--dark4); border: 1px solid var(--border2); border-radius: 20px; padding: 1px 8px; font-family: 'Anton', sans-serif; font-size: .6rem; color: var(--muted); }
    .toggle-arrow { transition: transform .3s; color: var(--muted); }
    .toggle-arrow.open { transform: rotate(180deg); }

    .exercises-body { max-height: 0; overflow: hidden; transition: max-height .4s ease; }
    .exercises-body.open { max-height: 600px; }
    .ex-inner { padding: 0 20px 16px; }

    .ex-table { width: 100%; border-collapse: collapse; }
    .ex-table thead tr { border-bottom: 1px solid var(--border2); }
    .ex-table th { font-size: .56rem; letter-spacing: 2px; text-transform: uppercase; color: var(--muted2); font-weight: 500; padding: 0 0 8px; text-align: left; }
    .ex-table th:nth-child(2) { text-align: center; }
    .ex-table th:last-child { text-align: right; }
    .ex-table tbody tr { border-bottom: 1px solid rgba(255,255,255,.03); transition: background .15s; }
    .ex-table tbody tr:last-child { border-bottom: none; }
    .ex-table tbody tr:hover { background: rgba(200,240,0,.025); }
    .ex-table td { padding: 9px 0; font-size: .8rem; vertical-align: middle; }
    .ex-name { display: flex; align-items: center; gap: 8px; color: var(--white); }
    .ex-dot { width: 5px; height: 5px; border-radius: 50%; background: var(--gold); flex-shrink: 0; opacity: .7; }
    .ex-sets { color: var(--gold); font-family: 'Anton', sans-serif; font-size: .78rem; letter-spacing: 1px; white-space: nowrap; display: block; text-align: center; }
    .ex-rest { text-align: right; color: var(--muted); font-size: .72rem; white-space: nowrap; }

    /* timer button */
    .timer-btn {
      background: none; border: 1px solid var(--border2); color: var(--muted);
      border-radius: 6px; padding: 2px 8px; font-size: .68rem; cursor: pointer;
      transition: all .2s; white-space: nowrap; font-family: 'DM Sans', sans-serif;
      display: inline-flex; align-items: center; gap: 4px;
    }
    .timer-btn:hover { border-color: var(--gold); color: var(--gold); }
    .timer-btn.running { border-color: var(--red); color: var(--red); animation: pulse .8s infinite; }
    @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.5} }

    /* card footer — CTA */
    .card-footer {
      padding: 14px 20px; border-top: 1px solid var(--border2);
      display: flex; align-items: center; justify-content: space-between; gap: .75rem;
      margin-top: auto;
    }
    .btn-start {
      flex: 1; background: var(--gold); color: var(--dark);
      font-family: 'Anton', sans-serif; font-size: .8rem; letter-spacing: 2px; text-transform: uppercase;
      border: none; border-radius: 8px; padding: 10px; cursor: pointer;
      transition: background .2s, transform .1s;
      display: flex; align-items: center; justify-content: center; gap: 6px;
    }
    .btn-start:hover { background: var(--gold2); }
    .btn-start:active { transform: scale(.97); }
    .btn-save {
      width: 38px; height: 38px; background: var(--dark3); border: 1px solid var(--border2);
      border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center;
      color: var(--muted); transition: all .2s; flex-shrink: 0;
    }
    .btn-save:hover { border-color: var(--gold); color: var(--gold); }
    .btn-save.saved { background: rgba(200,240,0,.1); border-color: var(--gold); color: var(--gold); }

    /* ── MODAL ── */
    .modal-overlay {
      position: fixed; inset: 0; background: rgba(0,0,0,.8); backdrop-filter: blur(6px);
      z-index: 500; display: flex; align-items: center; justify-content: center; padding: 1rem;
      opacity: 0; pointer-events: none; transition: opacity .3s;
    }
    .modal-overlay.open { opacity: 1; pointer-events: all; }
    .modal {
      background: var(--dark2); border: 1px solid rgba(200,240,0,.15); border-radius: 16px;
      padding: 2.5rem; width: 100%; max-width: 420px;
      transform: translateY(20px); transition: transform .3s;
    }
    .modal-overlay.open .modal { transform: translateY(0); }
    .modal-top { display: flex; align-items: center; gap: 12px; margin-bottom: 1.5rem; }
    .modal-icon { font-size: 2rem; }
    .modal-title { font-family: 'Anton', sans-serif; font-size: 1.4rem; letter-spacing: 1px; text-transform: uppercase; }
    .modal-title span { color: var(--gold); }
    .modal-field { display: flex; flex-direction: column; gap: .4rem; margin-bottom: 1rem; }
    .modal-label { font-size: .62rem; letter-spacing: 3px; text-transform: uppercase; color: var(--muted); }
    .modal-input {
      background: var(--dark3); border: 1px solid #222; color: var(--white);
      font-family: 'DM Sans', sans-serif; font-size: .9rem;
      padding: .7rem 1rem; border-radius: 8px; outline: none; transition: border-color .2s;
    }
    .modal-input:focus { border-color: var(--gold); }
    .modal-input option { background: var(--dark3); }
    .modal-btns { display: flex; gap: .75rem; margin-top: 1.5rem; }
    .btn-confirm {
      flex: 1; background: var(--gold); color: var(--dark); font-family: 'Anton', sans-serif;
      font-size: .9rem; letter-spacing: 2px; text-transform: uppercase;
      border: none; border-radius: 8px; padding: 12px; cursor: pointer; transition: background .2s;
    }
    .btn-confirm:hover { background: var(--gold2); }
    .btn-cancel {
      background: var(--dark3); color: var(--muted); font-family: 'DM Sans', sans-serif;
      font-size: .85rem; border: 1px solid var(--border2); border-radius: 8px;
      padding: 12px 20px; cursor: pointer; transition: all .2s;
    }
    .btn-cancel:hover { border-color: var(--red); color: var(--red); }
    .modal-success {
      text-align: center; padding: 1rem 0;
      font-size: .9rem; color: var(--green); display: none;
    }
    .modal-success.show { display: block; }

    /* ── EMPTY STATE ── */
    .empty-state { text-align: center; padding: 4rem 2rem; color: var(--muted); }
    .empty-state p { font-size: 1rem; margin-top: .5rem; }

    /* ── ANIMATIONS ── */
    @keyframes fadeUp { from{opacity:0;transform:translateY(18px)} to{opacity:1;transform:translateY(0)} }
    .program-card:nth-child(1){animation-delay:.05s}
    .program-card:nth-child(2){animation-delay:.10s}
    .program-card:nth-child(3){animation-delay:.15s}
    .program-card:nth-child(4){animation-delay:.20s}
    .program-card:nth-child(5){animation-delay:.25s}
    .program-card:nth-child(6){animation-delay:.30s}

    /* ── RESPONSIVE ── */
    @media(max-width:680px){
      .programs-grid{grid-template-columns:1fr}
      .toolbar{flex-direction:column;align-items:stretch}
      .stats-bar{gap:1rem}
    }
  </style>
</head>
<body>

  <nav class="navbar">
    <a href="home.php" class="nav-logo"><span class="logo-dot"></span>ADRENA</a>
    <div class="nav-right">
      <a href="dashboard.php" class="btn-back">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
        Dashboard
      </a>
    </div>
  </nav>

  <!-- PAGE HEADER -->
  <div class="page-header">
    <span class="eyebrow">✦ Entraînement</span>
    <h1>TRAINING <span>PROGRAMS</span></h1>
    <p>Choisis le programme adapté à ton niveau. Chaque programme inclut exercices, séries et temps de repos avec timer intégré.</p>
  </div>

  <!-- STATS BAR -->
  <div class="stats-bar">
    <div class="stat-item"><span class="sn">6</span><span class="sl">Programmes</span></div>
    <div class="stat-item"><span class="sn">3</span><span class="sl">Niveaux</span></div>
    <div class="stat-item"><span class="sn">30+</span><span class="sl">Exercices</span></div>
    <div class="stat-item"><span class="sn">12</span><span class="sl">Semaines max</span></div>
  </div>

  <!-- TOOLBAR -->
  <div class="toolbar">
    <div class="search-wrap">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
      <input class="search-input" type="text" placeholder="Rechercher un programme..." id="searchInput" oninput="filterAll()"/>
    </div>
    <div class="filters">
      <button class="f-btn active" data-level="all"          onclick="setFilter(this)">Tous</button>
      <button class="f-btn"        data-level="debutant"     onclick="setFilter(this)">Débutant</button>
      <button class="f-btn"        data-level="intermediaire" onclick="setFilter(this)">Intermédiaire</button>
      <button class="f-btn"        data-level="avance"       onclick="setFilter(this)">Avancé</button>
      <button class="f-btn"        data-level="tous"         onclick="setFilter(this)">Tous niveaux</button>
    </div>
  </div>

  <!-- PROGRAMS GRID -->
  <div class="page-content">
    <div class="programs-grid" id="grid">

      <?php
      $has_db = $result && $result->num_rows > 0;
      if ($has_db):
        while ($row = $result->fetch_assoc()):
          $level = strtolower($row['level'] ?? '');
          if (str_contains($level,'beginner')||str_contains($level,'débutant')||str_contains($level,'debutant')) { $bc='badge-beginner'; $dl='debutant'; $di='diff-1'; $dt='Débutant'; }
          elseif (str_contains($level,'intermediate')||str_contains($level,'intermédiaire')) { $bc='badge-intermediate'; $dl='intermediaire'; $di='diff-2'; $dt='Intermédiaire'; }
          elseif (str_contains($level,'advanced')||str_contains($level,'avancé')) { $bc='badge-advanced'; $dl='avance'; $di='diff-3'; $dt='Avancé'; }
          else { $bc='badge-all'; $dl='tous'; $di='diff-all'; $dt='Tous niveaux'; }
          $raw_ex = $row['exercises'] ?? '';
          $ex_lines = array_filter(explode("\n", $raw_ex));
          $exercises = [];
          foreach ($ex_lines as $line) {
            $parts = explode('|', $line);
            $exercises[] = ['name'=>trim($parts[0]??''), 'sets'=>trim($parts[1]??'—'), 'rest'=>trim($parts[2]??'—'), 'seconds'=>intval($parts[3]??60)];
          }
          if (empty($exercises)) $exercises = [['name'=>'Exercice 1','sets'=>'3×10','rest'=>'60s','seconds'=>60]];
          $ex_count = count($exercises);
          $card_id = 'card-db-'.$row['id'];
      ?>
        <div class="program-card" data-level="<?php echo $dl; ?>" data-name="<?php echo strtolower(htmlspecialchars($row['name'])); ?>" id="<?php echo $card_id; ?>">
          <div class="card-accent"></div>
          <div class="card-head">
            <div class="card-icon">💪</div>
            <div class="card-head-info">
              <div class="card-title"><?php echo htmlspecialchars($row['name']); ?></div>
              <span class="badge <?php echo $bc; ?>"><?php echo htmlspecialchars($row['level'] ?? 'Tous niveaux'); ?></span>
              <div class="card-meta">
                <?php if(!empty($row['duration'])): ?>
                <div class="meta-pill"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2" stroke-linecap="round"/></svg><?php echo htmlspecialchars($row['duration']); ?></div>
                <?php endif; if(!empty($row['sessions'])): ?>
                <div class="meta-pill"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg><?php echo htmlspecialchars($row['sessions']); ?></div>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <div class="difficulty-bar">
            <div class="diff-label"><span>Difficulté</span><span><?php echo $dt; ?></span></div>
            <div class="diff-track"><div class="diff-fill <?php echo $di; ?>"></div></div>
          </div>
          <div class="card-desc"><?php echo htmlspecialchars($row['description']); ?></div>
          <button class="exercises-toggle" onclick="toggleEx(this)">
            <span class="toggle-label">Programme d'exercices <span class="toggle-count"><?php echo $ex_count; ?></span></span>
            <svg class="toggle-arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
          </button>
          <div class="exercises-body">
            <div class="ex-inner">
              <table class="ex-table">
                <thead><tr><th>Exercice</th><th>Séries</th><th>Repos</th></tr></thead>
                <tbody>
                  <?php foreach($exercises as $i=>$ex): ?>
                  <tr>
                    <td><div class="ex-name"><span class="ex-dot"></span><?php echo htmlspecialchars($ex['name']); ?></div></td>
                    <td><span class="ex-sets"><?php echo htmlspecialchars($ex['sets']); ?></span></td>
                    <td>
                      <span class="ex-rest">
                        <?php if($ex['rest'] !== '—'): ?>
                        <button class="timer-btn" data-seconds="<?php echo $ex['seconds']; ?>" onclick="startTimer(this)"><?php echo $ex['rest']; ?> ▶</button>
                        <?php else: echo '—'; endif; ?>
                      </span>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer">
            <button class="btn-start" onclick="openModal('<?php echo htmlspecialchars($row['name']); ?>','<?php echo $card_id; ?>')">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="5 3 19 12 5 21 5 3"/></svg>
              Commencer ce programme
            </button>
            <button class="btn-save" title="Sauvegarder" onclick="toggleSave(this)">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2z"/></svg>
            </button>
          </div>
        </div>
      <?php endwhile;
      else:
        foreach ($static_programs as $idx => $prog):
          $level = strtolower($prog['level']);
          if (str_contains($level,'débutant'))         { $bc='badge-beginner'; $dl='debutant'; $di='diff-1'; }
          elseif (str_contains($level,'intermédiaire')) { $bc='badge-intermediate'; $dl='intermediaire'; $di='diff-2'; }
          elseif (str_contains($level,'avancé'))        { $bc='badge-advanced'; $dl='avance'; $di='diff-3'; }
          else { $bc='badge-all'; $dl='tous'; $di='diff-all'; }
          $card_id = 'card-' . $idx;
          $ex_count = count($prog['exercises']);
      ?>
        <div class="program-card" data-level="<?php echo $dl; ?>" data-name="<?php echo strtolower($prog['name']); ?>" id="<?php echo $card_id; ?>">
          <div class="card-accent"></div>
          <div class="card-head">
            <div class="card-icon"><?php echo $prog['icon']; ?></div>
            <div class="card-head-info">
              <div class="card-title"><?php echo $prog['name']; ?></div>
              <span class="badge <?php echo $bc; ?>"><?php echo $prog['level']; ?></span>
              <div class="card-meta">
                <div class="meta-pill"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2" stroke-linecap="round"/></svg><?php echo $prog['duration']; ?></div>
                <div class="meta-pill"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg><?php echo $prog['sessions']; ?></div>
              </div>
            </div>
          </div>
          <div class="difficulty-bar">
            <div class="diff-label"><span>Difficulté</span><span><?php echo $prog['level']; ?></span></div>
            <div class="diff-track"><div class="diff-fill <?php echo $di; ?>"></div></div>
          </div>
          <div class="card-desc"><?php echo $prog['description']; ?></div>
          <button class="exercises-toggle" onclick="toggleEx(this)">
            <span class="toggle-label">Programme d'exercices <span class="toggle-count"><?php echo $ex_count; ?></span></span>
            <svg class="toggle-arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
          </button>
          <div class="exercises-body">
            <div class="ex-inner">
              <table class="ex-table">
                <thead><tr><th>Exercice</th><th>Séries</th><th>Repos</th></tr></thead>
                <tbody>
                  <?php foreach($prog['exercises'] as $ex): ?>
                  <tr>
                    <td><div class="ex-name"><span class="ex-dot"></span><?php echo $ex['name']; ?></div></td>
                    <td><span class="ex-sets"><?php echo $ex['sets']; ?></span></td>
                    <td>
                      <span class="ex-rest">
                        <?php if($ex['rest'] !== '—'): ?>
                        <button class="timer-btn" data-seconds="<?php echo $ex['seconds']; ?>" onclick="startTimer(this)"><?php echo $ex['rest']; ?> ▶</button>
                        <?php else: echo '—'; endif; ?>
                      </span>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer">
            <button class="btn-start" onclick="openModal('<?php echo $prog['name']; ?>','<?php echo $card_id; ?>')">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="5 3 19 12 5 21 5 3"/></svg>
              Commencer ce programme
            </button>
            <button class="btn-save" title="Sauvegarder" onclick="toggleSave(this)">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2z"/></svg>
            </button>
          </div>
        </div>
      <?php endforeach; endif; ?>

    </div>

    <!-- empty state -->
    <div class="empty-state" id="emptyState" style="display:none">
      <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#333" stroke-width="1.5"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
      <p>Aucun programme trouvé.</p>
    </div>
  </div>

  <!-- ══ MODAL S'INSCRIRE ══ -->
  <div class="modal-overlay" id="modalOverlay" onclick="closeModal(event)">
    <div class="modal" onclick="event.stopPropagation()">
      <div class="modal-top">
        <div class="modal-icon" id="modalIcon">💪</div>
        <div>
          <div class="modal-title">COMMENCER <span id="modalName">?</span></div>
          <div style="font-size:.75rem;color:var(--muted);margin-top:3px;">Choisis ta date de début</div>
        </div>
      </div>
      <div class="modal-field">
        <label class="modal-label">Date de début</label>
        <input type="date" class="modal-input" id="modalDate"/>
      </div>
      <div class="modal-field">
        <label class="modal-label">Séances par semaine</label>
        <select class="modal-input" id="modalSessions">
          <option value="2">2 séances / sem</option>
          <option value="3" selected>3 séances / sem</option>
          <option value="4">4 séances / sem</option>
          <option value="5">5 séances / sem</option>
        </select>
      </div>
      <div class="modal-field">
        <label class="modal-label">Objectif personnel (optionnel)</label>
        <input type="text" class="modal-input" id="modalGoal" placeholder="Ex: perdre 5kg, courir 10km..."/>
      </div>
      <div class="modal-success" id="modalSuccess">✅ Programme ajouté !</div>
      <div class="modal-btns" id="modalBtns">
        <button class="btn-cancel" onclick="closeModalBtn()">Annuler</button>
        <button class="btn-confirm" onclick="confirmProgram()">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="vertical-align:middle;margin-right:4px"><polygon points="5 3 19 12 5 21 5 3"/></svg>
          Lancer le programme
        </button>
      </div>
    </div>
  </div>

  <script>
    // ── FILTER & SEARCH ──────────────────────
    let currentLevel = 'all';

    function setFilter(btn) {
      document.querySelectorAll('.f-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      currentLevel = btn.dataset.level;
      filterAll();
    }

    function filterAll() {
      const q = document.getElementById('searchInput').value.toLowerCase().trim();
      let visible = 0;
      document.querySelectorAll('.program-card').forEach(card => {
        const matchLevel = currentLevel === 'all' || card.dataset.level === currentLevel;
        const matchSearch = !q || card.dataset.name.includes(q) || card.querySelector('.card-desc').textContent.toLowerCase().includes(q);
        const show = matchLevel && matchSearch;
        card.classList.toggle('hidden', !show);
        if (show) visible++;
      });
      document.getElementById('emptyState').style.display = visible === 0 ? 'block' : 'none';
    }

    // ── COLLAPSE EXERCISES ───────────────────
    function toggleEx(btn) {
      const body  = btn.nextElementSibling;
      const arrow = btn.querySelector('.toggle-arrow');
      const isOpen = body.classList.toggle('open');
      arrow.classList.toggle('open', isOpen);
    }

    // ── TIMER ────────────────────────────────
    let activeTimer = null;

    function startTimer(btn) {
      if (btn.classList.contains('running')) {
        clearInterval(activeTimer);
        btn.classList.remove('running');
        btn.textContent = btn.dataset.original || btn.dataset.seconds + 's ▶';
        return;
      }
      if (activeTimer) clearInterval(activeTimer);
      document.querySelectorAll('.timer-btn.running').forEach(b => {
        b.classList.remove('running');
        b.textContent = b.dataset.original || b.dataset.seconds + 's ▶';
      });

      btn.dataset.original = btn.textContent;
      let secs = parseInt(btn.dataset.seconds);
      btn.classList.add('running');

      function tick() {
        if (secs <= 0) {
          clearInterval(activeTimer);
          btn.classList.remove('running');
          btn.textContent = '✓ OK!';
          setTimeout(() => { btn.textContent = btn.dataset.original; }, 2000);
          return;
        }
        btn.textContent = '⏱ ' + secs + 's';
        secs--;
      }
      tick();
      activeTimer = setInterval(tick, 1000);
    }

    // ── SAVE TOGGLE ──────────────────────────
    function toggleSave(btn) {
      btn.classList.toggle('saved');
      const svg = btn.querySelector('svg');
      if (btn.classList.contains('saved')) {
        svg.setAttribute('fill', '#c8f000');
      } else {
        svg.setAttribute('fill', 'none');
      }
    }

    // ── MODAL ────────────────────────────────
    let currentProgram = '';

    function openModal(name, cardId) {
      currentProgram = name;
      document.getElementById('modalName').textContent = name;
      document.getElementById('modalDate').value = new Date().toISOString().split('T')[0];
      document.getElementById('modalSuccess').classList.remove('show');
      document.getElementById('modalBtns').style.display = 'flex';
      document.getElementById('modalGoal').value = '';
      document.getElementById('modalOverlay').classList.add('open');
    }

    function closeModal(e) {
      if (e.target === document.getElementById('modalOverlay')) {
        document.getElementById('modalOverlay').classList.remove('open');
      }
    }
    function closeModalBtn() {
      document.getElementById('modalOverlay').classList.remove('open');
    }

    function confirmProgram() {
      const date     = document.getElementById('modalDate').value;
      const sessions = document.getElementById('modalSessions').value;
      const goal     = document.getElementById('modalGoal').value;

      if (!date) { document.getElementById('modalDate').focus(); return; }

      // Send to server
      fetch('save_program.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `program=${encodeURIComponent(currentProgram)}&start_date=${date}&sessions=${sessions}&goal=${encodeURIComponent(goal)}`
      }).catch(() => {}); // backend optional

      document.getElementById('modalBtns').style.display = 'none';
      document.getElementById('modalSuccess').classList.add('show');
      setTimeout(() => {
        document.getElementById('modalOverlay').classList.remove('open');
      }, 2200);
    }

    // ── SET MIN DATE ─────────────────────────
    document.getElementById('modalDate').min = new Date().toISOString().split('T')[0];
  </script>
</body>
</html>
