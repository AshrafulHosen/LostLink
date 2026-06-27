<?php

require_once __DIR__ . '/../includes/db.php';

$sql = "
SELECT
    LOST_ID,
    ITEM_NAME,
    CATEGORY,
    COLOR,
    DESCRIPTION,
    LOST_LOCATION,
    LOST_DATE,
    STATUS
FROM LOST_ITEMS
ORDER BY LOST_ID DESC
";

$stmt = oci_parse($conn, $sql);
oci_execute($stmt);

?>

<div class="panel" id="panel-lost">

  <div class="section-head">
    <div class="section-title">Lost Items Registry</div>

    <button class="btn btn-primary"
      onclick="showPanel('report', document.querySelector('.nav-item:nth-child(9)'))">
      <i class="ti ti-plus"></i> Report Lost
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
          <th>Date Lost</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>

      <tbody>

      <?php while($row = oci_fetch_assoc($stmt)): ?>

        <tr>

          <td>
            L-<?php echo str_pad($row['LOST_ID'],3,'0',STR_PAD_LEFT); ?>
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
            <?php echo htmlspecialchars($row['LOST_LOCATION']); ?>
          </td>

          <td>
            <?php
            if(!empty($row['LOST_DATE']))
            {
                echo date(
                    'd M Y',
                    strtotime($row['LOST_DATE'])
                );
            }
            ?>
          </td>

          <td>

            <?php
            $status = strtoupper($row['STATUS']);

            if($status == 'ACTIVE')
            {
                echo '<span class="badge badge-active">Active</span>';
            }
            elseif($status == 'MATCHED')
            {
                echo '<span class="badge badge-matched">Matched</span>';
            }
            elseif($status == 'RECOVERED')
            {
                echo '<span class="badge badge-recovered">Recovered</span>';
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
              'Lost',
              '<?php echo addslashes($row['LOST_LOCATION']); ?>',
              '<?php echo addslashes($row['LOST_DATE']); ?>',
              '<?php echo addslashes($row['CATEGORY']); ?>',
              '<?php echo addslashes($row['COLOR']); ?>',
              '<?php echo addslashes($row['DESCRIPTION']); ?>',
              '<?php echo addslashes($row['STATUS']); ?>'
              )">

              View

            </button>

            <button class="btn btn-sm" onclick="openEditModal(
                    '<?php echo $row['LOST_ID']; ?>',
                    '<?php echo addslashes($row['ITEM_NAME']); ?>',
                    '<?php echo addslashes($row['CATEGORY']); ?>',
                    '<?php echo addslashes($row['COLOR']); ?>',
                    '<?php echo addslashes($row['LOST_LOCATION']); ?>',
                    '<?php echo addslashes($row['DESCRIPTION']); ?>'
                     )"> Edit </button>

            <a href="delete_lost.php?id=<?php echo $row['LOST_ID']; ?>" class="btn btn-sm" onclick="return confirm('Delete this lost item?');"> Delete </a>

          </td>

        </tr>

      <?php endwhile; ?>

      </tbody>

    </table>

  </div>

</div>