<?php
$claimSql = "BEGIN :cursor := FN_GET_USER_CLAIMS(:user_id); END;";
$claimStmt = oci_parse($conn, $claimSql);
$claimCursor = oci_new_cursor($conn);
oci_bind_by_name($claimStmt, ":cursor", $claimCursor, -1, OCI_B_CURSOR);
$claimUserId = $_SESSION['user_id'] ?? 0;
oci_bind_by_name($claimStmt, ":user_id", $claimUserId);
oci_execute($claimStmt);
oci_execute($claimCursor);
?>
<!-- ══ MY CLAIMS ══ -->
<div class="panel" id="panel-claims">
  <div class="section-head">
    <div class="section-title">My Claims</div>
  </div>
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>Claim #</th>
          <th>Item Claimed</th>
          <th>Proof Submitted</th>
          <th>Submitted</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php while($claimRow = oci_fetch_assoc($claimCursor)): 
            $statusClass = strtolower($claimRow['STATUS']);
        ?>
        <tr>
          <td style="color:var(--txt3);font-size:12px">C-<?= htmlspecialchars($claimRow['CLAIM_ID']) ?></td>
          <td>
            <div class="td-main"><?= htmlspecialchars($claimRow['ITEM_NAME']) ?></div>
            <div class="td-sub">Found at <?= htmlspecialchars($claimRow['FOUND_LOCATION']) ?> · F-<?= htmlspecialchars($claimRow['FOUND_ID']) ?></div>
          </td>
          <td><span class="tag"><?= htmlspecialchars($claimRow['PROOF_TEXT']) ?></span></td>
          <td><?= date('M d', strtotime($claimRow['CREATED_AT'])) ?></td>
          <td><span class="badge badge-<?= $statusClass ?>"><?= ucfirst(strtolower($claimRow['STATUS'])) ?></span></td>
          <td><button class="btn btn-sm">Details</button></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<?php
