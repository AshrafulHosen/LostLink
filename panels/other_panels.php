<!-- ══ MY CLAIMS ══ -->
<div class="panel" id="panel-claims">
  <div class="section-head">
    <div class="section-title">My Claims</div>
  </div>
  <div class="table-wrap">
    <table>
      <thead><tr><th>Claim #</th><th>Item Claimed</th><th>Proof Submitted</th><th>Submitted</th><th>Status</th><th>Action</th></tr></thead>
      <tbody>
        <tr>
          <td style="color:var(--txt3);font-size:12px">C-003</td>
          <td><div class="td-main">Samsung Galaxy S23</div><div class="td-sub">Found at Cafeteria · F-001</div></td>
          <td><span class="tag">Description</span><span class="tag">Unique mark</span></td>
          <td>Jun 07</td>
          <td><span class="badge badge-pending">Pending</span></td>
          <td><button class="btn btn-sm">Details</button></td>
        </tr>
        <tr>
          <td style="color:var(--txt3);font-size:12px">C-002</td>
          <td><div class="td-main">Black Rimmed Glasses</div><div class="td-sub">Found at Canteen · F-005</div></td>
          <td><span class="tag">Description</span></td>
          <td>Jun 04</td>
          <td><span class="badge badge-approved">Approved</span></td>
          <td><button class="btn btn-sm">Details</button></td>
        </tr>
        <tr>
          <td style="color:var(--txt3);font-size:12px">C-001</td>
          <td><div class="td-main">Student ID Card</div><div class="td-sub">Found at Admin Building · F-003</div></td>
          <td><span class="tag">ID Proof</span></td>
          <td>Jun 07</td>
          <td><span class="badge badge-approved">Approved</span></td>
          <td><button class="btn btn-sm">Details</button></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<!-- ══ NOTIFICATIONS ══ -->
<div class="panel" id="panel-notifications">
  <div class="section-head">
    <div class="section-title">All Notifications</div>
    <button class="btn btn-sm">Mark all read</button>
  </div>
  <div class="card">
    <div class="notif-list">
      <div class="notif-item">
        <div class="notif-icon match"><i class="ti ti-sparkles"></i></div>
        <div style="flex:1">
          <div class="notif-text">A <strong>87% match</strong> was found for your lost item: <strong>Samsung Galaxy S23</strong>. A similar phone was found at the Cafeteria.</div>
          <div class="notif-time">2 hours ago · <span style="color:var(--cyan)">View match →</span></div>
        </div>
        <div class="notif-unread"></div>
      </div>
      <div class="notif-item">
        <div class="notif-icon claim"><i class="ti ti-circle-check"></i></div>
        <div style="flex:1">
          <div class="notif-text">Your claim <strong>#C-002</strong> for <strong>Black Rimmed Glasses</strong> has been <strong style="color:var(--green)">APPROVED</strong>. Please collect your item from the Admin Office.</div>
          <div class="notif-time">Yesterday at 3:45 PM</div>
        </div>
        <div class="notif-unread"></div>
      </div>
      <div class="notif-item">
        <div class="notif-icon info"><i class="ti ti-info-circle"></i></div>
        <div style="flex:1">
          <div class="notif-text">A <strong>Student ID Card</strong> matching your lost report description was turned in at the Admin Building.</div>
          <div class="notif-time">Jun 06 at 10:12 AM</div>
        </div>
        <div class="notif-unread"></div>
      </div>
      <div class="notif-item" style="opacity:0.6">
        <div class="notif-icon info"><i class="ti ti-bell"></i></div>
        <div style="flex:1">
          <div class="notif-text">Your lost item report <strong>L-005 (BIC Pen Case)</strong> is now active. You'll be notified when a match is found.</div>
          <div class="notif-time">Jun 06 at 8:00 AM</div>
        </div>
      </div>
      <div class="notif-item" style="opacity:0.6">
        <div class="notif-icon claim"><i class="ti ti-circle-check"></i></div>
        <div style="flex:1">
          <div class="notif-text">Your claim <strong>#C-001</strong> for <strong>Student ID Card</strong> has been <strong style="color:var(--green)">APPROVED</strong>.</div>
          <div class="notif-time">Jun 05 at 2:00 PM</div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ══ ANALYTICS ══ -->
