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
  else {
      const navEl = document.querySelector(`[onclick*="showPanel('${id}'"]`);
      if (navEl) navEl.classList.add('active');
  }
  document.getElementById('topbar-title').textContent = titles[id] || id;
  localStorage.setItem('activePanel', id);
}

document.addEventListener('DOMContentLoaded', () => {
  const activePanel = localStorage.getItem('activePanel') || 'dashboard';
  const navEl = document.querySelector(`[onclick*="showPanel('${activePanel}'"]`);
  showPanel(activePanel, navEl);
});

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
function openItemModal(id, name, type, location, date, category, color, marks, status, imgPath) {
  document.getElementById('modal-item-title').textContent = name;
  const isFound = type === 'Found';
  const claimBtn = document.getElementById('modal-claim-btn');
  claimBtn.style.display = isFound ? 'inline-flex' : 'none';
  if(isFound) {
      claimBtn.setAttribute('onclick', `openClaimModal(${id}); closeModal('modal-item');`);
  }
  
  let imgHtml = '';
  if (imgPath && imgPath !== 'null' && imgPath !== '') {
      imgHtml = `<div style="text-align:center; margin-bottom:15px;"><img src="${imgPath}" style="max-width:100%; border-radius:12px; max-height:200px; object-fit:cover;"></div>`;
  }
  
  document.getElementById('modal-item-body').innerHTML = imgHtml + `
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

function openClaimModal(foundId) {
  if (foundId) {
      document.getElementById('claim-found-id').value = foundId;
  }
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

<script>
function openChatModal(matchId) {
    document.getElementById("chat-match-id").value = matchId;
    document.getElementById("chat-messages").innerHTML = "<div style='text-align:center;color:var(--txt3)'>Loading messages...</div>";
    document.getElementById("modal-chat").classList.add("open");
    fetchMessages(matchId);
}

function fetchMessages(matchId) {
    const formData = new FormData();
    formData.append("action", "fetch");
    formData.append("match_id", matchId);
    
    fetch("chat_handler.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if(data.status === "success") {
            const container = document.getElementById("chat-messages");
            container.innerHTML = "";
            if(data.messages.length === 0) {
                container.innerHTML = "<div style='text-align:center;color:var(--txt3);padding-top:20px'>No messages yet. Say hello!</div>";
            } else {
                data.messages.forEach(msg => {
                    const cls = msg.IS_MINE ? "chat-msg mine" : "chat-msg theirs";
                    const sender = msg.IS_MINE ? "You" : msg.SENDER_NAME;
                    container.innerHTML += `
                        <div class="${cls}">
                            <div class="chat-sender">${sender}</div>
                            <div>${msg.MESSAGE_TEXT}</div>
                        </div>
                    `;
                });
                container.scrollTop = container.scrollHeight;
            }
        }
    });
}

function sendMessage() {
    const matchId = document.getElementById("chat-match-id").value;
    const input = document.getElementById("chat-input");
    const text = input.value.trim();
    if(text === "") return;
    
    const formData = new FormData();
    formData.append("action", "send");
    formData.append("match_id", matchId);
    formData.append("message", text);
    
    fetch("chat_handler.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if(data.status === "success") {
            input.value = "";
            fetchMessages(matchId);
        }
    });
}
</script>


<script>
function viewImage(imgPath) {
    document.getElementById("preview-img-src").src = imgPath;
    document.getElementById("modal-image-preview").classList.add("open");
}
</script>


<script>
/* ------------------- SEARCH AND FILTER ------------------- */
document.addEventListener("DOMContentLoaded", () => {
  const searchInput = document.getElementById("global-search");
  const filterCat = document.getElementById("filter-category");
  const filterStatus = document.getElementById("filter-status");

  function handleSearch() {
    const query = searchInput.value.toLowerCase();
    const cat = filterCat.value.toLowerCase();
    const stat = filterStatus.value.toLowerCase();

    // Find the currently active panel
    const activePanel = document.querySelector(".panel.active");
    if(!activePanel) return;

    // Filter table rows (Lost, Found, Admin Claims, etc.)
    const rows = activePanel.querySelectorAll("table tbody tr");
    rows.forEach(row => {
      const text = row.textContent.toLowerCase();
      const rowCat = row.getAttribute("data-category") || "";
      const rowStat = row.getAttribute("data-status") || "";
      
      const matchesSearch = text.includes(query);
      const matchesCat = (cat === "" || rowCat === cat);
      const matchesStat = (stat === "" || rowStat === stat);

      if (matchesSearch && matchesCat && matchesStat) {
        row.style.display = "";
      } else {
        row.style.display = "none";
      }
    });

    // Filter matches cards if we are in the matches panel
    const matches = activePanel.querySelectorAll(".match-card");
    matches.forEach(card => {
      const text = card.textContent.toLowerCase();
      const matchesSearch = text.includes(query);
      
      if (matchesSearch) {
        card.style.display = "";
      } else {
        card.style.display = "none";
      }
    });
  }

  if (searchInput) searchInput.addEventListener("input", handleSearch);
  if (filterCat) filterCat.addEventListener("change", handleSearch);
  if (filterStatus) filterStatus.addEventListener("change", handleSearch);

  // Hook into panel switching so we re-apply filters when switching tabs
  const originalShowPanel = window.showPanel;
  window.showPanel = function(id, el) {
    originalShowPanel(id, el);
    handleSearch();
  };
});
</script>