$notifSql = "BEGIN :cursor := FN_GET_USER_NOTIFICATIONS(:user_id); END;";
$notifStmt = oci_parse($conn, $notifSql);
$notifCursor = oci_new_cursor($conn);
oci_bind_by_name($notifStmt, ":cursor", $notifCursor, -1, OCI_B_CURSOR);
oci_bind_by_name($notifStmt, ":user_id", $claimUserId);
oci_execute($notifStmt);
oci_execute($notifCursor);
?>
<!-- ══ NOTIFICATIONS ══ -->
<div class="panel" id="panel-notifications">
  <div class="section-head">
    <div class="section-title">All Notifications</div>
    <button class="btn btn-sm">Mark all read</button>
  </div>
  <div class="card">
    <div class="notif-list">
      <?php while($notifRow = oci_fetch_assoc($notifCursor)): 
          $msg = $notifRow['MESSAGE'];
          $isMatch = stripos($msg, 'match') !== false;
          $isApprove = stripos($msg, 'approved') !== false;
          $iconClass = $isMatch ? 'match' : ($isApprove ? 'claim' : 'info');
          $iconType = $isMatch ? 'ti-sparkles' : ($isApprove ? 'ti-circle-check' : 'ti-info-circle');
      ?>
      <div class="notif-item">
        <div class="notif-icon <?= $iconClass ?>"><i class="ti <?= $iconType ?>"></i></div>
        <div style="flex:1">
          <div class="notif-text"><?= htmlspecialchars($msg) ?></div>
          <div class="notif-time"><?= date('M d \a\t g:i A', strtotime($notifRow['CREATED_AT'])) ?></div>
        </div>
        <?php if($notifRow['IS_READ'] == 'N'): ?>
        <div class="notif-unread"></div>
        <?php endif; ?>
      </div>
      <?php endwhile; ?>
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
      <div class="bar-row">
        <div class="bar-label">Electronics</div>
        <div class="bar-track">
          <div class="bar-fill" style="width:72%;background:var(--cyan)"></div>
        </div>
        <div class="bar-val">18</div>
      </div>
      <div class="bar-row">
        <div class="bar-label">Documents</div>
        <div class="bar-track">
          <div class="bar-fill" style="width:48%;background:var(--gold)"></div>
        </div>
        <div class="bar-val">12</div>
      </div>
      <div class="bar-row">
        <div class="bar-label">Accessories</div>
        <div class="bar-track">
          <div class="bar-fill" style="width:36%;background:var(--purple)"></div>
        </div>
        <div class="bar-val">9</div>
      </div>
      <div class="bar-row">
        <div class="bar-label">Bags</div>
        <div class="bar-track">
          <div class="bar-fill" style="width:28%;background:var(--green)"></div>
        </div>
        <div class="bar-val">7</div>
      </div>
      <div class="bar-row">
        <div class="bar-label">Keys</div>
        <div class="bar-track">
          <div class="bar-fill" style="width:12%;background:var(--red)"></div>
        </div>
        <div class="bar-val">3</div>
      </div>
    </div>

    <div class="chart-card">
      <div class="chart-title">Top Hotspot Locations</div>
      <div class="hotspot-item">
        <div class="hotspot-rank">01</div>
        <div class="hotspot-name">Cafeteria / Canteen</div>
        <div class="hotspot-count">14 items</div>
      </div>
      <div class="hotspot-item">
        <div class="hotspot-rank">02</div>
        <div class="hotspot-name">Library (All Floors)</div>
        <div class="hotspot-count">11 items</div>
      </div>
      <div class="hotspot-item">
        <div class="hotspot-rank">03</div>
        <div class="hotspot-name">ECE Department</div>
        <div class="hotspot-count">8 items</div>
      </div>
      <div class="hotspot-item">
        <div class="hotspot-rank">04</div>
        <div class="hotspot-name">Admin Building</div>
        <div class="hotspot-count">6 items</div>
      </div>
      <div class="hotspot-item">
        <div class="hotspot-rank">05</div>
        <div class="hotspot-name">Main Gate / Entry</div>
        <div class="hotspot-count">4 items</div>
      </div>
    </div>

    <div class="chart-card">
      <div class="chart-title">Monthly Recovery Rate</div>
      <div style="display:flex;align-items:flex-end;gap:10px;height:100px;padding-top:10px">
        <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:4px">
          <div
            style="flex:1;width:100%;background:var(--navy);border-radius:4px 4px 0 0;display:flex;align-items:flex-end">
            <div style="width:100%;height:35%;background:rgba(0,194,224,0.4);border-radius:4px 4px 0 0"></div>
          </div>
          <div style="font-size:10px;color:var(--txt3)">Mar</div>
        </div>
        <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:4px">
          <div
            style="flex:1;width:100%;background:var(--navy);border-radius:4px 4px 0 0;display:flex;align-items:flex-end">
            <div style="width:100%;height:50%;background:rgba(0,194,224,0.5);border-radius:4px 4px 0 0"></div>
          </div>
          <div style="font-size:10px;color:var(--txt3)">Apr</div>
        </div>
        <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:4px">
          <div
            style="flex:1;width:100%;background:var(--navy);border-radius:4px 4px 0 0;display:flex;align-items:flex-end">
            <div style="width:100%;height:62%;background:rgba(0,194,224,0.6);border-radius:4px 4px 0 0"></div>
          </div>
          <div style="font-size:10px;color:var(--txt3)">May</div>
        </div>
        <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:4px">
          <div
            style="flex:1;width:100%;background:var(--navy);border-radius:4px 4px 0 0;display:flex;align-items:flex-end">
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
      <div style="margin-top:14px;font-size:12px;color:var(--txt3);text-align:center">Target: 60% by end of semester
      </div>
      <div style="width:100%;height:6px;background:var(--navy);border-radius:3px;margin-top:12px;overflow:hidden">
        <div style="width:67%;height:100%;background:linear-gradient(90deg,var(--cyan),var(--green));border-radius:3px">
        </div>
      </div>
      <div style="font-size:11px;color:var(--txt3);margin-top:6px">67% toward target</div>
    </div>
  </div>
</div>

