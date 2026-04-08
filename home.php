<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.html");
    exit();
}

$sql = "SELECT * FROM trainers";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>ADRENA — Premium Fitness</title>
  <link rel="stylesheet" href="home.css"/>
</head>
<body>

  <!-- ══ NAVBAR ══ -->
  <nav class="navbar" id="navbar">
    <div class="nav-inner">
      <a href="#" class="nav-logo"><span class="logo-dot"></span>ADRENA</a>
      <ul class="nav-links">
        <li><a href="#services">Services</a></li>
        <li><a href="#trainers">Coachs</a></li>
        <li><a href="#gallery">Galerie</a></li>
        <li><a href="#bmi">BMI</a></li>
        <li><a href="#pricing">Tarifs</a></li>
        <li><a href="shop.php">Shop</a></li>
        <li><a href="#contact">Contact</a></li>
      </ul>
      <div class="nav-actions">

        <!-- SHOP ICON -->
        <a href="shop.php" class="nav-icon-btn" title="Shop">
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
            <line x1="3" y1="6" x2="21" y2="6"/>
            <path d="M16 10a4 4 0 01-8 0"/>
          </svg>
        </a>

        <!-- REGISTER ICON -->
        <a href="register.html" class="nav-icon-btn" title="S'inscrire">
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <path d="M19 8v6M22 11h-6"/>
          </svg>
        </a>

        <!-- DASHBOARD BUTTON -->
        <a href="dashboard.php" class="btn-dashboard">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="3" y="3" width="7" height="7" rx="1"/>
            <rect x="14" y="3" width="7" height="7" rx="1"/>
            <rect x="3" y="14" width="7" height="7" rx="1"/>
            <rect x="14" y="14" width="7" height="7" rx="1"/>
          </svg>
          Dashboard
        </a>

      </div>
      <button class="burger" id="burger" aria-label="menu">
        <span></span><span></span><span></span>
      </button>
    </div>
    <div class="mobile-menu" id="mobileMenu">
      <a href="#services"     class="mob-link">Services</a>
      <a href="#trainers"     class="mob-link">Coachs</a>
      <a href="#gallery"      class="mob-link">Galerie</a>
      <a href="#bmi"          class="mob-link">BMI</a>
      <a href="#pricing"      class="mob-link">Tarifs</a>
      <a href="shop.php"      class="mob-link">Shop</a>
      <a href="#contact"      class="mob-link">Contact</a>
      <a href="dashboard.php" class="mob-link gold">Dashboard →</a>
      <a href="register.html" class="mob-link gold">Rejoindre →</a>
    </div>
  </nav>

  <!-- ══ HERO ══ -->
  <section class="hero" id="hero">
    <div class="hero-bg">
      <img src="hero3.jpg" alt="hero" class="hero-img"/>
      <div class="hero-overlay"></div>
      <div class="hero-noise"></div>
    </div>
    <div class="hero-content">
      <p class="hero-eyebrow"><span class="eyebrow-dot"></span>Premium Fitness Club — Tunis</p>
      <h1 class="hero-title">
        <span class="hero-line1">CONSTRUIS</span>
        <span class="hero-line2">TON CORPS</span>
        <span class="hero-line3">DE <em>RÊVE</em></span>
      </h1>
      <p class="hero-desc">Rejoins ADRENA — l'espace où coachs d'élite, équipements professionnels et ambiance incomparable se réunissent pour transformer ta vie.</p>
      <div class="hero-btns">
        <a href="register.html" class="btn-gold-lg">Commencer maintenant</a>
        <a href="#services" class="btn-outline-lg">Découvrir →</a>
      </div>
      <div class="hero-stats">
        <div class="stat"><span class="stat-n">1 200<sup>+</sup></span><span class="stat-l">Membres actifs</span></div>
        <div class="stat-sep"></div>
        <div class="stat"><span class="stat-n">15</span><span class="stat-l">Coachs certifiés</span></div>
        <div class="stat-sep"></div>
        <div class="stat"><span class="stat-n">98<sup>%</sup></span><span class="stat-l">Satisfaction</span></div>
        <div class="stat-sep"></div>
        <div class="stat"><span class="stat-n">6h–23h</span><span class="stat-l">Ouvert tous les jours</span></div>
      </div>
    </div>
    <div class="hero-scroll"><span></span><span></span><span></span></div>
  </section>

  <!-- ══ BAND ══ -->
  <div class="band">
    <div class="band-track">
      <span>CARDIO</span><span class="band-dot">✦</span>
      <span>BOXE &amp; MMA</span><span class="band-dot">✦</span>
      <span>YOGA &amp; STRETCHING</span><span class="band-dot">✦</span>
      <span>COACHING PERSONNALISÉ</span><span class="band-dot">✦</span>
      <span>CARDIO</span><span class="band-dot">✦</span>
      <span>BOXE &amp; MMA</span><span class="band-dot">✦</span>
      <span>YOGA &amp; STRETCHING</span><span class="band-dot">✦</span>
      <span>COACHING PERSONNALISÉ</span><span class="band-dot">✦</span>
    </div>
  </div>

  <!-- ══ SERVICES ══ -->
  <section class="section" id="services">
    <div class="container">
      <div class="sec-head">
        <p class="sec-eyebrow">Ce qu'on offre</p>
        <h2 class="sec-title">NOS <span>SERVICES</span></h2>
        <p class="sec-sub">Tout ce dont tu as besoin pour atteindre tes objectifs, sous un seul toit.</p>
      </div>
      <div class="services-grid services-4">
        <div class="srv-card">
          <div class="srv-icon-wrap">
            <svg viewBox="0 0 48 48" fill="none"><circle cx="24" cy="12" r="4" stroke="#c8f000" stroke-width="2.2"/><path d="M16 28l4-8 4 4 4-10 4 6" stroke="#c8f000" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/><path d="M10 36h28" stroke="#c8f000" stroke-width="2.2" stroke-linecap="round"/><path d="M20 36v-4M28 36v-4" stroke="#c8f000" stroke-width="2" stroke-linecap="round"/><rect x="6" y="30" width="36" height="4" rx="2" stroke="#c8f000" stroke-width="1.5"/></svg>
          </div>
          <h3>Cardio</h3>
          <p>Tapis, vélos, elliptiques et rameurs haut de gamme pour booster ton endurance et brûler les calories efficacement.</p>
          <span class="srv-tag">Zone dédiée</span>
        </div>
        <div class="srv-card">
          <div class="srv-icon-wrap">
            <svg viewBox="0 0 48 48" fill="none"><rect x="14" y="8" width="16" height="22" rx="8" stroke="#c8f000" stroke-width="2.2"/><path d="M14 20h16" stroke="#c8f000" stroke-width="1.8" stroke-linecap="round"/><path d="M18 30v6a2 2 0 004 0v-6" stroke="#c8f000" stroke-width="2" stroke-linecap="round"/><path d="M26 30v6a2 2 0 004 0v-6" stroke="#c8f000" stroke-width="2" stroke-linecap="round"/><path d="M10 18h4M30 18h4" stroke="#c8f000" stroke-width="2" stroke-linecap="round"/></svg>
          </div>
          <h3>Boxe & MMA</h3>
          <p>Ring professionnel, sacs de frappe, coachs spécialisés. Cardio boxing ou arts martiaux mixtes pour tous niveaux.</p>
          <span class="srv-tag">Tous niveaux</span>
        </div>
        <div class="srv-card">
          <div class="srv-icon-wrap">
            <svg viewBox="0 0 48 48" fill="none"><circle cx="24" cy="8" r="3.5" stroke="#c8f000" stroke-width="2.2"/><path d="M24 12v10" stroke="#c8f000" stroke-width="2.2" stroke-linecap="round"/><path d="M14 20c3 0 5 2 10 2s7-2 10-2" stroke="#c8f000" stroke-width="2" stroke-linecap="round"/><path d="M20 22l-6 8M28 22l6 8" stroke="#c8f000" stroke-width="2" stroke-linecap="round"/><path d="M24 22v14" stroke="#c8f000" stroke-width="2" stroke-linecap="round"/><path d="M18 36h12" stroke="#c8f000" stroke-width="2" stroke-linecap="round"/></svg>
          </div>
          <h3>Yoga & Stretching</h3>
          <p>Cours collectifs de yoga, mobilité et récupération active. Corps équilibré, esprit reposé, flexibilité fonctionnelle.</p>
          <span class="srv-tag">Cours collectifs</span>
        </div>
        <div class="srv-card">
          <div class="srv-icon-wrap">
            <svg viewBox="0 0 48 48" fill="none"><circle cx="18" cy="12" r="5" stroke="#c8f000" stroke-width="2.2"/><path d="M8 36c0-6 4-10 10-10s10 4 10 10" stroke="#c8f000" stroke-width="2.2" stroke-linecap="round"/><circle cx="34" cy="18" r="3" stroke="#c8f000" stroke-width="1.8"/><path d="M28 36c0-4 2-7 6-7" stroke="#c8f000" stroke-width="1.8" stroke-linecap="round"/><path d="M32 10l2 2 5-5" stroke="#c8f000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </div>
          <h3>Coaching Personnalisé</h3>
          <p>Programme 100% sur mesure avec un coach dédié. Objectifs clairs, suivi continu et résultats mesurables garantis.</p>
          <span class="srv-tag">Coach dédié</span>
        </div>
      </div>
    </div>
  </section>

  <!-- ══ WHY US ══ -->
  <section class="why-section">
    <div class="container">
      <div class="why-grid">
        <div class="why-text">
          <p class="sec-eyebrow">Pourquoi ADRENA ?</p>
          <h2 class="sec-title">L'EXCELLENCE<br/><span>À CHAQUE</span><br/>RÉPÉTITION</h2>
          <p class="why-desc">Chez ADRENA, nous croyons que chaque séance est une opportunité de te dépasser. Nos coachs certifiés, nos équipements de pointe et notre communauté soudée font de nous le gym premium de Tunis.</p>
          <ul class="why-list">
            <li><span class="wl-dot"></span>Équipements Life Fitness & Technogym</li>
            <li><span class="wl-dot"></span>Coachs diplômés d'État &amp; certifiés internationaux</li>
            <li><span class="wl-dot"></span>Application mobile pour suivre tes progrès</li>
            <li><span class="wl-dot"></span>Vestiaires premium &amp; douches chaudes</li>
            <li><span class="wl-dot"></span>Parking gratuit &amp; WiFi haut débit</li>
          </ul>
          <a href="register.html" class="btn-gold-lg" style="display:inline-flex;margin-top:2rem;">Rejoindre maintenant</a>
        </div>
        <div class="why-visual">
          <div class="why-img-wrap">
            <img src="description.jpg" alt="Interior" class="why-img" onerror="this.parentElement.classList.add('why-img-fallback')"/>
            <div class="why-img-overlay"></div>
          </div>
          <div class="why-badge">
            <span class="badge-n">5★</span>
            <span class="badge-l">Noté par nos membres</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ══ TRAINERS ══ -->
  <section class="section" id="trainers">
    <div class="container">
      <div class="sec-head">
        <p class="sec-eyebrow">L'équipe</p>
        <h2 class="sec-title">NOS <span>COACHS</span></h2>
        <p class="sec-sub">Des professionnels certifiés passionnés par ta transformation.</p>
      </div>
       <!-- Coaches Grid -->
    <section class="coaches">
        <div class="container">
            <div class="grid">
                <!-- Coach 1 -->
                <div class="card">
                    <div class="card-image">
                        <img src="https://d2xsxph8kpxj0f.cloudfront.net/310519663341821827/4PPSfEYX8ugkVRw4t2qqWn/coach-karim-cardio-3zQvvddC3TaQQ9v7AD3ACM.webp" alt="Karim Mansouri">
                        <div class="badge">Cardio & Endurance</div>
                        <div class="overlay">
                            <a href="#" class="social">in</a>
                            <a href="#" class="social">ig</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <h3>Karim Mansouri</h3>
                        <p>Spécialiste en programmes cardio intensifs et perte de poids. 8 ans d'expérience en coaching.</p>
                        <div class="stats">
                            <div class="rating">
                                <span class="stars">★★★★★</span>
                                <span class="score">4.9</span>
                            </div>
                            <span class="clients">320 clients</span>
                        </div>
                    </div>
                </div>

                <!-- Coach 2 -->
                <div class="card">
                    <div class="card-image">
                        <img src="https://d2xsxph8kpxj0f.cloudfront.net/310519663341821827/4PPSfEYX8ugkVRw4t2qqWn/coach-yassine-boxing-JtLoNA3JUsGqX4St7ACpJx.webp" alt="Yassine Trabelsi">
                        <div class="badge">Boxe & MMA</div>
                        <div class="overlay">
                            <a href="#" class="social">in</a>
                            <a href="#" class="social">ig</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <h3>Yassine Trabelsi</h3>
                        <p>Ex-champion régional de boxe thaï. Forme des athlètes de combat depuis 6 ans.</p>
                        <div class="stats">
                            <div class="rating">
                                <span class="stars">★★★★★</span>
                                <span class="score">4.9</span>
                            </div>
                            <span class="clients">195 clients</span>
                        </div>
                    </div>
                </div>

                <!-- Coach 3 -->
                <div class="card">
                    <div class="card-image">
                        <img src="https://d2xsxph8kpxj0f.cloudfront.net/310519663341821827/4PPSfEYX8ugkVRw4t2qqWn/coach-nour-yoga-ggFYYjnejVa97BAES8oWTq.webp" alt="Nour Chouchane">
                        <div class="badge">Yoga & Mobilité</div>
                        <div class="overlay">
                            <a href="#" class="social">in</a>
                            <a href="#" class="social">ig</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <h3>Nour Chouchane</h3>
                        <p>Certifiée RYT-500. Experte en récupération active et flexibilité fonctionnelle.</p>
                        <div class="stats">
                            <div class="rating">
                                <span class="stars">★★★★★</span>
                                <span class="score">5.0</span>
                            </div>
                            <span class="clients">240 clients</span>
                        </div>
                    </div>
                </div>

                <!-- Coach 4 -->
                <div class="card">
                    <div class="card-image">
                        <img src="https://d2xsxph8kpxj0f.cloudfront.net/310519663341821827/4PPSfEYX8ugkVRw4t2qqWn/coach-sarra-personal-HQdB2nVcYVRxC6BqJDSw5d.webp" alt="Sarra Belhadj">
                        <div class="badge">Coaching Perso</div>
                        <div class="overlay">
                            <a href="#" class="social">in</a>
                            <a href="#" class="social">ig</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <h3>Sarra Belhadj</h3>
                        <p>Spécialiste en transformation corporelle sur mesure. Suivi nutrition & entraînement combinés.</p>
                        <div class="stats">
                            <div class="rating">
                                <span class="stars">★★★★☆</span>
                                <span class="score">4.8</span>
                            </div>
                            <span class="clients">280 clients</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
      <div class="trainers-grid">
        <?php while($row = $result->fetch_assoc()): ?>
        <div class="trainer-card">
          <div class="trainer-img-wrap">
            <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" onerror="this.style.display='none';this.nextElementSibling.style.display='flex'"/>
            <div class="trainer-placeholder" style="display:none">
              <svg width="64" height="64" viewBox="0 0 64 64" fill="none"><circle cx="32" cy="24" r="14" stroke="#c8f000" stroke-width="2"/><path d="M8 58c0-13 11-22 24-22s24 9 24 22" stroke="#c8f000" stroke-width="2" stroke-linecap="round"/></svg>
            </div>
            <div class="trainer-overlay">
              <div class="trainer-socials"><a href="#" class="tsoc">in</a><a href="#" class="tsoc">ig</a></div>
            </div>
            <div class="trainer-spec-badge"><?php echo htmlspecialchars($row['speciality']); ?></div>
          </div>
          <div class="trainer-body">
            <h3 class="trainer-name"><?php echo htmlspecialchars($row['name']); ?></h3>
            <p class="trainer-bio"><?php echo htmlspecialchars($row['bio']); ?></p>
            <?php if (!empty($row['rating']) || !empty($row['clients'])): ?>
            <div class="trainer-stats">
              <?php if (!empty($row['rating'])): ?>
              <span class="tstat"><svg width="13" height="13" viewBox="0 0 24 24" fill="#c8f000"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><?php echo htmlspecialchars($row['rating']); ?></span>
              <?php endif; ?>
              <?php if (!empty($row['clients'])): ?>
              <span class="tstat"><?php echo htmlspecialchars($row['clients']); ?> clients</span>
              <?php endif; ?>
            </div>
            <?php endif; ?>
          </div>
        </div>
        <?php endwhile; ?>
      </div>
    </div>
  </section>

  <!-- ══ GALLERY ══ -->
  <section class="section gallery-section" id="gallery">
    <div class="container">
      <div class="sec-head">
        <p class="sec-eyebrow">L'ambiance</p>
        <h2 class="sec-title">NOTRE <span>GALERIE</span></h2>
        <p class="sec-sub">Découvre l'espace, l'atmosphère et la communauté ADRENA.</p>
      </div>
      <div class="gallery-grid">
        <div class="gal-item gal-tall"><img src="gym1.jpg" alt="Salle" onerror="this.parentElement.classList.add('gal-fallback');this.remove()"/><div class="gal-fallback-inner"></div><div class="gal-overlay"><span>Salle principale</span></div></div>
        <div class="gal-item"><img src="gym2.jpg" alt="Cardio" onerror="this.parentElement.classList.add('gal-fallback');this.remove()"/><div class="gal-fallback-inner"></div><div class="gal-overlay"><span>Zone Cardio</span></div></div>
        <div class="gal-item"><img src="gym3.jpg" alt="Boxe" onerror="this.parentElement.classList.add('gal-fallback');this.remove()"/><div class="gal-fallback-inner"></div><div class="gal-overlay"><span>Ring de Boxe</span></div></div>
        <div class="gal-item gal-wide"><img src="gym4.jpg" alt="Yoga" onerror="this.parentElement.classList.add('gal-fallback');this.remove()"/><div class="gal-fallback-inner"></div><div class="gal-overlay"><span>Studio Yoga</span></div></div>
        <div class="gal-item"><img src="gym5.jpg" alt="Coaching" onerror="this.parentElement.classList.add('gal-fallback');this.remove()"/><div class="gal-fallback-inner"></div><div class="gal-overlay"><span>Espace Coaching</span></div></div>
      </div>
    </div>
  </section>

  <!-- ══ BMI CALCULATOR ══ -->
  <section class="section bmi-section" id="bmi">
    <div class="container">
      <div class="sec-head">
        <p class="sec-eyebrow">Évalue-toi</p>
        <h2 class="sec-title">CALCUL <span>IMC / BMI</span></h2>
        <p class="sec-sub">Calcule ton Indice de Masse Corporelle et découvre ton programme adapté.</p>
      </div>
      <div class="bmi-grid">
        <div class="bmi-form-wrap">
          <div class="bmi-toggle">
            <button class="bmi-unit active" id="btnCm" onclick="setUnit('cm')">Métrique (cm/kg)</button>
            <button class="bmi-unit" id="btnFt" onclick="setUnit('ft')">Impérial (ft/lbs)</button>
          </div>
          <div class="bmi-fields">
            <div class="bmi-field">
              <label>Genre</label>
              <div class="gender-btns">
                <button class="gender-btn active" id="btnM" onclick="setGender('m')">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="10" cy="14" r="6"/><path d="M19 5l-5.5 5.5M19 5h-5M19 5v5"/></svg>
                  Homme
                </button>
                <button class="gender-btn" id="btnF" onclick="setGender('f')">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="10" r="6"/><line x1="12" y1="16" x2="12" y2="22"/><line x1="9" y1="19" x2="15" y2="19"/></svg>
                  Femme
                </button>
              </div>
            </div>
            <div class="bmi-field">
              <label>Âge</label>
              <div class="bmi-input-wrap">
                <input type="number" id="bmiAge" placeholder="25" min="10" max="100"/>
                <span class="bmi-unit-label">ans</span>
              </div>
            </div>
            <div class="bmi-field" id="metricFields">
              <div class="bmi-row2">
                <div>
                  <label>Taille</label>
                  <div class="bmi-input-wrap">
                    <input type="number" id="bmiHeight" placeholder="175" min="100" max="250"/>
                    <span class="bmi-unit-label">cm</span>
                  </div>
                </div>
                <div>
                  <label>Poids</label>
                  <div class="bmi-input-wrap">
                    <input type="number" id="bmiWeight" placeholder="70" min="30" max="300"/>
                    <span class="bmi-unit-label">kg</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="bmi-field" id="imperialFields" style="display:none">
              <div class="bmi-row2">
                <div>
                  <label>Taille</label>
                  <div class="bmi-input-wrap">
                    <input type="number" id="bmiHeightFt" placeholder="5.9" step="0.1"/>
                    <span class="bmi-unit-label">ft</span>
                  </div>
                </div>
                <div>
                  <label>Poids</label>
                  <div class="bmi-input-wrap">
                    <input type="number" id="bmiWeightLbs" placeholder="154"/>
                    <span class="bmi-unit-label">lbs</span>
                  </div>
                </div>
              </div>
            </div>
            <button class="btn-gold-lg" style="width:100%;justify-content:center;margin-top:.5rem;" onclick="calculateBMI()">
              Calculer mon IMC
            </button>
          </div>
        </div>

        <!-- RESULT -->
        <div class="bmi-result" id="bmiResult">
          <div class="bmi-result-inner">
            <div class="bmi-gauge-wrap">
              <svg class="bmi-gauge" viewBox="0 0 200 110">
                <defs>
                  <linearGradient id="gaugeGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                    <stop offset="0%"   stop-color="#3498db"/>
                    <stop offset="20%"  stop-color="#2ecc71"/>
                    <stop offset="50%"  stop-color="#c8f000"/>
                    <stop offset="75%"  stop-color="#e67e22"/>
                    <stop offset="100%" stop-color="#e74c3c"/>
                  </linearGradient>
                </defs>
                <path d="M20 100 A80 80 0 0 1 180 100" fill="none" stroke="#222" stroke-width="14" stroke-linecap="round"/>
                <path id="gaugeArc" d="M20 100 A80 80 0 0 1 180 100" fill="none" stroke="url(#gaugeGrad)" stroke-width="14" stroke-linecap="round" stroke-dasharray="251" stroke-dashoffset="251"/>
                <circle id="gaugeNeedle" cx="100" cy="100" r="6" fill="#c8f000"/>
              </svg>
              <div class="bmi-val-display">
                <span class="bmi-num" id="bmiNum">--</span>
                <span class="bmi-num-label">IMC</span>
              </div>
            </div>
            <div class="bmi-category" id="bmiCategory">
              <span class="bmi-cat-badge" id="bmiCatBadge">—</span>
              <p class="bmi-cat-desc" id="bmiCatDesc">Entrez vos données pour obtenir votre résultat.</p>
            </div>
            <div class="bmi-scale">
              <div class="bmi-scale-item bmi-thin"><span class="scale-dot"></span><span class="scale-range">&lt; 18.5</span><span class="scale-label">Insuffisant</span></div>
              <div class="bmi-scale-item bmi-normal"><span class="scale-dot"></span><span class="scale-range">18.5 – 24.9</span><span class="scale-label">Normal</span></div>
              <div class="bmi-scale-item bmi-over"><span class="scale-dot"></span><span class="scale-range">25 – 29.9</span><span class="scale-label">Surpoids</span></div>
              <div class="bmi-scale-item bmi-obese"><span class="scale-dot"></span><span class="scale-range">&gt; 30</span><span class="scale-label">Obésité</span></div>
            </div>
            <div class="bmi-cta" id="bmiCta" style="display:none">
              <p class="bmi-cta-text" id="bmiCtaText"></p>
              <a href="register.html" class="btn-gold-lg" style="font-size:.85rem;padding:10px 20px;">Voir mon programme</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ══ PRICING ══ -->
  <section class="section" id="pricing">
    <div class="container">
      <div class="sec-head">
        <p class="sec-eyebrow">Membership</p>
        <h2 class="sec-title">NOS <span>FORMULES</span></h2>
        <p class="sec-sub">Des abonnements flexibles adaptés à tous les objectifs et tous les budgets.</p>
      </div>
      <div class="pricing-grid pricing-2">
        <div class="price-card">
          <div class="price-head">
            <p class="price-plan">BASIC</p>
            <div class="price-amount"><span class="price-cur">TND</span><span class="price-val">79</span><span class="price-per">/mois</span></div>
            <p class="price-desc">Idéal pour débuter et découvrir ADRENA à ton rythme.</p>
          </div>
          <ul class="price-features">
            <li class="yes">Accès salle 6h–23h</li><li class="yes">Zone Cardio complète</li>
            <li class="yes">Vestiaires & douches</li><li class="yes">Application mobile</li>
            <li class="yes">Parking gratuit</li><li class="no">Cours collectifs (Boxe / Yoga)</li>
            <li class="no">Coaching personnalisé</li><li class="no">Accès prioritaire aux créneaux</li>
          </ul>
          <a href="register.html" class="price-btn">Choisir Basic</a>
        </div>
        <div class="price-card price-featured">
          <div class="price-badge">Le plus populaire</div>
          <div class="price-head">
            <p class="price-plan">PRO</p>
            <div class="price-amount"><span class="price-cur">TND</span><span class="price-val">149</span><span class="price-per">/mois</span></div>
            <p class="price-desc">L'expérience complète pour des résultats sérieux et durables.</p>
          </div>
          <ul class="price-features">
            <li class="yes">Accès salle 6h–23h</li><li class="yes">Zone Cardio complète</li>
            <li class="yes">Vestiaires & douches</li><li class="yes">Application mobile</li>
            <li class="yes">Parking gratuit</li><li class="yes">Cours collectifs illimités (Boxe / Yoga)</li>
            <li class="yes">2 séances coaching personnalisé/mois</li><li class="yes">Accès prioritaire aux créneaux</li>
          </ul>
          <a href="register.html" class="price-btn price-btn-gold">Choisir Pro</a>
        </div>
      </div>
      <p class="pricing-note">✦ Sans engagement — résiliation possible à tout moment. Essai gratuit 3 jours disponible.</p>
    </div>
  </section>

  <!-- ══ CONTACT ══ -->
  <section class="section contact-section" id="contact">
    <div class="container">
      <div class="sec-head">
        <p class="sec-eyebrow">On est là</p>
        <h2 class="sec-title">CONTACT &amp; <span>LOCALISATION</span></h2>
        <p class="sec-sub">Viens nous rendre visite ou envoie-nous un message.</p>
      </div>
      <div class="contact-grid">
        <div class="contact-info">
          <div class="info-item"><div class="info-icon">📍</div><div><h4>Adresse</h4><p>Rue du Lac Léman, Les Berges du Lac<br/>Tunis 1053, Tunisie</p></div></div>
          <div class="info-item"><div class="info-icon">🕐</div><div><h4>Horaires</h4><p>Lundi – Vendredi : 06h00 – 23h00<br/>Samedi – Dimanche : 08h00 – 22h00</p></div></div>
          <div class="info-item"><div class="info-icon">📞</div><div><h4>Téléphone</h4><p>+216 71 000 000</p></div></div>
          <div class="info-item"><div class="info-icon">✉️</div><div><h4>Email</h4><p>contact@adrena-gym.tn</p></div></div>
          <form class="contact-form" onsubmit="handleForm(event)">
            <h3 class="form-title">Envoie-nous un message</h3>
            <div class="cf-row">
              <div class="cf-group"><label>Nom</label><input type="text" placeholder="Ton nom" required/></div>
              <div class="cf-group"><label>Email</label><input type="email" placeholder="ton@email.com" required/></div>
            </div>
            <div class="cf-group"><label>Message</label><textarea placeholder="Ton message..." rows="4" required></textarea></div>
            <button type="submit" class="btn-gold-lg cf-submit">Envoyer le message</button>
            <p class="cf-success" id="cfSuccess">✅ Message envoyé ! On te contacte bientôt.</p>
          </form>
        </div>
        <div class="map-wrap">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3193.2!2d10.2272!3d36.8325!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMzbCsDQ5JzU3LjAiTiAxMMKwMTMnMzguMCJF!5e0!3m2!1sfr!2stn!4v1234567890" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="ADRENA"></iframe>
          <div class="map-tag"><span class="logo-dot" style="width:8px;height:8px;flex-shrink:0;"></span>ADRENA — Les Berges du Lac, Tunis</div>
        </div>
      </div>
    </div>
  </section>

  <!-- ══ FOOTER ══ -->
  <footer class="footer">
    <div class="container">
      <div class="footer-grid">
        <div class="footer-brand">
          <div class="nav-logo" style="font-size:1.4rem;margin-bottom:1rem;"><span class="logo-dot" style="width:10px;height:10px;"></span>ADRENA</div>
          <p class="footer-desc">Le gym premium de Tunis. Coachs d'élite, équipements professionnels, résultats garantis.</p>
          <div class="footer-socials"><a href="#" class="fsoc">fb</a><a href="#" class="fsoc">ig</a><a href="#" class="fsoc">yt</a><a href="#" class="fsoc">tk</a></div>
        </div>
        <div class="footer-col">
          <h5>Navigation</h5>
          <a href="#services">Services</a><a href="#trainers">Coachs</a>
          <a href="#gallery">Galerie</a><a href="#bmi">BMI</a>
          <a href="#pricing">Tarifs</a><a href="shop.php">Shop</a><a href="#contact">Contact</a>
        </div>
        <div class="footer-col">
          <h5>Services</h5>
          <a href="#">Cardio</a><a href="#">Boxe & MMA</a>
          <a href="#">Yoga & Stretching</a><a href="#">Coaching Perso</a>
        </div>
        <div class="footer-col">
          <h5>Légal</h5>
          <a href="#">Mentions légales</a><a href="#">Confidentialité</a>
          <a href="#">CGV</a><a href="#">Règlement intérieur</a>
        </div>
      </div>
      <div class="footer-bottom">
        <p>© 2026 ADRENA. Tous droits réservés.</p>
        <p>Fait avec 💪 à Tunis</p>
      </div>
    </div>
  </footer>

  <script src="home.js"></script>
</body>
</html>
