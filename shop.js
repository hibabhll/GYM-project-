// ══════════════════════════
// CART STATE
// ══════════════════════════
let cart = [];

// ── Navbar sticky ──
window.addEventListener('scroll', () => {
  document.getElementById('navbar').classList.toggle('scrolled', window.scrollY > 40);
});

// ── Mobile menu ──
function toggleMenu() {
  document.getElementById('mobileMenu').classList.toggle('open');
}

// ══════════════════════════
// CART FUNCTIONS
// ══════════════════════════
function toggleCart() {
  document.getElementById('cartDrawer').classList.toggle('open');
  document.getElementById('cartOverlay').classList.toggle('open');
}

function addToCart(name, price) {
  const existing = cart.find(i => i.name === name);
  if (existing) {
    existing.qty++;
  } else {
    cart.push({ name, price, qty: 1 });
  }
  renderCart();
  updateCartCount();

  // open cart drawer
  document.getElementById('cartDrawer').classList.add('open');
  document.getElementById('cartOverlay').classList.add('open');
}

function removeFromCart(index) {
  cart.splice(index, 1);
  renderCart();
  updateCartCount();
}

function changeQty(index, delta) {
  cart[index].qty += delta;
  if (cart[index].qty <= 0) {
    cart.splice(index, 1);
  }
  renderCart();
  updateCartCount();
}

function clearCart() {
  cart = [];
  renderCart();
  updateCartCount();
}

function updateCartCount() {
  const total = cart.reduce((s, i) => s + i.qty, 0);
  const badge = document.getElementById('cartCount');
  badge.textContent = total;
  badge.classList.toggle('show', total > 0);
}

function renderCart() {
  const container = document.getElementById('cartItems');
  const footer    = document.getElementById('cartFooter');
  const empty     = document.getElementById('cartEmpty');

  if (cart.length === 0) {
    container.innerHTML = '';
    container.appendChild(empty);
    empty.style.display = 'flex';
    footer.style.display = 'none';
    return;
  }

  empty.style.display = 'none';
  footer.style.display = 'block';

  container.innerHTML = '';

  cart.forEach((item, i) => {
    const div = document.createElement('div');
    div.className = 'cart-item';
    div.innerHTML = `
      <div class="cart-item-info">
        <div class="cart-item-name">${item.name}</div>
        <div class="cart-item-price">${(item.price * item.qty).toFixed(0)} TND</div>
      </div>
      <div class="cart-item-qty">
        <button class="qty-btn" onclick="changeQty(${i}, -1)">−</button>
        <span class="qty-num">${item.qty}</span>
        <button class="qty-btn" onclick="changeQty(${i}, 1)">+</button>
      </div>
      <button class="cart-item-remove" onclick="removeFromCart(${i})" title="Supprimer">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M18 6L6 18M6 6l12 12"/>
        </svg>
      </button>
    `;
    container.appendChild(div);
  });

  const subtotal = cart.reduce((s, i) => s + i.price * i.qty, 0);
  document.getElementById('cartSubtotal').textContent = subtotal.toFixed(0) + ' TND';
  document.getElementById('cartTotal').textContent    = subtotal.toFixed(0) + ' TND';
}

// ══════════════════════════
// CHECKOUT — serialize cart into hidden input before submitting
// ══════════════════════════
document.addEventListener('DOMContentLoaded', () => {
  const checkoutForm = document.querySelector('form[action="checkout.php"]');
  if (checkoutForm) {
    checkoutForm.addEventListener('submit', function (e) {
      if (cart.length === 0) {
        e.preventDefault();
        alert('Your cart is empty!');
        return;
      }
      // Inject cart JSON into a hidden input so PHP can read it
      let hiddenInput = this.querySelector('input[name="cart"]');
      if (!hiddenInput) {
        hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'cart';
        this.appendChild(hiddenInput);
      }
      hiddenInput.value = JSON.stringify(cart);
    });
  }
});

// ══════════════════════════
// FILTER BY CATEGORY
// ══════════════════════════
function filterCat(btn, cat) {
  document.querySelectorAll('.f-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');

  document.querySelectorAll('.product-card').forEach(card => {
    const match = cat === 'all' || card.dataset.cat === cat;
    card.classList.toggle('hidden', !match);
  });
}