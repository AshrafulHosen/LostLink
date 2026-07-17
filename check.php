<?php include "includes/db.php"; $s=oci_parse($conn,"SELECT DISTINCT NAME FROM USER_SOURCE WHERE TYPE='PROCEDURE'"); oci_execute($s); while($r=oci_fetch_assoc($s)) { echo $r["NAME"] . "\n"; } ?>
