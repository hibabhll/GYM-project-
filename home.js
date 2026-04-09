// ══════════════════════════════════════════
// ADRENA — home.js
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
  link.addEventListener('click', () => mobileMenu.classList.remove('open'));
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
      entry.target.style.transitionDelay = `${siblings.indexOf(entry.target) * 80}ms`;
      entry.target.classList.add('visible');
      observer.unobserve(entry.target);
    }
  });
}, { threshold: 0.12 });
revealEls.forEach(el => observer.observe(el));

// ── ACTIVE NAV LINK ───────────────────────
document.querySelectorAll('section[id]').forEach(s => {
  new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        document.querySelectorAll('.nav-links a').forEach(a => a.classList.remove('active'));
        const a = document.querySelector(`.nav-links a[href="#${e.target.id}"]`);
        if (a) a.classList.add('active');
      }
    });
  }, { threshold: 0.4 }).observe(s);
});

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
// RESERVATION COACH
// ══════════════════════════════════════════
function reserver(coachId, coachName) {
  const dateEl    = document.getElementById('date-' + coachId);
  const timeEl    = document.getElementById('time-' + coachId);
  const confirm   = document.getElementById('confirm-' + coachId);
  const date      = dateEl?.value;
  const time      = timeEl?.value;

  if (!date || !time) {
    confirm.textContent = '⚠ Choisis une date et une heure.';
    confirm.className   = 'resa-confirm err';
    setTimeout(() => { confirm.textContent = ''; confirm.className = 'resa-confirm'; }, 3000);
    return;
  }

  const dateObj = new Date(date);
  const dateStr = dateObj.toLocaleDateString('fr-FR', { day: '2-digit', month: 'short' });

  // Optimistic UI
  confirm.textContent = `✓ Réservé le ${dateStr} à ${time}`;
  confirm.className   = 'resa-confirm ok';

  // Send to PHP backend
  fetch('reserver.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `coach_id=${coachId}&coach_name=${encodeURIComponent(coachName)}&date=${date}&time=${encodeURIComponent(time)}`
  })
  .then(r => r.json())
  .then(data => {
    if (data.success) {
      confirm.textContent = `✓ ${data.message || 'Réservation confirmée !'}`;
      confirm.className   = 'resa-confirm ok';
    } else {
      confirm.textContent = `✗ ${data.error || 'Erreur, réessaie.'}`;
      confirm.className   = 'resa-confirm err';
    }
  })
  .catch(() => {
    // No backend or network error — keep optimistic message
    confirm.textContent = `✓ Réservé le ${dateStr} à ${time} !`;
    confirm.className   = 'resa-confirm ok';
  });

  // Reset form after 4s
  setTimeout(() => {
    confirm.textContent = '';
    confirm.className   = 'resa-confirm';
    if (dateEl) dateEl.value = '';
    if (timeEl) timeEl.value = '';
  }, 4000);
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
  const btnM = document.getElementById('btnM');
  const btnF = document.getElementById('btnF');
  if (btnM) btnM.classList.toggle('active', gender === 'm');
  if (btnF) btnF.classList.toggle('active', gender === 'f');
  calculateBMI();
}

function calculateBMI() {
  let heightM, weightKg;

  if (currentUnit === 'cm') {
    const h = parseFloat(document.getElementById('bmiHeight')?.value);
    const w = parseFloat(document.getElementById('bmiWeight')?.value);
    if (!h || !w) return resetBMI();
    heightM  = h / 100;
    weightKg = w;
  } else {
    const hFt = parseFloat(document.getElementById('bmiHeightFt')?.value);
    const wLb = parseFloat(document.getElementById('bmiWeightLbs')?.value);
    if (!hFt || !wLb) return resetBMI();
    heightM  = hFt * 0.3048;
    weightKg = wLb * 0.453592;
  }

  if (heightM <= 0 || weightKg <= 0) return resetBMI();
  updateBMIDisplay(weightKg / (heightM * heightM));
}

