<?php
include "includes/db.php";
$sql = "
CREATE OR REPLACE FUNCTION FN_GET_USER_CLAIMS (
    p_claimant_id IN NUMBER
) RETURN SYS_REFCURSOR AS
    v_cursor SYS_REFCURSOR;
BEGIN
    OPEN v_cursor FOR
    SELECT 
        C.CLAIM_ID, C.STATUS, C.CREATED_AT, C.PROOF_TEXT, 
        F.FOUND_ID, F.ITEM_NAME, F.FOUND_LOCATION, 
        F.CATEGORY, F.COLOR, F.DESCRIPTION, F.FOUND_DATE,
        FN_GET_ITEM_IMAGE(NULL, F.FOUND_ID) AS IMAGE_PATH
    FROM CLAIMS C
    JOIN FOUND_ITEMS F ON C.FOUND_ID = F.FOUND_ID
    WHERE C.CLAIMANT_ID = p_claimant_id
    ORDER BY C.CREATED_AT DESC;
    RETURN v_cursor;
END;
";
$stmt = oci_parse($conn, $sql);
oci_execute($stmt);
echo "Function updated.";
?>
