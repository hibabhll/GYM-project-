// ══════════════════════════════════════════
// ADRENA — HOME.js
// ══════════════════════════════════════════

// ── NAVBAR SCROLL ─────────────────────────
const navbar = document.getElementById('navbar');
window.addEventListener('scroll', () => {
  navbar.classList.toggle('scrolled', window.scrollY > 40);
});

// ── BURGER MENU ───────────────────────────
const burger     = document.getElementById('burger');
const mobileMenu = document.getElementById('mobileMenu');

burger.addEventListener('click', () => {
  mobileMenu.classList.toggle('open');
});

document.querySelectorAll('.mob-link').forEach(link => {
  link.addEventListener('click', () => {
    mobileMenu.classList.remove('open');
  });
});

// ── SCROLL REVEAL ─────────────────────────
const revealEls = document.querySelectorAll(
  '.srv-card, .trainer-card, .price-card, .gal-item, .info-item, .why-text, .sec-head'
);

revealEls.forEach(el => el.classList.add('reveal'));

const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      const siblings = [...entry.target.parentElement.children];
      const idx      = siblings.indexOf(entry.target);
      entry.target.style.transitionDelay = `${idx * 80}ms`;
      entry.target.classList.add('visible');
      observer.unobserve(entry.target);
    }
  });
}, { threshold: 0.12 });

revealEls.forEach(el => observer.observe(el));

// ── ACTIVE NAV LINK ───────────────────────
const sections = document.querySelectorAll('section[id]');
const navLinks  = document.querySelectorAll('.nav-links a');

const sectionObserver = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      navLinks.forEach(a => a.classList.remove('active'));
      const active = document.querySelector(`.nav-links a[href="#${entry.target.id}"]`);
      if (active) active.classList.add('active');
    }
  });
}, { threshold: 0.4 });

sections.forEach(s => sectionObserver.observe(s));

// ── CONTACT FORM ──────────────────────────
function handleForm(e) {
  e.preventDefault();
  const btn     = e.target.querySelector('.cf-submit');
  const success = document.getElementById('cfSuccess');
  btn.textContent  = 'Envoi en cours…';
  btn.style.opacity = '.7';
  setTimeout(() => {
    btn.textContent  = 'Envoyer le message';
    btn.style.opacity = '1';
    success.classList.add('show');
    e.target.reset();
    setTimeout(() => success.classList.remove('show'), 4000);
  }, 1200);
}

// ══════════════════════════════════════════
// BMI CALCULATOR
// ══════════════════════════════════════════

let currentUnit   = 'cm';
let currentGender = 'm';

function setUnit(unit) {
  currentUnit = unit;

  document.getElementById('btnCm').classList.toggle('active', unit === 'cm');
  document.getElementById('btnFt').classList.toggle('active', unit === 'ft');
  document.getElementById('metricFields').style.display   = unit === 'cm' ? 'block' : 'none';
  document.getElementById('imperialFields').style.display = unit === 'ft' ? 'block' : 'none';

  calculateBMI();
}

function setGender(gender) {
  currentGender = gender;
  document.getElementById('btnM').classList.toggle('active', gender === 'm');
  document.getElementById('btnF').classList.toggle('active', gender === 'f');
  calculateBMI();
}

function calculateBMI() {
  let heightM, weightKg;

  if (currentUnit === 'cm') {
    const h = parseFloat(document.getElementById('bmiHeight').value);
    const w = parseFloat(document.getElementById('bmiWeight').value);
    if (!h || !w) return resetBMI();
    heightM  = h / 100;
    weightKg = w;
  } else {
    const hFt = parseFloat(document.getElementById('bmiHeightFt').value);
    const wLb = parseFloat(document.getElementById('bmiWeightLbs').value);
    if (!hFt || !wLb) return resetBMI();
    heightM  = hFt * 0.3048;
    weightKg = wLb * 0.453592;
  }

  if (heightM <= 0 || weightKg <= 0) return resetBMI();

  const bmi = weightKg / (heightM * heightM);
  updateBMIDisplay(bmi);
}