function resetBMI() {
  const num    = document.getElementById('bmiNum');
  const badge  = document.getElementById('bmiCatBadge');
  const desc   = document.getElementById('bmiCatDesc');
  const cta    = document.getElementById('bmiCta');
  const arc    = document.getElementById('gaugeArc');
  const needle = document.getElementById('gaugeNeedle');
  if (num)    num.textContent    = '--';
  if (badge)  { badge.textContent = '—'; badge.className = 'bmi-cat-badge'; }
  if (desc)   desc.textContent   = 'Entrez vos données pour obtenir votre résultat.';
  if (cta)    cta.style.display  = 'none';
  if (arc)    arc.style.strokeDashoffset = '251';
  if (needle) { needle.setAttribute('cx','100'); needle.setAttribute('cy','100'); }
}

function updateBMIDisplay(bmi) {
  const rounded = Math.round(bmi * 10) / 10;
  const numEl = document.getElementById('bmiNum');
  if (numEl) numEl.textContent = rounded;

  const isFemale = currentGender === 'f';
  let badgeClass, badgeText, desc, ctaText;

  if (bmi < 18.5) {
    badgeClass = 'thin';  badgeText = 'Insuffisant';
    desc = isFemale
      ? 'Ton poids est en dessous de la normale. Un programme de renforcement musculaire doux est recommandé.'
      : 'Ton poids est en dessous de la normale. Un programme de prise de masse pourrait t\'aider.';
    ctaText = 'Découvre notre programme de prise de masse adapté à ton profil.';
  } else if (bmi < (isFemale ? 24 : 25)) {
    badgeClass = 'normal'; badgeText = 'Poids normal';
    desc = 'Bravo ! Tu es dans la zone idéale. Continue à entretenir ta forme avec nos programmes.';
    ctaText = isFemale
      ? 'Maintiens tes résultats avec nos cours yoga & coaching.'
      : 'Maintiens tes résultats avec nos programmes d\'entretien personnalisés.';
  } else if (bmi < (isFemale ? 29 : 30)) {
    badgeClass = 'over';   badgeText = 'Surpoids';
    desc = 'Un programme cardio et nutrition adapté peut t\'aider à retrouver ta zone idéale.';
    ctaText = isFemale
      ? 'Nos coachs ont un programme cardio + yoga + nutrition fait pour toi.'
      : 'Nos coachs ont un programme cardio + nutrition fait pour toi.';
  } else {
    badgeClass = 'obese';  badgeText = 'Obésité';
    desc = 'Nos coachs peuvent t\'accompagner avec un programme progressif et sécurisé.';
    ctaText = 'Commence dès aujourd\'hui avec un coaching personnalisé et progressif.';
  }

  const badge = document.getElementById('bmiCatBadge');
  const descEl = document.getElementById('bmiCatDesc');
  const ctaEl  = document.getElementById('bmiCtaText');
  const cta    = document.getElementById('bmiCta');
  if (badge)  { badge.className = 'bmi-cat-badge ' + badgeClass; badge.textContent = badgeText; }
  if (descEl) descEl.textContent = desc;
  if (ctaEl)  ctaEl.textContent  = ctaText;
  if (cta)    cta.style.display  = 'flex';

  // Gauge animation
  const arc    = document.getElementById('gaugeArc');
  const needle = document.getElementById('gaugeNeedle');
  if (!arc || !needle) return;
  const progress = Math.min(Math.max((bmi - 10) / 30, 0), 1);
  arc.style.strokeDashoffset = 251 - progress * 251;
  const angle = Math.PI + progress * Math.PI;
  needle.setAttribute('cx', (100 + 80 * Math.cos(angle)).toFixed(1));
  needle.setAttribute('cy', (100 + 80 * Math.sin(angle)).toFixed(1));
}

// Live recalculate
document.addEventListener('DOMContentLoaded', () => {
  ['bmiHeight', 'bmiWeight', 'bmiHeightFt', 'bmiWeightLbs', 'bmiAge'].forEach(id => {
    const el = document.getElementById(id);
    if (el) el.addEventListener('input', calculateBMI);
  });

  // Set min date for reservations to today
  const today = new Date().toISOString().split('T')[0];
  document.querySelectorAll('.resa-input[type="date"]').forEach(d => {
    d.setAttribute('min', today);
  });
});// ══════════════════════════════════════════
// ADRENA — home.js
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
  link.addEventListener('click', () => mobileMenu.classList.remove('open'));
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
      entry.target.style.transitionDelay = `${siblings.indexOf(entry.target) * 80}ms`;
      entry.target.classList.add('visible');
      observer.unobserve(entry.target);
    }
  });
}, { threshold: 0.12 });
revealEls.forEach(el => observer.observe(el));