<div class="panel" id="panel-analytics">
  <div class="stats-grid">
    <div class="stat-card cyan">
      <div class="stat-icon cyan"><i class="ti ti-percentage"></i></div>
      <div class="stat-num">40%</div>
      <div class="stat-label">Recovery Rate</div>
      <div class="stat-delta" style="color:var(--cyan)">19 of 47 items</div>
    </div>
    <div class="stat-card purple">
      <div class="stat-icon purple"><i class="ti ti-clock"></i></div>
      <div class="stat-num">3.2d</div>
      <div class="stat-label">Avg Resolution Time</div>
      <div class="stat-delta" style="color:var(--purple)">Days to match</div>
    </div>
    <div class="stat-card green">
      <div class="stat-icon green"><i class="ti ti-target"></i></div>
      <div class="stat-num">91%</div>
      <div class="stat-label">Match Accuracy</div>
      <div class="stat-delta up">Confirmed matches</div>
    </div>
    <div class="stat-card gold">
      <div class="stat-icon gold"><i class="ti ti-users"></i></div>
      <div class="stat-num">128</div>
      <div class="stat-label">Active Users</div>
      <div class="stat-delta up">This month</div>
    </div>
  </div>

  <div class="analytics-grid">
    <div class="chart-card">
      <div class="chart-title">Lost Items by Category</div>
      <div class="bar-row"><div class="bar-label">Electronics</div><div class="bar-track"><div class="bar-fill" style="width:72%;background:var(--cyan)"></div></div><div class="bar-val">18</div></div>
      <div class="bar-row"><div class="bar-label">Documents</div><div class="bar-track"><div class="bar-fill" style="width:48%;background:var(--gold)"></div></div><div class="bar-val">12</div></div>
      <div class="bar-row"><div class="bar-label">Accessories</div><div class="bar-track"><div class="bar-fill" style="width:36%;background:var(--purple)"></div></div><div class="bar-val">9</div></div>
      <div class="bar-row"><div class="bar-label">Bags</div><div class="bar-track"><div class="bar-fill" style="width:28%;background:var(--green)"></div></div><div class="bar-val">7</div></div>
      <div class="bar-row"><div class="bar-label">Keys</div><div class="bar-track"><div class="bar-fill" style="width:12%;background:var(--red)"></div></div><div class="bar-val">3</div></div>
    </div>

    <div class="chart-card">
      <div class="chart-title">Top Hotspot Locations</div>
      <div class="hotspot-item"><div class="hotspot-rank">01</div><div class="hotspot-name">Cafeteria / Canteen</div><div class="hotspot-count">14 items</div></div>
      <div class="hotspot-item"><div class="hotspot-rank">02</div><div class="hotspot-name">Library (All Floors)</div><div class="hotspot-count">11 items</div></div>
      <div class="hotspot-item"><div class="hotspot-rank">03</div><div class="hotspot-name">ECE Department</div><div class="hotspot-count">8 items</div></div>
      <div class="hotspot-item"><div class="hotspot-rank">04</div><div class="hotspot-name">Admin Building</div><div class="hotspot-count">6 items</div></div>
      <div class="hotspot-item"><div class="hotspot-rank">05</div><div class="hotspot-name">Main Gate / Entry</div><div class="hotspot-count">4 items</div></div>
    </div>

    <div class="chart-card">
      <div class="chart-title">Monthly Recovery Rate</div>
      <div style="display:flex;align-items:flex-end;gap:10px;height:100px;padding-top:10px">
        <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:4px">
          <div style="flex:1;width:100%;background:var(--navy);border-radius:4px 4px 0 0;display:flex;align-items:flex-end">
            <div style="width:100%;height:35%;background:rgba(0,194,224,0.4);border-radius:4px 4px 0 0"></div>
          </div>
          <div style="font-size:10px;color:var(--txt3)">Mar</div>
        </div>
        <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:4px">
          <div style="flex:1;width:100%;background:var(--navy);border-radius:4px 4px 0 0;display:flex;align-items:flex-end">
            <div style="width:100%;height:50%;background:rgba(0,194,224,0.5);border-radius:4px 4px 0 0"></div>
          </div>
          <div style="font-size:10px;color:var(--txt3)">Apr</div>
        </div>
        <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:4px">
          <div style="flex:1;width:100%;background:var(--navy);border-radius:4px 4px 0 0;display:flex;align-items:flex-end">
            <div style="width:100%;height:62%;background:rgba(0,194,224,0.6);border-radius:4px 4px 0 0"></div>
          </div>
          <div style="font-size:10px;color:var(--txt3)">May</div>
        </div>
        <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:4px">
          <div style="flex:1;width:100%;background:var(--navy);border-radius:4px 4px 0 0;display:flex;align-items:flex-end">
            <div style="width:100%;height:40%;background:var(--cyan);border-radius:4px 4px 0 0"></div>
          </div>
          <div style="font-size:10px;color:var(--cyan)">Jun</div>
        </div>
      </div>
    </div>

    <div class="chart-card" style="display:flex;flex-direction:column;align-items:center;justify-content:center">
      <div class="chart-title" style="text-align:center">Overall Recovery</div>
      <div class="arc-num">40%</div>
      <div class="arc-label">of lost items recovered</div>
      <div style="margin-top:14px;font-size:12px;color:var(--txt3);text-align:center">Target: 60% by end of semester</div>
      <div style="width:100%;height:6px;background:var(--navy);border-radius:3px;margin-top:12px;overflow:hidden">
        <div style="width:67%;height:100%;background:linear-gradient(90deg,var(--cyan),var(--green));border-radius:3px"></div>
      </div>
      <div style="font-size:11px;color:var(--txt3);margin-top:6px">67% toward target</div>
    </div>
  </div>
