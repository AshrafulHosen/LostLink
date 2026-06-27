<?php

require_once __DIR__.'/../includes/db.php';

$sql = "
SELECT
    M.MATCH_ID,
    M.MATCH_SCORE,

    L.LOST_ID,
    L.ITEM_NAME AS LOST_NAME,
    L.LOST_LOCATION,

    F.FOUND_ID,
    F.ITEM_NAME AS FOUND_NAME,
    F.FOUND_LOCATION

FROM MATCHES M

JOIN LOST_ITEMS L
ON M.LOST_ID = L.LOST_ID

JOIN FOUND_ITEMS F
ON M.FOUND_ID = F.FOUND_ID

ORDER BY M.MATCH_SCORE DESC
";

$stmt = oci_parse($conn,$sql);
oci_execute($stmt);

?>

<div class="panel" id="panel-matches">

  <div class="section-head">
    <div class="section-title">Smart Matches</div>
    <div style="font-size:12px;color:var(--txt2)">
      Powered by Oracle Matching Engine
    </div>
  </div>

  <div class="alert-banner cyan">
    <i class="ti ti-cpu"></i>
    <span>
      Matching considers category, color,
      location and item similarity.
    </span>
  </div>

  <?php while($row = oci_fetch_assoc($stmt)): ?>

  <div class="match-card">

    <div class="match-header">

      <div style="font-size:12px;color:var(--txt2)">
        Match #M-<?php echo $row['MATCH_ID']; ?>
      </div>

      <div class="match-score-badge">
        <i class="ti ti-sparkles"></i>
        <?php echo round($row['MATCH_SCORE']); ?>% Match
      </div>

    </div>

    <div class="match-body">

      <div class="match-item">

        <div class="match-item-label">
          Lost Item (L-<?php echo $row['LOST_ID']; ?>)
        </div>

        <div class="match-item-name">
          <?php echo htmlspecialchars($row['LOST_NAME']); ?>
        </div>

        <div class="match-item-loc">
          <i class="ti ti-map-pin"></i>
          <?php echo htmlspecialchars($row['LOST_LOCATION']); ?>
        </div>

      </div>

      <div class="match-arrow">
        <i class="ti ti-arrows-exchange"></i>
      </div>

      <div class="match-item">

        <div class="match-item-label">
          Found Item (F-<?php echo $row['FOUND_ID']; ?>)
        </div>

        <div class="match-item-name">
          <?php echo htmlspecialchars($row['FOUND_NAME']); ?>
        </div>

        <div class="match-item-loc">
          <i class="ti ti-map-pin"></i>
          <?php echo htmlspecialchars($row['FOUND_LOCATION']); ?>
        </div>

      </div>

    </div>

  </div>

  <?php endwhile; ?>

</div>