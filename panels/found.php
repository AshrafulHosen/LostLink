<?php

require_once __DIR__ . '/../includes/db.php';

$sql = "
SELECT
    FOUND_ID,
    ITEM_NAME,
    CATEGORY,
    COLOR,
    DESCRIPTION,
    FOUND_LOCATION,
    FOUND_DATE,
    STATUS
FROM FOUND_ITEMS
ORDER BY FOUND_ID DESC
";

$stmt = oci_parse($conn,$sql);
oci_execute($stmt);

?>

<div class="panel" id="panel-found">

  <div class="section-head">
    <div class="section-title">Found Items Registry</div>

    <button
    class="btn btn-primary"
    onclick="showPanel('report', document.querySelector('.nav-item:nth-child(9)'))">
      <i class="ti ti-plus"></i>
      Report Found
    </button>
  </div>

  <div class="table-wrap">

    <table>

      <thead>
      <tr>
        <th>ID</th>
        <th>Item Name</th>
        <th>Category</th>
        <th>Location</th>
        <th>Date Found</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
      </thead>

      <tbody>

      <?php while($row = oci_fetch_assoc($stmt)): ?>

      <tr>

        <td>
          F-<?php echo str_pad($row['FOUND_ID'],3,'0',STR_PAD_LEFT); ?>
        </td>

        <td>
          <div class="td-main">
            <?php echo htmlspecialchars($row['ITEM_NAME']); ?>
          </div>

          <div class="td-sub">
            <?php echo htmlspecialchars(substr($row['DESCRIPTION'],0,80)); ?>
          </div>
        </td>

        <td>
          <?php echo htmlspecialchars($row['CATEGORY']); ?>
        </td>

        <td>
          <?php echo htmlspecialchars($row['FOUND_LOCATION']); ?>
        </td>

        <td>
          <?php
          if(!empty($row['FOUND_DATE']))
          {
              echo date(
                  'd M Y',
                  strtotime($row['FOUND_DATE'])
              );
          }
          ?>
        </td>

        <td>

        <?php

        $status = strtoupper($row['STATUS']);

        if($status == 'UNCLAIMED')
        {
            echo '<span class="badge badge-active">Unclaimed</span>';
        }
        elseif($status == 'CLAIMED')
        {
            echo '<span class="badge badge-claimed">Claimed</span>';
        }
        elseif($status == 'RETURNED')
        {
            echo '<span class="badge badge-returned">Returned</span>';
        }
        else
        {
            echo '<span class="badge">'.$status.'</span>';
        }

        ?>

        </td>

        <td>

          <button
          class="btn btn-sm"
          onclick="openItemModal(
          '<?php echo addslashes($row['ITEM_NAME']); ?>',
          'Found',
          '<?php echo addslashes($row['FOUND_LOCATION']); ?>',
          '<?php echo addslashes($row['FOUND_DATE']); ?>',
          '<?php echo addslashes($row['CATEGORY']); ?>',
          '<?php echo addslashes($row['COLOR']); ?>',
          '<?php echo addslashes($row['DESCRIPTION']); ?>',
          '<?php echo addslashes($row['STATUS']); ?>'
          )">
            View
          </button>

        </td>

      </tr>

      <?php endwhile; ?>

      </tbody>

    </table>

  </div>

</div>