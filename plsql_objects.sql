-- User Management

CREATE OR REPLACE PROCEDURE SP_REGISTER_USER (
    p_fullname IN VARCHAR2,
    p_studentid IN VARCHAR2,
    p_email IN VARCHAR2,
    p_password_hash IN VARCHAR2
) AS
BEGIN
    INSERT INTO USERS (FULL_NAME, STUDENT_ID, EMAIL, PASSWORD_HASH)
    VALUES (p_fullname, p_studentid, p_email, p_password_hash);
    COMMIT;
END;
/

CREATE OR REPLACE FUNCTION FN_GET_USER_BY_EMAIL (
    p_email IN VARCHAR2
) RETURN SYS_REFCURSOR AS
    v_cursor SYS_REFCURSOR;
BEGIN
    OPEN v_cursor FOR
    SELECT USER_ID, FULL_NAME, ROLE, PASSWORD_HASH
    FROM USERS
    WHERE EMAIL = p_email;
    RETURN v_cursor;
END;
/

-- Item Reporting

CREATE OR REPLACE PROCEDURE SP_REPORT_LOST_ITEM (
    p_user_id IN NUMBER,
    p_item_name IN VARCHAR2,
    p_category IN VARCHAR2,
    p_color IN VARCHAR2,
    p_description IN VARCHAR2,
    p_location IN VARCHAR2,
    p_lost_date IN DATE
) AS
BEGIN
    INSERT INTO LOST_ITEMS (USER_ID, ITEM_NAME, CATEGORY, COLOR, DESCRIPTION, LOST_LOCATION, LOST_DATE, STATUS)
    VALUES (p_user_id, p_item_name, p_category, p_color, p_description, p_location, p_lost_date, 'ACTIVE');
    COMMIT;
END;
/

CREATE OR REPLACE PROCEDURE SP_REPORT_FOUND_ITEM (
    p_user_id IN NUMBER,
    p_item_name IN VARCHAR2,
    p_category IN VARCHAR2,
    p_color IN VARCHAR2,
    p_description IN VARCHAR2,
    p_location IN VARCHAR2,
    p_found_date IN DATE
) AS
BEGIN
    INSERT INTO FOUND_ITEMS (USER_ID, ITEM_NAME, CATEGORY, COLOR, DESCRIPTION, FOUND_LOCATION, FOUND_DATE, STATUS)
    VALUES (p_user_id, p_item_name, p_category, p_color, p_description, p_location, p_found_date, 'UNCLAIMED');
    COMMIT;
END;
/

-- Matching Logic
CREATE OR REPLACE FUNCTION FN_CALCULATE_MATCH_SCORE (
    p_lost_category IN VARCHAR2,
    p_lost_color IN VARCHAR2,
    p_lost_location IN VARCHAR2,
    p_lost_date IN DATE,
    p_found_category IN VARCHAR2,
    p_found_color IN VARCHAR2,
    p_found_location IN VARCHAR2,
    p_found_date IN DATE
) RETURN NUMBER AS
    v_score NUMBER := 0;
BEGIN
    IF UPPER(p_lost_category) = UPPER(p_found_category) THEN
        v_score := v_score + 30;
    END IF;
    IF UPPER(p_lost_color) = UPPER(p_found_color) THEN
        v_score := v_score + 25;
    END IF;
    -- simple substring match for location
    IF UPPER(p_lost_location) = UPPER(p_found_location) OR 
       INSTR(UPPER(p_lost_location), UPPER(p_found_location)) > 0 OR
       INSTR(UPPER(p_found_location), UPPER(p_lost_location)) > 0 THEN
        v_score := v_score + 25;
    END IF;
    -- check if found date is on or after lost date and within 30 days
    IF p_found_date >= p_lost_date AND (p_found_date - p_lost_date) <= 30 THEN
        v_score := v_score + 20;
    END IF;
    RETURN v_score;
END;
/

-- Matching Triggers

CREATE OR REPLACE TRIGGER TRG_MATCH_ON_LOST_INSERT
AFTER INSERT ON LOST_ITEMS
FOR EACH ROW
DECLARE
    v_score NUMBER;
    CURSOR c_matches IS
        SELECT FOUND_ID, USER_ID, CATEGORY, COLOR, FOUND_LOCATION, FOUND_DATE FROM FOUND_ITEMS
        WHERE STATUS = 'UNCLAIMED';
