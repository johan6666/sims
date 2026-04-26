// Scroll reveal dengan Intersection Observer
const observer = new IntersectionObserver((entries) => {
  entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
}, { threshold: 0.08 });

document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));

// Tweaks panel untuk color customization
const TWEAK_DEFAULTS = {
  primaryColor: '#1B6B3A',
  accentColor: '#C9932A'
};

let tweaks = { ...TWEAK_DEFAULTS };

function applyTweaks() {
  document.documentElement.style.setProperty('--green', tweaks.primaryColor);
  document.documentElement.style.setProperty('--gold', tweaks.accentColor);
}

applyTweaks();

const panel = document.createElement('div');
panel.style.cssText = `position:fixed;bottom:24px;right:24px;z-index:9999;background:white;border:1px solid #e5e7eb;border-radius:14px;padding:20px;width:230px;display:none;flex-direction:column;gap:14px;box-shadow:0 8px 40px rgba(0,0,0,0.15);font-family:'Plus Jakarta Sans',sans-serif;`;
panel.innerHTML = `
  <div style="font-family:'Syne',sans-serif;font-weight:800;font-size:0.95rem;color:#1A2E1F;">Tweaks</div>
  <label style="display:flex;flex-direction:column;gap:6px;font-size:0.8rem;color:#6B7E70;">
    Warna Utama (Hijau)
    <input type="color" id="tw-primary" value="${tweaks.primaryColor}" style="height:36px;border-radius:8px;border:1px solid #e5e7eb;cursor:pointer;width:100%;">
  </label>
  <label style="display:flex;flex-direction:column;gap:6px;font-size:0.8rem;color:#6B7E70;">
    Warna Aksen (Gold)
    <input type="color" id="tw-accent" value="${tweaks.accentColor}" style="height:36px;border-radius:8px;border:1px solid #e5e7eb;cursor:pointer;width:100%;">
  </label>
`;
document.body.appendChild(panel);

panel.querySelector('#tw-primary').addEventListener('input', e => {
  tweaks.primaryColor = e.target.value;
  applyTweaks();
  window.parent.postMessage({ type: '__edit_mode_set_keys', edits: tweaks }, '*');
});
panel.querySelector('#tw-accent').addEventListener('input', e => {
  tweaks.accentColor = e.target.value;
  applyTweaks();
  window.parent.postMessage({ type: '__edit_mode_set_keys', edits: tweaks }, '*');
});

// PostMessage handlers
window.addEventListener('message', e => {
  if (e.data?.type === '__activate_edit_mode') panel.style.display = 'flex';
  if (e.data?.type === '__deactivate_edit_mode') panel.style.display = 'none';
});

window.parent.postMessage({ type: '__edit_mode_available' }, '*');
