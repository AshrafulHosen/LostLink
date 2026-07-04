<aside class="sidebar">
  <div class="sidebar-logo">
    <div class="logo-wrap">
      <div class="logo-icon"><i class="ti ti-map-pin-search"></i></div>
      <div>
        <div class="logo-txt">LostLink</div>
        <div class="logo-campus">KUET Campus</div>
      </div>
    </div>
  </div>

  <nav class="nav">
    <div class="nav-section">Overview</div>
    <div class="nav-item active" onclick="showPanel('dashboard',this)">
      <i class="ti ti-layout-dashboard"></i> Dashboard
    </div>
    <div class="nav-section">Items</div>
    <div class="nav-item" onclick="showPanel('lost',this)">
      <i class="ti ti-alert-triangle"></i> Lost Items
      <span class="nav-badge red">12</span>
    </div>
    <div class="nav-item" onclick="showPanel('found',this)">
      <i class="ti ti-package"></i> Found Items
      <span class="nav-badge">8</span>
    </div>
    <div class="nav-item" onclick="showPanel('matches',this)">
      <i class="ti ti-link"></i> Smart Matches
      <span class="nav-badge" style="background:var(--gold)">5</span>
    </div>
    <div class="nav-section">Actions</div>
    <div class="nav-item" onclick="showPanel('report',this)">
      <i class="ti ti-circle-plus"></i> File a Report
    </div>
    <div class="nav-item" onclick="showPanel('claims',this)">
      <i class="ti ti-clipboard-check"></i> My Claims
    </div>
    <div class="nav-item" onclick="showPanel('notifications',this)">
      <i class="ti ti-bell"></i> Notifications
      <span class="nav-badge blue">3</span>
    </div>
    <div class="nav-section">Admin</div>
    <div class="nav-item" onclick="showPanel('analytics',this)">
      <i class="ti ti-chart-pie-2"></i> Analytics
    </div>
    <div class="nav-item" onclick="showPanel('admin',this)">
      <i class="ti ti-shield-check"></i> Verify Claims
      <span class="nav-badge red">2</span>
    </div>
    <div class="nav-item" onclick="showPanel('profile',this)">
      <i class="ti ti-user-circle"></i> My Profile
    </div>
  </nav>

</aside>