BEGIN
    FOR r IN c_matches LOOP
        v_score := FN_CALCULATE_MATCH_SCORE(
            :NEW.CATEGORY, :NEW.COLOR, :NEW.LOST_LOCATION, :NEW.LOST_DATE,
            r.CATEGORY, r.COLOR, r.FOUND_LOCATION, r.FOUND_DATE
        );
        IF v_score >= 50 THEN
            INSERT INTO MATCHES (LOST_ID, FOUND_ID, MATCH_SCORE)
            VALUES (:NEW.LOST_ID, r.FOUND_ID, v_score);
            
            -- Notify the user who lost the item
            INSERT INTO NOTIFICATIONS (USER_ID, MESSAGE)
            VALUES (:NEW.USER_ID, 'A potential match (' || v_score || '%) has been found for your lost item: ' || :NEW.ITEM_NAME);
        END IF;
    END LOOP;
END;
/

CREATE OR REPLACE TRIGGER TRG_MATCH_ON_FOUND_INSERT
AFTER INSERT ON FOUND_ITEMS
FOR EACH ROW
DECLARE
    v_score NUMBER;
    CURSOR c_matches IS
        SELECT LOST_ID, USER_ID, ITEM_NAME, CATEGORY, COLOR, LOST_LOCATION, LOST_DATE FROM LOST_ITEMS
        WHERE STATUS = 'ACTIVE';
BEGIN
    FOR r IN c_matches LOOP
        v_score := FN_CALCULATE_MATCH_SCORE(
            r.CATEGORY, r.COLOR, r.LOST_LOCATION, r.LOST_DATE,
            :NEW.CATEGORY, :NEW.COLOR, :NEW.FOUND_LOCATION, :NEW.FOUND_DATE
        );
        IF v_score >= 50 THEN
            INSERT INTO MATCHES (LOST_ID, FOUND_ID, MATCH_SCORE)
            VALUES (r.LOST_ID, :NEW.FOUND_ID, v_score);
            
            -- Notify the user who lost the item
            INSERT INTO NOTIFICATIONS (USER_ID, MESSAGE)
            VALUES (r.USER_ID, 'A potential match (' || v_score || '%) has been found for your lost item: ' || r.ITEM_NAME);
        END IF;
    END LOOP;
END;
/

-- Claim Management

CREATE OR REPLACE PROCEDURE SP_FILE_CLAIM (
    p_found_id IN NUMBER,
    p_claimant_id IN NUMBER,
    p_proof_text IN VARCHAR2
) AS
BEGIN
    INSERT INTO CLAIMS (FOUND_ID, CLAIMANT_ID, PROOF_TEXT, STATUS)
    VALUES (p_found_id, p_claimant_id, p_proof_text, 'PENDING');
    COMMIT;
END;
/

CREATE OR REPLACE FUNCTION FN_GET_USER_CLAIMS (
    p_claimant_id IN NUMBER
) RETURN SYS_REFCURSOR AS
    v_cursor SYS_REFCURSOR;
BEGIN
    OPEN v_cursor FOR
    SELECT C.CLAIM_ID, C.STATUS, C.CREATED_AT, C.PROOF_TEXT, F.FOUND_ID, F.ITEM_NAME, F.FOUND_LOCATION
    FROM CLAIMS C
    JOIN FOUND_ITEMS F ON C.FOUND_ID = F.FOUND_ID
    WHERE C.CLAIMANT_ID = p_claimant_id
    ORDER BY C.CREATED_AT DESC;
    RETURN v_cursor;
END;
/

CREATE OR REPLACE FUNCTION FN_GET_PENDING_CLAIMS RETURN SYS_REFCURSOR AS
    v_cursor SYS_REFCURSOR;
BEGIN
    OPEN v_cursor FOR
    SELECT
        C.CLAIM_ID,
        C.PROOF_TEXT,
        C.CREATED_AT,
        U.FULL_NAME,
        U.STUDENT_ID,
        U.DEPARTMENT,
        F.ITEM_NAME,
        F.FOUND_LOCATION,
        (SELECT MAX(M.MATCH_SCORE) FROM MATCHES M JOIN LOST_ITEMS L ON M.LOST_ID = L.LOST_ID WHERE M.FOUND_ID = F.FOUND_ID AND L.USER_ID = C.CLAIMANT_ID) AS MATCH_SCORE
    FROM CLAIMS C
    JOIN USERS U ON C.CLAIMANT_ID = U.USER_ID
    JOIN FOUND_ITEMS F ON C.FOUND_ID = F.FOUND_ID
    WHERE C.STATUS = 'PENDING'
    ORDER BY C.CREATED_AT DESC;
    RETURN v_cursor;