<?php
$adminClaimsSql = "BEGIN :cursor := FN_GET_PENDING_CLAIMS(); END;";
$adminClaimsStmt = oci_parse($conn, $adminClaimsSql);
$adminClaimsCursor = oci_new_cursor($conn);
oci_bind_by_name($adminClaimsStmt, ":cursor", $adminClaimsCursor, -1, OCI_B_CURSOR);
oci_execute($adminClaimsStmt);
oci_execute($adminClaimsCursor);
?>
<!-- ══ ADMIN: VERIFY CLAIMS ══ -->
<div class="panel" id="panel-admin">
  <div class="section-head">
    <div class="section-title">Verify Pending Claims</div>
  </div>
  <div class="alert-banner gold" style="margin-bottom:16px">
    <i class="ti ti-shield-exclamation"></i>
    <span>Approving a claim runs the <strong>SP_PROCESS_CLAIM</strong> Oracle procedure — updates claim, item status, and sends a notification.</span>
  </div>
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>Claim #</th>
          <th>Claimant</th>
          <th>Item</th>
          <th>Proof Submitted</th>
          <th>Match Score</th>
          <th>Submitted</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="claim-row">
        <?php while($acRow = oci_fetch_assoc($adminClaimsCursor)): 
            $matchScore = $acRow['MATCH_SCORE'];
            $scoreText = $matchScore ? $matchScore . '%' : 'N/A';
            $barWidth = $matchScore ? $matchScore . '%' : '0%';
        ?>
        <tr>
          <td style="color:var(--txt3);font-size:12px">C-<?= htmlspecialchars($acRow['CLAIM_ID']) ?></td>
          <td>
            <div class="td-main"><?= htmlspecialchars($acRow['FULL_NAME']) ?></div>
            <div class="td-sub"><?= htmlspecialchars($acRow['STUDENT_ID']) ?> · <?= htmlspecialchars($acRow['DEPARTMENT']) ?></div>
          </td>
          <td>
            <div class="td-main"><?= htmlspecialchars($acRow['ITEM_NAME']) ?></div>
            <div class="td-sub">Found at <?= htmlspecialchars($acRow['FOUND_LOCATION']) ?></div>
          </td>
          <td><span class="tag"><?= htmlspecialchars($acRow['PROOF_TEXT']) ?></span></td>
          <td>
            <div style="display:flex;align-items:center;gap:6px">
              <div class="progress" style="max-width:70px">
                <div class="progress-bar" style="width:<?= $barWidth ?>;background:<?= $matchScore >= 75 ? 'var(--green)' : ($matchScore >= 50 ? 'var(--gold)' : 'var(--border2)') ?>"></div>
              </div>
              <span style="font-size:11px;font-weight:600;color:<?= $matchScore >= 75 ? 'var(--green)' : ($matchScore >= 50 ? 'var(--gold)' : 'var(--txt3)') ?>"><?= $scoreText ?></span>
            </div>
          </td>
          <td><?= date('M d', strtotime($acRow['CREATED_AT'])) ?></td>
          <td>
            <div style="display:flex;gap:6px">
              <form method="POST" action="process_claim.php" style="margin:0">
                <input type="hidden" name="claim_id" value="<?= htmlspecialchars($acRow['CLAIM_ID']) ?>">
                <input type="hidden" name="action" value="APPROVED">
                <button type="submit" class="btn btn-sm btn-success"><i class="ti ti-check"></i> Approve</button>
              </form>
              <form method="POST" action="process_claim.php" style="margin:0">
                <input type="hidden" name="claim_id" value="<?= htmlspecialchars($acRow['CLAIM_ID']) ?>">
                <input type="hidden" name="action" value="REJECTED">
                <button type="submit" class="btn btn-sm btn-danger"><i class="ti ti-x"></i> Reject</button>
              </form>
            </div>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<?php
