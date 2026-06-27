<script>
/* ═══════════════════ AUTH ═══════════════════ */
function authTab(tab) {
  document.getElementById('form-login').style.display  = tab === 'login'  ? 'block' : 'none';
  document.getElementById('form-signup').style.display = tab === 'signup' ? 'block' : 'none';
  document.getElementById('tab-login').classList.toggle('active',  tab === 'login');
  document.getElementById('tab-signup').classList.toggle('active', tab === 'signup');
}

function doLogin() {
  const email = document.getElementById('login-email')?.value || '';
  const isAdmin = email.includes('admin');
  if (isAdmin) {
    document.getElementById('sidebar-name').textContent = 'Rafiul Ahmed';
    document.getElementById('sidebar-role').textContent = 'Admin';
    document.getElementById('sidebar-avatar').textContent = 'RA';
  } else {
    document.getElementById('sidebar-name').textContent = 'Tasnim Sara';
    document.getElementById('sidebar-role').textContent = 'Student';
    document.getElementById('sidebar-avatar').textContent = 'TS';
  }
  document.getElementById('page-auth').classList.remove('active');
  document.getElementById('page-app').classList.add('active');
}

function doLogout() {
  document.getElementById('page-app').classList.remove('active');
  document.getElementById('page-auth').classList.add('active');
}

/* ═══════════════════ NAVIGATION ═══════════════════ */
const titles = {
  dashboard: 'Dashboard', lost: 'Lost Items', found: 'Found Items',
  matches: 'Smart Matches', report: 'File a Report', claims: 'My Claims',
  notifications: 'Notifications', analytics: 'Analytics',
  admin: 'Verify Claims', profile: 'My Profile'
};

function showPanel(id, el) {
  document.querySelectorAll('.panel').forEach(p => p.classList.remove('active'));
  document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
  const panel = document.getElementById('panel-' + id);
  if (panel) panel.classList.add('active');
  if (el) el.classList.add('active');
  document.getElementById('topbar-title').textContent = titles[id] || id;
}

/* ═══════════════════ FILTER CHIPS ═══════════════════ */
document.querySelectorAll('.chip').forEach(c => {
  c.addEventListener('click', function () {
    this.parentElement.querySelectorAll('.chip').forEach(x => x.classList.remove('active'));
    this.classList.add('active');
  });
});

/* ═══════════════════ REPORT FORM TABS ═══════════════════ */
function switchReportTab(tab) {
  document.getElementById('form-lost').style.display  = tab === 'lost'  ? 'block' : 'none';
  document.getElementById('form-found').style.display = tab === 'found' ? 'block' : 'none';
  document.getElementById('tab-lost-report').classList.toggle('active',  tab === 'lost');
  document.getElementById('tab-found-report').classList.toggle('active', tab === 'found');
}

function submitReport() {
  const toast = document.getElementById('submit-toast');
  toast.classList.add('show');
  setTimeout(() => toast.classList.remove('show'), 4000);
}

/* ═══════════════════ MODALS ═══════════════════ */
function openItemModal(name, type, location, date, category, color, marks, status) {
  document.getElementById('modal-item-title').textContent = name;
  const isFound = type === 'Found';
  document.getElementById('modal-claim-btn').style.display = isFound ? 'inline-flex' : 'none';
  document.getElementById('modal-item-body').innerHTML = `
    <div style="display:flex;align-items:center;gap:12px;margin-bottom:20px">
      <div style="width:50px;height:50px;border-radius:12px;background:${isFound ? 'rgba(34,208,122,0.12)' : 'rgba(240,82,79,0.12)'};display:flex;align-items:center;justify-content:center;font-size:24px">
        ${isFound ? '📦' : '🔍'}
      </div>
      <div>
        <div style="font-family:Syne,sans-serif;font-size:17px;font-weight:700">${name}</div>
        <span class="badge badge-${isFound ? 'found' : 'lost'}" style="margin-top:4px">${type}</span>
      </div>
    </div>
    <div class="detail-row"><div class="detail-key">Category</div><div class="detail-val">${category}</div></div>
    <div class="detail-row"><div class="detail-key">Color</div><div class="detail-val">${color}</div></div>
    <div class="detail-row"><div class="detail-key">Location</div><div class="detail-val">${location}</div></div>
    <div class="detail-row"><div class="detail-key">Date</div><div class="detail-val">${date}</div></div>
    <div class="detail-row"><div class="detail-key">Status</div><div class="detail-val">${status}</div></div>
    <div class="detail-row"><div class="detail-key">Unique Marks</div><div class="detail-val">${marks}</div></div>
  `;
  document.getElementById('modal-item').classList.add('open');
}

function openClaimModal() {
  document.getElementById('modal-claim').classList.add('open');
}

function closeModal(id) {
  document.getElementById(id).classList.remove('open');
}

function submitClaim() {
  closeModal('modal-claim');
  const toast = document.createElement('div');
  toast.className = 'alert-banner green';
  toast.style.cssText = 'position:fixed;bottom:24px;right:24px;z-index:9999;max-width:360px;animation:fadeIn 0.3s ease';
  toast.innerHTML = '<i class="ti ti-circle-check"></i><span><strong>Claim submitted!</strong> Admin will review within 24 hours.</span>';
  document.body.appendChild(toast);
  setTimeout(() => toast.remove(), 4000);
}

function approveClaim(btn, id) {
  const row = btn.closest('tr');
  row.querySelector('td:nth-child(5) .progress-bar').style.background = 'var(--green)';
  btn.closest('td').innerHTML = '<span class="badge badge-approved"><i class="ti ti-check"></i> Approved</span>';
  const toast = document.createElement('div');
  toast.className = 'alert-banner green';
  toast.style.cssText = 'position:fixed;bottom:24px;right:24px;z-index:9999;max-width:380px;animation:fadeIn 0.3s ease';
  toast.innerHTML = `<i class="ti ti-circle-check"></i><span>Claim <strong>${id}</strong> approved. Oracle <code>approve_claim()</code> procedure executed.</span>`;
  document.body.appendChild(toast);
  setTimeout(() => toast.remove(), 4000);
}

function openEditModal(
    id,
    name,
    category,
    color,
    location,
    description
)
{
    document.getElementById('edit-id').value = id;
    document.getElementById('edit-name').value = name;
    document.getElementById('edit-category').value = category;
    document.getElementById('edit-color').value = color;
    document.getElementById('edit-location').value = location;
    document.getElementById('edit-description').value = description;

    document.getElementById('edit-modal')
        .classList.add('open');
}

function closeEditModal()
{
    document.getElementById('edit-modal')
        .classList.remove('open');
}

/* Close modals on overlay click */
document.querySelectorAll('.modal-overlay').forEach(o => {
  o.addEventListener('click', function (e) {
    if (e.target === this) this.classList.remove('open');
  });
});
</script>
</body>
</html>