// ── ACTIVE NAV LINK ───────────────────────
document.querySelectorAll('section[id]').forEach(s => {
  new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        document.querySelectorAll('.nav-links a').forEach(a => a.classList.remove('active'));
        const a = document.querySelector(`.nav-links a[href="#${e.target.id}"]`);
        if (a) a.classList.add('active');
      }
    });
  }, { threshold: 0.4 }).observe(s);
});

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
// RESERVATION COACH
// ══════════════════════════════════════════
function reserver(coachId, coachName) {
  const dateEl    = document.getElementById('date-' + coachId);
  const timeEl    = document.getElementById('time-' + coachId);
  const confirm   = document.getElementById('confirm-' + coachId);
  const date      = dateEl?.value;
  const time      = timeEl?.value;

  if (!date || !time) {
    confirm.textContent = '⚠ Choisis une date et une heure.';
    confirm.className   = 'resa-confirm err';
    setTimeout(() => { confirm.textContent = ''; confirm.className = 'resa-confirm'; }, 3000);
    return;
  }

  const dateObj = new Date(date);
  const dateStr = dateObj.toLocaleDateString('fr-FR', { day: '2-digit', month: 'short' });

  // Optimistic UI
  confirm.textContent = `✓ Réservé le ${dateStr} à ${time}`;
  confirm.className   = 'resa-confirm ok';

  // Send to PHP backend
  fetch('reserver.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `coach_id=${coachId}&coach_name=${encodeURIComponent(coachName)}&date=${date}&time=${encodeURIComponent(time)}`
  })
  .then(r => r.json())
  .then(data => {
    if (data.success) {
      confirm.textContent = `✓ ${data.message || 'Réservation confirmée !'}`;
      confirm.className   = 'resa-confirm ok';
    } else {
      confirm.textContent = `✗ ${data.error || 'Erreur, réessaie.'}`;
      confirm.className   = 'resa-confirm err';
    }
  })
  .catch(() => {
    // No backend or network error — keep optimistic message
    confirm.textContent = `✓ Réservé le ${dateStr} à ${time} !`;
    confirm.className   = 'resa-confirm ok';
  });

  // Reset form after 4s
  setTimeout(() => {
    confirm.textContent = '';
    confirm.className   = 'resa-confirm';
    if (dateEl) dateEl.value = '';
    if (timeEl) timeEl.value = '';
  }, 4000);
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
  const btnM = document.getElementById('btnM');
  const btnF = document.getElementById('btnF');
  if (btnM) btnM.classList.toggle('active', gender === 'm');
  if (btnF) btnF.classList.toggle('active', gender === 'f');
  calculateBMI();
}

function calculateBMI() {
  let heightM, weightKg;

  if (currentUnit === 'cm') {
    const h = parseFloat(document.getElementById('bmiHeight')?.value);
    const w = parseFloat(document.getElementById('bmiWeight')?.value);
    if (!h || !w) return resetBMI();
    heightM  = h / 100;
    weightKg = w;
  } else {
    const hFt = parseFloat(document.getElementById('bmiHeightFt')?.value);
    const wLb = parseFloat(document.getElementById('bmiWeightLbs')?.value);
    if (!hFt || !wLb) return resetBMI();
    heightM  = hFt * 0.3048;
    weightKg = wLb * 0.453592;
  }

  if (heightM <= 0 || weightKg <= 0) return resetBMI();
  updateBMIDisplay(weightKg / (heightM * heightM));
}

