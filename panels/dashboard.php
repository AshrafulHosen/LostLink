<!-- ══ DASHBOARD ══ -->
<?php

require_once __DIR__ . '/../includes/db.php';

$lostCount = 0;
$foundCount = 0;
$claimCount = 0;
$recoveredCount = 0;

/* LOST ITEMS */
$sql = "SELECT COUNT(*) TOTAL FROM LOST_ITEMS";
$stmt = oci_parse($conn,$sql);
oci_execute($stmt);

if($row = oci_fetch_assoc($stmt))
{
    $lostCount = $row['TOTAL'];
}

/* FOUND ITEMS */
$sql = "SELECT COUNT(*) TOTAL FROM FOUND_ITEMS";
$stmt = oci_parse($conn,$sql);
oci_execute($stmt);

if($row = oci_fetch_assoc($stmt))
{
    $foundCount = $row['TOTAL'];
}

/* CLAIMS */
$sql = "SELECT COUNT(*) TOTAL FROM CLAIMS WHERE STATUS='PENDING'";
$stmt = oci_parse($conn,$sql);
oci_execute($stmt);

if($row = oci_fetch_assoc($stmt))
{
    $claimCount = $row['TOTAL'];
}

/* RECOVERED */
$sql = "SELECT COUNT(*) TOTAL FROM CLAIMS WHERE STATUS='APPROVED'";
$stmt = oci_parse($conn,$sql);
oci_execute($stmt);

if($row = oci_fetch_assoc($stmt))
{
    $recoveredCount = $row['TOTAL'];
}
?>

<?php
$recoveryRate = ($lostCount > 0) ? round(($recoveredCount / $lostCount) * 100) : 0;
?>

<div class="panel active" id="panel-dashboard">
  <div class="stats-grid">
    <div class="stat-card red">
      <div class="stat-icon red"><i class="ti ti-alert-triangle"></i></div>
      <div class="stat-num"><?= $lostCount ?></div>
      <div class="stat-label">Total Lost</div>
      <div class="stat-delta up"><i class="ti ti-arrow-up" style="font-size:10px"></i> All time</div>
    </div>
    <div class="stat-card green">
      <div class="stat-icon green"><i class="ti ti-package"></i></div>
      <div class="stat-num"><?= $foundCount ?></div>
      <div class="stat-label">Total Found</div>
      <div class="stat-delta up"><i class="ti ti-arrow-up" style="font-size:10px"></i> All time</div>
    </div>
    <div class="stat-card cyan">
      <div class="stat-icon cyan"><i class="ti ti-circle-check"></i></div>
      <div class="stat-num"><?= $recoveredCount ?></div>
      <div class="stat-label">Recovered</div>
      <div class="stat-delta" style="color:var(--cyan)"><?= $recoveryRate ?>% recovery rate</div>
    </div>
    <div class="stat-card gold">
      <div class="stat-icon gold"><i class="ti ti-clock"></i></div>
      <div class="stat-num"><?= $claimCount ?></div>
      <div class="stat-label">Pending Claims</div>
      <div class="stat-delta" style="color:var(--gold)">Needs review</div>
    </div>
  </div>

  <div class="alert-banner gold">
    <i class="ti ti-sparkles"></i>
    <span><strong>Smart matching found 5 possible matches</strong> — 2 high confidence (87%+), 3 moderate (50%+).</span>
    <span class="alert-link" onclick="showPanel('matches', document.querySelector('.nav-item:nth-child(7)'))">View all →</span>
  </div>

  <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
    <div>
      <div class="section-head">
        <div class="section-title">Recent Activity</div>
      </div>
      <div style="display:flex;flex-direction:column;gap:10px">
        <?php
          $recentSql = "BEGIN :cursor := FN_GET_RECENT_ACTIVITY(); END;";
          $recentStmt = oci_parse($conn, $recentSql);
          $recentCursor = oci_new_cursor($conn);
          oci_bind_by_name($recentStmt, ":cursor", $recentCursor, -1, OCI_B_CURSOR);
          oci_execute($recentStmt);
          oci_execute($recentCursor);
          
          while($recentRow = oci_fetch_assoc($recentCursor)):
              $isLost = ($recentRow['ITEM_TYPE'] == 'LOST');
              $iconBase = $isLost ? 'lost' : 'found';
              $iconName = 'ti-box';
              if(stripos($recentRow['CATEGORY'], 'electronics') !== false) $iconName = 'ti-device-mobile';
              else if(stripos($recentRow['CATEGORY'], 'documents') !== false) $iconName = 'ti-id-badge';
              else if(stripos($recentRow['CATEGORY'], 'bags') !== false) $iconName = 'ti-backpack';
              
              $statusBadge = strtolower($recentRow['STATUS']);
        ?>
        <div class="item-card <?= $isLost ? '' : 'is-found' ?>">
          <div class="item-top">
            <div class="item-icon <?= $iconBase ?>"><i class="ti <?= $iconName ?>"></i></div>
            <div style="flex:1">
              <div class="item-name"><?= htmlspecialchars($recentRow['ITEM_NAME']) ?></div>
              <div class="item-loc"><i class="ti ti-map-pin"></i> <?= htmlspecialchars($recentRow['LOCATION']) ?></div>
            </div>
            <span class="badge badge-<?= $iconBase ?>"><?= ucfirst($iconBase) ?></span>
          </div>
          <div class="item-footer">
            <span class="item-date"><?= date('M d, Y', strtotime($recentRow['ITEM_DATE'])) ?></span>
            <span class="badge badge-<?= $statusBadge ?>"><?= ucfirst($statusBadge) ?></span>
          </div>
        </div>
        <?php endwhile; ?>
      </div>
    </div>

    <div>
      <div class="section-head"><div class="section-title">Recent Notifications</div></div>
      <div class="card">
        <div class="notif-list">
          <?php
            $dashNotifUserId = $_SESSION['user_id'] ?? 0;
            $dashNotifSql = "BEGIN :cursor := FN_GET_USER_NOTIFICATIONS(:user_id); END;";
            $dashNotifStmt = oci_parse($conn, $dashNotifSql);
            $dashNotifCursor = oci_new_cursor($conn);
            oci_bind_by_name($dashNotifStmt, ":cursor", $dashNotifCursor, -1, OCI_B_CURSOR);
            oci_bind_by_name($dashNotifStmt, ":user_id", $dashNotifUserId);
            oci_execute($dashNotifStmt);
            oci_execute($dashNotifCursor);
            
            $notifCount = 0;
            while(($notifRow = oci_fetch_assoc($dashNotifCursor)) && $notifCount < 3): 
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
          <?php $notifCount++; endwhile; ?>
          <?php if($notifCount == 0): ?>
          <div style="padding:20px;text-align:center;color:var(--txt3);font-size:13px">No new notifications</div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
