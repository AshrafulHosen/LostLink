<?php

require_once __DIR__ . '/../includes/db.php';

$sql = "
SELECT
    FOUND_ID,
    USER_ID,
    ITEM_NAME,
    CATEGORY,
    COLOR,
    DESCRIPTION,
    FOUND_LOCATION,
    FOUND_DATE,
    STATUS,
    FN_GET_ITEM_IMAGE(NULL, FOUND_ID) AS IMAGE_PATH
FROM FOUND_ITEMS
ORDER BY FOUND_ID DESC
";

$stmt = oci_parse($conn, $sql);
oci_execute($stmt);

$myItems = [];
$otherItems = [];

while($row = oci_fetch_assoc($stmt)) {
    if (isset($_SESSION['user_id']) && $row['USER_ID'] == $_SESSION['user_id']) {
        $myItems[] = $row;
    } else {
        $otherItems[] = $row;
    }
}
?>

<div class="panel" id="panel-found">

  <div class="section-head">
    <div class="section-title">Found Items Registry</div>
    <button class="btn btn-primary" onclick="showPanel('report', document.querySelector('.nav-item:nth-child(9)')); switchReportTab('found');">
      <i class="ti ti-plus"></i> Report Found
    </button>
  </div>

  <?php if(count($myItems) > 0): ?>
  <div style="font-size:12px;color:var(--txt2);margin-bottom:12px;text-transform:uppercase;letter-spacing:1px;">My Submissions</div>
  
  <div class="table-wrap" style="margin-bottom:24px;">
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Item Name</th>
          <th>Category</th>
          <th>Location</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach($myItems as $row): ?>
        <tr data-category="<?php echo strtolower(htmlspecialchars($row['CATEGORY'])); ?>" data-status="<?php echo strtolower(htmlspecialchars($row['STATUS'])); ?>">
          <td>F-<?php echo str_pad($row['FOUND_ID'],3,'0',STR_PAD_LEFT); ?></td>
          <td>
            <div class="td-main">
              <?php echo htmlspecialchars($row['ITEM_NAME']); ?>
            </div>
            <div class="td-sub"><?php echo htmlspecialchars(substr($row['DESCRIPTION'],0,80)); ?></div>
          </td>
          <td><?php echo htmlspecialchars($row['CATEGORY']); ?></td>
          <td><?php echo htmlspecialchars($row['FOUND_LOCATION']); ?></td>
          <td>
            <?php
            $status = ucfirst(strtolower($row['STATUS']));
            if($status === 'Matched') echo '<span class="badge badge-matched">' . $status . '</span>';
            elseif($status === 'Returned') echo '<span class="badge badge-returned">' . $status . '</span>';
            else echo '<span class="badge">' . $status . '</span>';
            ?>
          </td>
          <td>
            <button class="btn btn-sm" onclick="openItemModal(
              <?php echo $row['FOUND_ID']; ?>,
              '<?php echo addslashes($row['ITEM_NAME']); ?>',
              'Found',
              '<?php echo addslashes($row['FOUND_LOCATION']); ?>',
              '<?php echo addslashes($row['FOUND_DATE']); ?>',
              '<?php echo addslashes($row['CATEGORY']); ?>',
              '<?php echo addslashes($row['COLOR']); ?>',
              '<?php echo addslashes($row['DESCRIPTION']); ?>',
              '<?php echo addslashes($row['STATUS']); ?>',
              '<?php echo addslashes($row['IMAGE_PATH']); ?>'
              )">View</button>
            <?php if (!empty($row['IMAGE_PATH'])): ?>
            <button class="btn btn-sm" onclick="viewImage('<?php echo htmlspecialchars($row['IMAGE_PATH']); ?>')"> Show Image </button>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  
  <div style="font-size:12px;color:var(--txt2);margin-bottom:12px;text-transform:uppercase;letter-spacing:1px;">Other Found Items</div>
  <?php endif; ?>

  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Item Name</th>
          <th>Category</th>
          <th>Location</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach($otherItems as $row): ?>
        <tr data-category="<?php echo strtolower(htmlspecialchars($row['CATEGORY'])); ?>" data-status="<?php echo strtolower(htmlspecialchars($row['STATUS'])); ?>">
          <td>F-<?php echo str_pad($row['FOUND_ID'],3,'0',STR_PAD_LEFT); ?></td>
          <td>
            <div class="td-main"><?php echo htmlspecialchars($row['ITEM_NAME']); ?></div>
            <div class="td-sub"><?php echo htmlspecialchars(substr($row['DESCRIPTION'],0,80)); ?></div>
          </td>
          <td><?php echo htmlspecialchars($row['CATEGORY']); ?></td>
          <td><?php echo htmlspecialchars($row['FOUND_LOCATION']); ?></td>
          <td>
            <?php
            $status = ucfirst(strtolower($row['STATUS']));
            if($status === 'Matched') echo '<span class="badge badge-matched">' . $status . '</span>';
            elseif($status === 'Returned') echo '<span class="badge badge-returned">' . $status . '</span>';
            else echo '<span class="badge">' . $status . '</span>';
            ?>
          </td>
          <td>
            <button class="btn btn-sm" onclick="openItemModal(
              <?php echo $row['FOUND_ID']; ?>,
              '<?php echo addslashes($row['ITEM_NAME']); ?>',
              'Found',
              '<?php echo addslashes($row['FOUND_LOCATION']); ?>',
              '<?php echo addslashes($row['FOUND_DATE']); ?>',
              '<?php echo addslashes($row['CATEGORY']); ?>',
              '<?php echo addslashes($row['COLOR']); ?>',
              '<?php echo addslashes($row['DESCRIPTION']); ?>',
              '<?php echo addslashes($row['STATUS']); ?>',
              '<?php echo addslashes($row['IMAGE_PATH']); ?>'
              )">View</button>
            <?php if (!empty($row['IMAGE_PATH'])): ?>
            <button class="btn btn-sm" onclick="viewImage('<?php echo htmlspecialchars($row['IMAGE_PATH']); ?>')"> Show Image </button>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>