function resetBMI() {
  document.getElementById('bmiNum').textContent      = '--';
  document.getElementById('bmiCatBadge').textContent  = '—';
  document.getElementById('bmiCatBadge').className    = 'bmi-cat-badge';
  document.getElementById('bmiCatDesc').textContent   = 'Entrez vos données pour obtenir votre résultat.';
  document.getElementById('bmiCta').style.display     = 'none';

  // reset gauge
  const arc    = document.getElementById('gaugeArc');
  const needle = document.getElementById('gaugeNeedle');
  if (arc)    arc.style.strokeDashoffset = '251';
  if (needle) { needle.setAttribute('cx', '100'); needle.setAttribute('cy', '100'); }
}

function updateBMIDisplay(bmi) {
  const rounded = Math.round(bmi * 10) / 10;
  document.getElementById('bmiNum').textContent = rounded;

  let badgeClass, badgeText, desc, ctaText;

  if (bmi < 18.5) {
    badgeClass = 'bmi-cat-badge thin';
    badgeText  = 'Insuffisant';
    desc       = 'Ton poids est en dessous de la normale. Un programme de prise de masse pourrait t\'aider.';
    ctaText    = 'Découvre notre programme de prise de masse adapté à ton profil.';
  } else if (bmi < 25) {
    badgeClass = 'bmi-cat-badge normal';
    badgeText  = 'Poids normal';
    desc       = 'Bravo ! Tu es dans la zone idéale. Continue à entretenir ta forme avec nos programmes.';
    ctaText    = 'Maintiens tes résultats avec nos programmes d\'entretien personnalisés.';
  } else if (bmi < 30) {
    badgeClass = 'bmi-cat-badge over';
    badgeText  = 'Surpoids';
    desc       = 'Un programme cardio et nutrition adapté peut t\'aider à retrouver ta zone idéale.';
    ctaText    = 'Nos coachs ont un programme cardio + nutrition fait pour toi.';
  } else {
    badgeClass = 'bmi-cat-badge obese';
    badgeText  = 'Obésité';
    desc       = 'Nos coachs peuvent t\'accompagner avec un programme progressif et sécurisé.';
    ctaText    = 'Commence dès aujourd\'hui avec un coaching personnalisé et progressif.';
  }
  if (currentGender === 'f') {
    desc += " (adapté pour femme)";
  }

  document.getElementById('bmiCatBadge').className   = badgeClass;
  document.getElementById('bmiCatBadge').textContent  = badgeText;

  document.getElementById('bmiCatDesc').textContent   = desc;
  document.getElementById('bmiCtaText').textContent   = ctaText;
  document.getElementById('bmiCta').style.display     = 'flex';

  // ── Gauge animation ──
  const arc    = document.getElementById('gaugeArc');
  const needle = document.getElementById('gaugeNeedle');
  if (!arc || !needle) return;

  // Map BMI 10–40 → 0–1 progress
  const progress  = Math.min(Math.max((bmi - 10) / 30, 0), 1);
  const arcLen    = 251;
  arc.style.strokeDashoffset = arcLen - progress * arcLen;

  // Move needle along the semicircle (180° arc from left to right)
  const angle  = Math.PI + progress * Math.PI; // π to 2π
  const cx     = 100 + 80 * Math.cos(angle);
  const cy     = 100 + 80 * Math.sin(angle);
  needle.setAttribute('cx', cx.toFixed(1));
  needle.setAttribute('cy', cy.toFixed(1));
}

// ── Live recalculate on input change ──
document.addEventListener('DOMContentLoaded', () => {
  ['bmiHeight', 'bmiWeight', 'bmiHeightFt', 'bmiWeightLbs', 'bmiAge'].forEach(id => {
    const el = document.getElementById(id);
    if (el) el.addEventListener('input', calculateBMI);
  });
});