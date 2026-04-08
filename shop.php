<?php
session_start();
include 'db.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>ADRENA — Shop</title>
  <link href="https://fonts.googleapis.com/css2?family=Anton&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="shop.css"/>
</head>
<body>

  <!-- ══ NAVBAR ══ -->
  <nav class="navbar" id="navbar">
    <div class="nav-inner">
      <a href="home.php" class="nav-logo">
        <span class="logo-dot"></span>ADRENA
      </a>
      <ul class="nav-links">
        <li><a href="home.php">Accueil</a></li>
        <li><a href="home.php#services">Services</a></li>
        <li><a href="home.php#trainers">Coachs</a></li>
        <li><a href="shop.html" class="active">Shop</a></li>
        <li><a href="home.php#contact">Contact</a></li>
      </ul>
      <div class="nav-actions">
        <button class="cart-icon-btn" id="cartBtn" onclick="toggleCart()">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
            <line x1="3" y1="6" x2="21" y2="6"/>
            <path d="M16 10a4 4 0 01-8 0"/>
          </svg>
          <span class="cart-count" id="cartCount">0</span>
        </button>
        <a href="register.html" class="btn-gold">Rejoindre</a>
      </div>
      <button class="burger" id="burger" onclick="toggleMenu()">
        <span></span><span></span><span></span>
      </button>
    </div>
    <div class="mobile-menu" id="mobileMenu">
      <a href="home.php" class="mob-link">Accueil</a>
      <a href="home.php#services" class="mob-link">Services</a>
      <a href="home.php#trainers" class="mob-link">Coachs</a>
      <a href="shop.html" class="mob-link gold">Shop</a>
      <a href="home.php#contact" class="mob-link">Contact</a>
    </div>
  </nav>

  <!-- ══ SHOP HEADER ══ -->
  <section class="shop-header">
    <div class="container">
      <p class="sec-eyebrow">✦ Nutrition · Vêtements · Équipement</p>
      <h1 class="shop-title">NOTRE <span>SHOP</span></h1>
      <p class="shop-sub">Tout ce qu'il te faut pour performer — en salle ou à la maison.</p>
    </div>
  </section>

  <!-- ══ FILTER BAR ══ -->
  <div class="filter-bar container">
    <button class="f-btn active" onclick="filterCat(this,'all')">Tout <span>5</span></button>
    <button class="f-btn" onclick="filterCat(this,'protein')">Protéines <span>1</span></button>
    <button class="f-btn" onclick="filterCat(this,'vetement')">Vêtements <span>2</span></button>
    <button class="f-btn" onclick="filterCat(this,'home')">Home Training <span>2</span></button>
  </div>

  <!-- ══ PRODUCTS GRID ══ -->
  <section class="shop-section">
    <div class="products-grid container" id="productsGrid">

      <!-- PRODUCT 1 — Whey Protein -->
      <div class="product-card" data-cat="protein" data-price="89">
        <div class="product-img">
          <img src="whey.jpg" alt="Whey Protein Gold" onerror="this.parentElement.classList.add('no-img')"/>
          <span class="product-badge">Protéine</span>
        </div>
        <div class="product-info">
          <h3 class="product-name">Whey Protein Gold</h3>
          <p class="product-desc">2kg · Chocolat / Vanille / Fraise</p>
          <div class="product-footer">
            <span class="product-price">89 <small>TND</small></span>
            <button class="btn-add" onclick="addToCart('Whey Protein Gold', 89)">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
              Ajouter
            </button>
          </div>
        </div>
      </div>

      <!-- PRODUCT 2 — T-Shirt -->
      <div class="product-card" data-cat="vetement" data-price="45">
        <div class="product-img">
          <img src="t-shirt1.JPG" alt="T-Shirt Training ADRENA" onerror="this.parentElement.classList.add('no-img')"/>
          <span class="product-badge">Vêtement</span>
        </div>
        <div class="product-info">
          <h3 class="product-name">T-Shirt Training ADRENA</h3>
          <p class="product-desc">Dry-fit · S / M / L / XL</p>
          <div class="product-footer">
            <span class="product-price">45 <small>TND</small></span>
            <button class="btn-add" onclick="addToCart('T-Shirt Training ADRENA', 45)">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
              Ajouter
            </button>
          </div>
        </div>
      </div>

      <!-- PRODUCT 3 — Short -->
      <div class="product-card" data-cat="vetement" data-price="55">
        <div class="product-img">
          <img src="short.jpg" alt="Short Performance" onerror="this.parentElement.classList.add('no-img')"/>
          <span class="product-badge">Vêtement</span>
        </div>
        <div class="product-info">
          <h3 class="product-name">Short Performance</h3>
          <p class="product-desc">Élasthanne · S / M / L / XL</p>
          <div class="product-footer">
            <span class="product-price">55 <small>TND</small></span>
            <button class="btn-add" onclick="addToCart('Short Performance', 55)">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
              Ajouter
            </button>
          </div>
        </div>
      </div>

      <!-- PRODUCT 4 — Resistance Bands -->
      <div class="product-card" data-cat="home" data-price="39">
        <div class="product-img">
          <img src="bands.jpg" alt="Resistance Bands Set" onerror="this.parentElement.classList.add('no-img')"/>
          <span class="product-badge">Home Training</span>
        </div>
        <div class="product-info">
          <h3 class="product-name">Resistance Bands Set</h3>
          <p class="product-desc">5 niveaux · Sac inclus</p>
          <div class="product-footer">
            <span class="product-price">39 <small>TND</small></span>
            <button class="btn-add" onclick="addToCart('Resistance Bands Set', 39)">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
              Ajouter
            </button>
          </div>
        </div>
      </div>

      <!-- PRODUCT 5 — Kettlebell -->
      <div class="product-card" data-cat="home" data-price="120">
        <div class="product-img">
          <img src="kettlebell.jpg" alt="Kettlebell 16kg" onerror="this.parentElement.classList.add('no-img')"/>
          <span class="product-badge">Home Training</span>
        </div>
        <div class="product-info">
          <h3 class="product-name">Kettlebell 16kg</h3>
          <p class="product-desc">Fonte · Revêtement caoutchouc</p>
          <div class="product-footer">
            <span class="product-price">120 <small>TND</small></span>
            <button class="btn-add" onclick="addToCart('Kettlebell 16kg', 120)">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
              Ajouter
            </button>
          </div>
        </div>
      </div>

    </div>
  </section>

  <!-- ══ CART DRAWER ══ -->
  <div class="cart-overlay" id="cartOverlay" onclick="toggleCart()"></div>
  <div class="cart-drawer" id="cartDrawer">
    <div class="cart-head">
      <h3>
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
          <line x1="3" y1="6" x2="21" y2="6"/>
          <path d="M16 10a4 4 0 01-8 0"/>
        </svg>
        Mon Panier
      </h3>
      <button class="cart-close" onclick="toggleCart()">✕</button>
    </div>

    <div class="cart-items" id="cartItems">
      <div class="cart-empty" id="cartEmpty">
        <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="#333" stroke-width="1.5">
          <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
          <line x1="3" y1="6" x2="21" y2="6"/>
          <path d="M16 10a4 4 0 01-8 0"/>
        </svg>
        <p>Panier vide</p>
        <button class="btn-gold-sm" onclick="toggleCart()">Continuer les achats</button>
      </div>
    </div>

    <div class="cart-footer" id="cartFooter" style="display:none">
      <div class="cart-row"><span>Sous-total</span><span id="cartSubtotal">0 TND</span></div>
      <div class="cart-row"><span>Livraison</span><span style="color:var(--gold)">Gratuite</span></div>
      <div class="cart-total"><span>Total</span><span id="cartTotal">0 TND</span></div>
      <form action="checkout.php" method="POST" id="checkoutForm">
      <button type="submit" class="btn-checkout">
        Commander
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
      </button>
      </form>
      <button class="btn-clear" onclick="clearCart()">Vider le panier</button>
    </div>
  </div>

  <!-- ══ FOOTER ══ -->
  <footer class="footer">
    <div class="container footer-inner">
      <div class="nav-logo"><span class="logo-dot"></span>ADRENA</div>
      <p>© 2026 ADRENA — Tunisie. Tous droits réservés.</p>
      <a href="home.php">← Retour à l'accueil</a>
    </div>
  </footer>

  <script src="shop.js"></script>
</body>
</html>