END;
/

CREATE OR REPLACE PROCEDURE SP_PROCESS_CLAIM (
    p_claim_id IN NUMBER,
    p_status IN VARCHAR2
) AS
    v_found_id NUMBER;
    v_claimant_id NUMBER;
BEGIN
    UPDATE CLAIMS SET STATUS = p_status WHERE CLAIM_ID = p_claim_id
    RETURNING FOUND_ID, CLAIMANT_ID INTO v_found_id, v_claimant_id;
    
    IF p_status = 'APPROVED' THEN
        UPDATE FOUND_ITEMS SET STATUS = 'CLAIMED' WHERE FOUND_ID = v_found_id;
        
        INSERT INTO NOTIFICATIONS (USER_ID, MESSAGE)
        VALUES (v_claimant_id, 'Your claim has been approved.');
    ELSIF p_status = 'REJECTED' THEN
        INSERT INTO NOTIFICATIONS (USER_ID, MESSAGE)
        VALUES (v_claimant_id, 'Your claim has been rejected.');
    END IF;
    
    COMMIT;
END;
/

-- Update and Delete Lost Items

CREATE OR REPLACE PROCEDURE SP_UPDATE_LOST_ITEM (
    p_lost_id IN NUMBER,
    p_user_id IN NUMBER,
    p_item_name IN VARCHAR2,
    p_category IN VARCHAR2,
    p_color IN VARCHAR2,
    p_description IN VARCHAR2,
    p_location IN VARCHAR2
) AS
BEGIN
    UPDATE LOST_ITEMS
    SET ITEM_NAME = p_item_name,
        CATEGORY = p_category,
        COLOR = p_color,
        DESCRIPTION = p_description,
        LOST_LOCATION = p_location
    WHERE LOST_ID = p_lost_id AND USER_ID = p_user_id;
    COMMIT;
END;
/

CREATE OR REPLACE PROCEDURE SP_DELETE_LOST_ITEM (
    p_lost_id IN NUMBER,
    p_user_id IN NUMBER
) AS
BEGIN
    DELETE FROM MATCHES WHERE LOST_ID = p_lost_id;
    DELETE FROM LOST_ITEMS WHERE LOST_ID = p_lost_id AND USER_ID = p_user_id;
    COMMIT;
END;
/

-- Profile Management

-- (Run this ALTER TABLE once to update the schema)
-- ALTER TABLE USERS ADD (PHONE VARCHAR2(20), DEPARTMENT VARCHAR2(50));

CREATE OR REPLACE FUNCTION FN_GET_USER_PROFILE (
    p_user_id IN NUMBER
) RETURN SYS_REFCURSOR AS
    v_cursor SYS_REFCURSOR;
BEGIN
    OPEN v_cursor FOR
    SELECT USER_ID, FULL_NAME, STUDENT_ID, EMAIL, ROLE, PHONE, DEPARTMENT, CREATED_AT
    FROM USERS
    WHERE USER_ID = p_user_id;
    RETURN v_cursor;
END;
/

CREATE OR REPLACE PROCEDURE SP_UPDATE_USER_PROFILE (
    p_user_id IN NUMBER,
    p_full_name IN VARCHAR2,
    p_phone IN VARCHAR2,
    p_department IN VARCHAR2
) AS
BEGIN
    UPDATE USERS
    SET FULL_NAME = p_full_name,
        PHONE = p_phone,
        DEPARTMENT = p_department
    WHERE USER_ID = p_user_id;
    COMMIT;
END;
/

-- Notifications

CREATE OR REPLACE FUNCTION FN_GET_USER_NOTIFICATIONS (
    p_user_id IN NUMBER
) RETURN SYS_REFCURSOR AS
    v_cursor SYS_REFCURSOR;
BEGIN
    OPEN v_cursor FOR
    SELECT NOTIFICATION_ID, MESSAGE, IS_READ, CREATED_AT
    FROM NOTIFICATIONS
    WHERE USER_ID = p_user_id
    ORDER BY CREATED_AT DESC;
    RETURN v_cursor;
END;
/