$profUserId = $_SESSION['user_id'] ?? 0;
$profSql = "BEGIN :cursor := FN_GET_USER_PROFILE(:user_id); END;";
$profStmt = oci_parse($conn, $profSql);
$profCursor = oci_new_cursor($conn);
oci_bind_by_name($profStmt, ":cursor", $profCursor, -1, OCI_B_CURSOR);
oci_bind_by_name($profStmt, ":user_id", $profUserId);
oci_execute($profStmt);
oci_execute($profCursor);
$profileData = oci_fetch_assoc($profCursor) ?: [];
$profInitials = strtoupper(substr($profileData['FULL_NAME'] ?? 'U', 0, 2));
?>
<!-- ══ MY PROFILE ══ -->
<div class="panel" id="panel-profile">
  <div class="profile-header">
    <div class="profile-avatar"><?= htmlspecialchars($profInitials) ?></div>
    <div style="flex:1">
      <div class="profile-name"><?= htmlspecialchars($profileData['FULL_NAME'] ?? '') ?></div>
      <div class="profile-email"><?= htmlspecialchars($profileData['EMAIL'] ?? '') ?> · Student ID:
        <?= htmlspecialchars($profileData['STUDENT_ID'] ?? '') ?>
      </div>
      <div class="profile-badges" style="margin-top:10px">
        <span class="badge badge-active"><?= htmlspecialchars($profileData['ROLE'] ?? 'User') ?></span>
        <?php if (!empty($profileData['DEPARTMENT'])): ?>
          <span class="badge badge-found"><?= htmlspecialchars($profileData['DEPARTMENT']) ?> Department</span>
        <?php endif; ?>
        <span class="tag">Member since
          <?= isset($profileData['CREATED_AT']) ? date('M Y', strtotime($profileData['CREATED_AT'])) : '' ?></span>
      </div>
    </div>
  </div>
  <div class="profile-stat-grid" style="margin-bottom:20px">
    <div class="profile-stat">
      <div class="profile-stat-num">6</div>
      <div class="profile-stat-label">Lost Reports</div>
    </div>
    <div class="profile-stat">
      <div class="profile-stat-num">3</div>
      <div class="profile-stat-label">Items Recovered</div>
    </div>
    <div class="profile-stat">
      <div class="profile-stat-num">2</div>
      <div class="profile-stat-label">Items Returned</div>
    </div>
  </div>
  <div class="card">
    <div class="form-section-title">Account Settings</div>
    <form method="POST" action="update_profile.php">
      <div class="form-grid">
        <div class="form-field">
          <label class="form-label">Full Name</label>
          <input type="text" name="full_name" class="form-input-app"
            value="<?= htmlspecialchars($profileData['FULL_NAME'] ?? '') ?>" required>
        </div>
        <div class="form-field">
          <label class="form-label">Email</label>
          <input type="email" class="form-input-app" value="<?= htmlspecialchars($profileData['EMAIL'] ?? '') ?>"
            disabled style="opacity:0.6">
        </div>
        <div class="form-field">
          <label class="form-label">Phone</label>
          <input type="tel" name="phone" class="form-input-app" placeholder="01XXXXXXXXX"
            value="<?= htmlspecialchars($profileData['PHONE'] ?? '') ?>">
        </div>
        <div class="form-field">
          <label class="form-label">Department</label>
          <select name="department" class="form-input-app">
            <option value="" <?= empty($profileData['DEPARTMENT']) ? 'selected' : '' ?>>Select Department</option>
            <option value="CSE" <?= ($profileData['DEPARTMENT'] ?? '') == 'CSE' ? 'selected' : '' ?>>CSE</option>
            <option value="EEE" <?= ($profileData['DEPARTMENT'] ?? '') == 'EEE' ? 'selected' : '' ?>>EEE</option>
            <option value="ECE" <?= ($profileData['DEPARTMENT'] ?? '') == 'ECE' ? 'selected' : '' ?>>ECE</option>
            <option value="ME" <?= ($profileData['DEPARTMENT'] ?? '') == 'ME' ? 'selected' : '' ?>>ME</option>
          </select>
        </div>
      </div>
      <div class="form-actions">
        <button type="submit" class="btn btn-primary"><i class="ti ti-device-floppy"></i> Save Changes</button>
      </div>
    </form>
  </div>
</div>