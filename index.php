<?php
session_start();
include 'includes/_head.php';
?>

<!-- ══════════════════════════════════════════════════
     AUTH PAGE
══════════════════════════════════════════════════ -->
<div id="page-auth" class="page <?= isset($_SESSION['user_id']) ? '' : 'active' ?>">
  <div class="auth-bg">
    <div class="auth-bg-circle c1"></div>
    <div class="auth-bg-circle c2"></div>
    <div class="auth-bg-circle c3"></div>
  </div>

  <div class="auth-logo">
    <div class="auth-logo-icon"><i class="ti ti-map-pin-search"></i></div>
    <div>
      <div class="auth-logo-text">LostLink</div>
      <div style="font-size:11px;color:var(--txt2);letter-spacing:1.5px;text-transform:uppercase">
        KUET Campus
      </div>
    </div>
  </div>

  <div class="auth-card">

    <div class="auth-tabs">
      <div class="auth-tab active" id="tab-login" onclick="authTab('login')">
        Sign In
      </div>

      <div class="auth-tab" id="tab-signup" onclick="authTab('signup')">
        Register
      </div>
    </div>

    <?php if(isset($_GET['register']) && $_GET['register']=='success'): ?>
      <div style="padding:12px;margin-bottom:10px;background:#d4edda;color:#155724;border-radius:8px;">
        Registration successful. Please sign in.
      </div>
    <?php endif; ?>

    <?php if(isset($_GET['login']) && $_GET['login']=='failed'): ?>
      <div style="padding:12px;margin-bottom:10px;background:#f8d7da;color:#721c24;border-radius:8px;">
        Invalid email or password.
      </div>
    <?php endif; ?>

    <!-- LOGIN FORM -->
    <div id="form-login">

      <form method="POST" action="login_process.php">

        <div class="auth-title">Welcome back</div>
        <div class="auth-sub">Sign in to your LostLink account</div>

        <div class="form-row">
          <label class="form-label">Email Address</label>
          <div class="input-icon-wrap">
            <i class="ti ti-mail i-icon"></i>
            <input
              type="email"
              class="form-input"
              name="email"
              placeholder="you@kuet.ac.bd"
              required>
          </div>
        </div>

        <div class="form-row">
          <label class="form-label">Password</label>
          <div class="input-icon-wrap">
            <i class="ti ti-lock i-icon"></i>
            <input
              type="password"
              class="form-input"
              name="password"
              placeholder="••••••••"
              required>
          </div>
        </div>

        <button type="submit" class="btn-auth">
          <i class="ti ti-login" style="font-size:16px;margin-right:4px"></i>
          Sign In
        </button>

      </form>

    </div>

    <!-- REGISTER FORM -->
    <div id="form-signup" style="display:none">

      <form method="POST" action="register_process.php">

        <div class="auth-title">Create account</div>
        <div class="auth-sub">Join the KUET LostLink network</div>

        <div class="form-row">
          <label class="form-label">Full Name</label>
          <div class="input-icon-wrap">
            <i class="ti ti-user i-icon"></i>
            <input
              type="text"
              class="form-input"
              name="fullname"
              required>
          </div>
        </div>

        <div class="form-row">
          <label class="form-label">Student / Employee ID</label>
          <div class="input-icon-wrap">
            <i class="ti ti-id-badge i-icon"></i>
            <input
              type="text"
              class="form-input"
              name="studentid"
              required>
          </div>
        </div>

        <div class="form-row">
          <label class="form-label">Email Address</label>
          <div class="input-icon-wrap">
            <i class="ti ti-mail i-icon"></i>
            <input
              type="email"
              class="form-input"
              name="email"
              required>
          </div>
        </div>

        <div class="form-row">
          <label class="form-label">Password</label>
          <div class="input-icon-wrap">
            <i class="ti ti-lock i-icon"></i>
            <input
              type="password"
              class="form-input"
              name="password"
              required>
          </div>
        </div>

        <button type="submit" class="btn-auth">
          <i class="ti ti-user-plus" style="font-size:16px;margin-right:4px"></i>
          Create Account
        </button>

      </form>

    </div>

  </div>
</div>

<!-- ══════════════════════════════════════════════════
     APP PAGE
══════════════════════════════════════════════════ -->
<div id="page-app" class="page <?= isset($_SESSION['user_id']) ? 'active' : '' ?>">

  <?php include 'includes/_sidebar.php'; ?>

  <div class="main">

    <div class="topbar">

      <div class="topbar-title" id="topbar-title">
        Dashboard
      </div>

      <div class="search-box" style="display:flex; gap:10px; align-items:center; background:transparent; border:none; padding:0; max-width:600px;">
        <div style="position:relative; flex:1; display:flex; align-items:center; background:var(--bg2); border:1px solid var(--border); border-radius:8px; padding:0 12px; height:38px;">
          <i class="ti ti-search" style="color:var(--txt3); margin-right:8px;"></i>
          <input type="text" id="global-search" placeholder="Search items, locations, IDs…" style="border:none; background:transparent; outline:none; color:var(--txt1); width:100%;">
        </div>
        
        <select id="filter-category" class="form-input-app" style="height:38px; padding:0 12px; width:auto; min-width:120px;">
          <option value="">All Categories</option>
          <option value="electronics">Electronics</option>
          <option value="documents">Documents</option>
          <option value="keys">Keys</option>
          <option value="clothing">Clothing</option>
          <option value="bags">Bags</option>
          <option value="accessories">Accessories</option>
          <option value="other">Other</option>
        </select>

        <select id="filter-status" class="form-input-app" style="height:38px; padding:0 12px; width:auto; min-width:110px;">
          <option value="">All Statuses</option>
          <option value="active">Active</option>
          <option value="unclaimed">Unclaimed</option>
          <option value="matched">Matched</option>
          <option value="claimed">Claimed</option>
          <option value="recovered">Recovered</option>
          <option value="returned">Returned</option>
        </select>
      </div>

      <div class="topbar-notif"
           onclick="showPanel('notifications', document.querySelector('.nav-item:nth-child(12)'))">
        <i class="ti ti-bell"></i>
        <div class="notif-dot"></div>
      </div>

      <?php if(isset($_SESSION['name'])): ?>
        <span style="margin-right:15px;font-weight:600;">
          <?= htmlspecialchars($_SESSION['name']) ?>
        </span>
      <?php endif; ?>

      <a href="logout.php" class="btn btn-secondary" style="margin-right:10px;">
        Logout
      </a>

      <button class="btn btn-primary"
              onclick="showPanel('report', document.querySelector('.nav-item:nth-child(9)'))">
        <i class="ti ti-plus"></i> Report Item
      </button>

    </div>

    <div class="content">
      <?php include 'panels/dashboard.php'; ?>
      <?php include 'panels/lost.php'; ?>
      <?php include 'panels/found.php'; ?>
      <?php include 'panels/matches.php'; ?>
      <?php include 'panels/report.php'; ?>
      <?php include 'panels/other_panels.php'; ?>
    </div>

  </div>

</div>

<?php include 'includes/_modals.php'; ?>
<?php include 'includes/_scripts.php'; ?>