</div>

<!-- ══ ADMIN VERIFY CLAIMS ══ -->
<div class="panel" id="panel-admin">
  <div class="section-head">
    <div class="section-title">Verify Claims</div>
    <div style="font-size:12px;color:var(--txt2)">2 claims awaiting review</div>
  </div>
  <div class="alert-banner gold" style="margin-bottom:16px">
    <i class="ti ti-shield-exclamation"></i>
    <span>Approving a claim runs the <strong>approve_claim()</strong> Oracle procedure — updates claim, item status, sends notification, and logs to audit trail.</span>
  </div>
  <div class="table-wrap">
    <table>
      <thead><tr><th>Claim #</th><th>Claimant</th><th>Item</th><th>Proof Submitted</th><th>Match Score</th><th>Submitted</th><th>Actions</th></tr></thead>
      <tbody class="claim-row">
        <tr>
          <td style="color:var(--txt3);font-size:12px">C-004</td>
          <td><div class="td-main">Rafiul Ahmed</div><div class="td-sub">2004001 · CSE</div></td>
          <td><div class="td-main">Samsung S23 (L-001)</div><div class="td-sub">Found at Cafeteria</div></td>
          <td class="proof-tags"><span>Description</span><span>Unique mark</span></td>
          <td>
            <div style="display:flex;align-items:center;gap:6px">
              <div class="progress" style="max-width:70px"><div class="progress-bar" style="width:87%;background:var(--gold)"></div></div>
              <span style="font-size:11px;font-weight:600;color:var(--gold)">87%</span>
            </div>
          </td>
          <td>Jun 07</td>
          <td>
            <div style="display:flex;gap:6px">
              <button class="btn btn-sm btn-success" onclick="approveClaim(this,'C-004')"><i class="ti ti-check"></i> Approve</button>
              <button class="btn btn-sm btn-danger"><i class="ti ti-x"></i> Reject</button>
            </div>
          </td>
        </tr>
        <tr>
          <td style="color:var(--txt3);font-size:12px">C-005</td>
          <td><div class="td-main">Tasnim Sara</div><div class="td-sub">2002034 · EEE</div></td>
          <td><div class="td-main">Blue Backpack (L-002)</div><div class="td-sub">Found at Library 2F</div></td>
          <td class="proof-tags"><span>Description</span></td>
          <td>
            <div style="display:flex;align-items:center;gap:6px">
              <div class="progress" style="max-width:70px"><div class="progress-bar" style="width:55%"></div></div>
              <span style="font-size:11px;color:var(--txt2)">55%</span>
            </div>
          </td>
          <td>Jun 08</td>
          <td>
            <div style="display:flex;gap:6px">
              <button class="btn btn-sm btn-success" onclick="approveClaim(this,'C-005')"><i class="ti ti-check"></i> Approve</button>
              <button class="btn btn-sm btn-danger"><i class="ti ti-x"></i> Reject</button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<!-- ══ MY PROFILE ══ -->
<div class="panel" id="panel-profile">
  <div class="profile-header">
    <div class="profile-avatar">RA</div>
    <div style="flex:1">
      <div class="profile-name">Rafiul Ahmed</div>
      <div class="profile-email">admin@kuet.ac.bd · Student ID: 2004001</div>
      <div class="profile-badges" style="margin-top:10px">
        <span class="badge badge-active">Admin</span>
        <span class="badge badge-found">CSE Department</span>
        <span class="tag">Member since Jan 2024</span>
      </div>
    </div>
    <button class="btn"><i class="ti ti-edit"></i> Edit Profile</button>
  </div>
  <div class="profile-stat-grid" style="margin-bottom:20px">
    <div class="profile-stat"><div class="profile-stat-num">6</div><div class="profile-stat-label">Lost Reports</div></div>
    <div class="profile-stat"><div class="profile-stat-num">3</div><div class="profile-stat-label">Items Recovered</div></div>
    <div class="profile-stat"><div class="profile-stat-num">2</div><div class="profile-stat-label">Items Returned</div></div>
  </div>
  <div class="card">
    <div class="form-section-title">Account Settings</div>
    <div class="form-grid">
      <div class="form-field">
        <label class="form-label">Full Name</label>
        <input type="text" class="form-input-app" value="Rafiul Ahmed">
      </div>
      <div class="form-field">
        <label class="form-label">Email</label>
        <input type="email" class="form-input-app" value="admin@kuet.ac.bd" disabled style="opacity:0.6">
      </div>
      <div class="form-field">
        <label class="form-label">Phone</label>
        <input type="tel" class="form-input-app" placeholder="01XXXXXXXXX">
      </div>
      <div class="form-field">
        <label class="form-label">Department</label>
        <select class="form-input-app">
          <option selected>CSE</option><option>EEE</option><option>ECE</option><option>ME</option>
        </select>
      </div>
    </div>
    <div class="form-actions">
      <button class="btn btn-primary"><i class="ti ti-device-floppy"></i> Save Changes</button>
    </div>
  </div>
</div>