function resetBMI() {
  const num    = document.getElementById('bmiNum');
  const badge  = document.getElementById('bmiCatBadge');
  const desc   = document.getElementById('bmiCatDesc');
  const cta    = document.getElementById('bmiCta');
  const arc    = document.getElementById('gaugeArc');
  const needle = document.getElementById('gaugeNeedle');
  if (num)    num.textContent    = '--';
  if (badge)  { badge.textContent = '—'; badge.className = 'bmi-cat-badge'; }
  if (desc)   desc.textContent   = 'Entrez vos données pour obtenir votre résultat.';
  if (cta)    cta.style.display  = 'none';
  if (arc)    arc.style.strokeDashoffset = '251';
  if (needle) { needle.setAttribute('cx','100'); needle.setAttribute('cy','100'); }
}

function updateBMIDisplay(bmi) {
  const rounded = Math.round(bmi * 10) / 10;
  const numEl = document.getElementById('bmiNum');
  if (numEl) numEl.textContent = rounded;

  const isFemale = currentGender === 'f';
  let badgeClass, badgeText, desc, ctaText;

  if (bmi < 18.5) {
    badgeClass = 'thin';  badgeText = 'Insuffisant';
    desc = isFemale
      ? 'Ton poids est en dessous de la normale. Un programme de renforcement musculaire doux est recommandé.'
      : 'Ton poids est en dessous de la normale. Un programme de prise de masse pourrait t\'aider.';
    ctaText = 'Découvre notre programme de prise de masse adapté à ton profil.';
  } else if (bmi < (isFemale ? 24 : 25)) {
    badgeClass = 'normal'; badgeText = 'Poids normal';
    desc = 'Bravo ! Tu es dans la zone idéale. Continue à entretenir ta forme avec nos programmes.';
    ctaText = isFemale
      ? 'Maintiens tes résultats avec nos cours yoga & coaching.'
      : 'Maintiens tes résultats avec nos programmes d\'entretien personnalisés.';
  } else if (bmi < (isFemale ? 29 : 30)) {
    badgeClass = 'over';   badgeText = 'Surpoids';
    desc = 'Un programme cardio et nutrition adapté peut t\'aider à retrouver ta zone idéale.';
    ctaText = isFemale
      ? 'Nos coachs ont un programme cardio + yoga + nutrition fait pour toi.'
      : 'Nos coachs ont un programme cardio + nutrition fait pour toi.';
  } else {
    badgeClass = 'obese';  badgeText = 'Obésité';
    desc = 'Nos coachs peuvent t\'accompagner avec un programme progressif et sécurisé.';
    ctaText = 'Commence dès aujourd\'hui avec un coaching personnalisé et progressif.';
  }

  const badge = document.getElementById('bmiCatBadge');
  const descEl = document.getElementById('bmiCatDesc');
  const ctaEl  = document.getElementById('bmiCtaText');
  const cta    = document.getElementById('bmiCta');
  if (badge)  { badge.className = 'bmi-cat-badge ' + badgeClass; badge.textContent = badgeText; }
  if (descEl) descEl.textContent = desc;
  if (ctaEl)  ctaEl.textContent  = ctaText;
  if (cta)    cta.style.display  = 'flex';

  // Gauge animation
  const arc    = document.getElementById('gaugeArc');
  const needle = document.getElementById('gaugeNeedle');
  if (!arc || !needle) return;
  const progress = Math.min(Math.max((bmi - 10) / 30, 0), 1);
  arc.style.strokeDashoffset = 251 - progress * 251;
  const angle = Math.PI + progress * Math.PI;
  needle.setAttribute('cx', (100 + 80 * Math.cos(angle)).toFixed(1));
  needle.setAttribute('cy', (100 + 80 * Math.sin(angle)).toFixed(1));
}

// Live recalculate
document.addEventListener('DOMContentLoaded', () => {
  ['bmiHeight', 'bmiWeight', 'bmiHeightFt', 'bmiWeightLbs', 'bmiAge'].forEach(id => {
    const el = document.getElementById(id);
    if (el) el.addEventListener('input', calculateBMI);
  });

  // Set min date for reservations to today
  const today = new Date().toISOString().split('T')[0];
  document.querySelectorAll('.resa-input[type="date"]').forEach(d => {
    d.setAttribute('min', today);
  });
});
