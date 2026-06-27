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

<div class="panel active" id="panel-dashboard">
  <div class="stats-grid">
    <div class="stat-card red">
      <div class="stat-icon red"><i class="ti ti-alert-triangle"></i></div>
      <div class="stat-num"><?= $lostCount ?></div>
      <div class="stat-label">Total Lost</div>
      <div class="stat-delta up"><i class="ti ti-arrow-up" style="font-size:10px"></i> 12 this month</div>
    </div>
    <div class="stat-card green">
      <div class="stat-icon green"><i class="ti ti-package"></i></div>
      <div class="stat-num"><?= $foundCount ?></div>
      <div class="stat-label">Total Found</div>
      <div class="stat-delta up"><i class="ti ti-arrow-up" style="font-size:10px"></i> 8 this month</div>
    </div>
    <div class="stat-card cyan">
      <div class="stat-icon cyan"><i class="ti ti-circle-check"></i></div>
      <div class="stat-num"><?= $recoveredCount ?></div>
      <div class="stat-label">Recovered</div>
      <div class="stat-delta" style="color:var(--cyan)">40% recovery rate</div>
    </div>
    <div class="stat-card gold">
      <div class="stat-icon gold"><i class="ti ti-clock"></i></div>
      <div class="stat-num"><?= $claimCount ?></div>
      <div class="stat-label">Pending Claims</div>
      <div class="stat-delta" style="color:var(--gold)">Needs admin review</div>
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
        <div class="filter-row" style="margin:0;gap:6px">
          <div class="chip active">All</div>
          <div class="chip">Lost</div>
          <div class="chip">Found</div>
        </div>
      </div>
      <div style="display:flex;flex-direction:column;gap:10px">
        <div class="item-card has-match" onclick="openItemModal('Samsung Galaxy S23','Lost','Near KUET Cafeteria','Jun 05, 2026','Electronics','Black','Crack on back glass','Matched')">
          <div class="item-top">
            <div class="item-icon lost"><i class="ti ti-device-mobile"></i></div>
            <div style="flex:1">
              <div class="item-name">Samsung Galaxy S23 (Black)</div>
              <div class="item-loc"><i class="ti ti-map-pin"></i> Near KUET Cafeteria</div>
            </div>
            <span class="badge badge-lost">Lost</span>
          </div>
          <div class="item-footer">
            <span class="item-date">Jun 05, 2026</span>
            <span class="badge badge-matched"><i class="ti ti-sparkles" style="font-size:10px"></i> 87% Match</span>
          </div>
        </div>
        <div class="item-card is-found" onclick="openItemModal('Black Leather Wallet','Found','ECE Department','Jun 06, 2026','Accessories','Black','Has student card inside','Unclaimed')">
          <div class="item-top">
            <div class="item-icon found"><i class="ti ti-wallet"></i></div>
            <div style="flex:1">
              <div class="item-name">Black Leather Wallet</div>
              <div class="item-loc"><i class="ti ti-map-pin"></i> ECE Department</div>
            </div>
            <span class="badge badge-found">Found</span>
          </div>
          <div class="item-footer">
            <span class="item-date">Jun 06, 2026</span>
            <span class="badge badge-active">Unclaimed</span>
          </div>
        </div>
        <div class="item-card" onclick="openItemModal('Blue Backpack','Lost','Library 2nd Floor','Jun 07, 2026','Bags','Blue','HP Laptop inside, sticker on front','Active')">
          <div class="item-top">
            <div class="item-icon lost"><i class="ti ti-backpack"></i></div>
            <div style="flex:1">
              <div class="item-name">Blue Backpack — HP Laptop inside</div>
              <div class="item-loc"><i class="ti ti-map-pin"></i> Library 2nd Floor</div>
            </div>
            <span class="badge badge-lost">Lost</span>
          </div>
          <div class="item-footer">
            <span class="item-date">Jun 07, 2026</span>
            <span class="badge badge-active">Active</span>
          </div>
        </div>
        <div class="item-card is-found" onclick="openItemModal('Student ID Card','Found','Admin Building','Jun 07, 2026','Documents','—','KUET ID Card 2001045','Claimed')">
          <div class="item-top">
            <div class="item-icon found"><i class="ti ti-id-badge"></i></div>
            <div style="flex:1">
              <div class="item-name">Student ID Card</div>
              <div class="item-loc"><i class="ti ti-map-pin"></i> Admin Building</div>
            </div>
            <span class="badge badge-found">Found</span>
          </div>
          <div class="item-footer">
            <span class="item-date">Jun 07, 2026</span>
            <span class="badge badge-claimed">Claimed</span>
          </div>
        </div>
      </div>
    </div>

    <div>
      <div class="section-head"><div class="section-title">Notifications</div></div>
      <div class="card">
        <div class="notif-list">
          <div class="notif-item">
            <div class="notif-icon match"><i class="ti ti-sparkles"></i></div>
            <div style="flex:1">
              <div class="notif-text">87% match found for your <strong>Samsung S23</strong> — a similar phone found at Cafeteria.</div>
              <div class="notif-time">2 hours ago</div>
            </div>
            <div class="notif-unread"></div>
          </div>
          <div class="notif-item">
            <div class="notif-icon claim"><i class="ti ti-clipboard-check"></i></div>
            <div style="flex:1">
              <div class="notif-text">Your claim for <strong>Black Rimmed Glasses</strong> has been <strong style="color:var(--green)">approved</strong>.</div>
              <div class="notif-time">Yesterday</div>
            </div>
            <div class="notif-unread"></div>
          </div>
          <div class="notif-item">
            <div class="notif-icon info"><i class="ti ti-info-circle"></i></div>
            <div style="flex:1">
              <div class="notif-text">A <strong>Student ID Card</strong> matching your description was turned in at Admin Building.</div>
              <div class="notif-time">2 days ago</div>
            </div>
            <div class="notif-unread"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
