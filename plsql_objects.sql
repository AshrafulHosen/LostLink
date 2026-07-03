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

-- Matching Triggers

CREATE OR REPLACE TRIGGER TRG_MATCH_ON_LOST_INSERT
AFTER INSERT ON LOST_ITEMS
FOR EACH ROW
DECLARE
    v_found_id NUMBER;
    v_user_id NUMBER;
    CURSOR c_matches IS
        SELECT FOUND_ID, USER_ID FROM FOUND_ITEMS
        WHERE CATEGORY = :NEW.CATEGORY AND COLOR = :NEW.COLOR AND STATUS = 'UNCLAIMED';
BEGIN
    FOR r IN c_matches LOOP
        INSERT INTO MATCHES (LOST_ID, FOUND_ID, MATCH_SCORE)
        VALUES (:NEW.LOST_ID, r.FOUND_ID, 100);
        
        -- Notify the user who lost the item
        INSERT INTO NOTIFICATIONS (USER_ID, MESSAGE)
        VALUES (:NEW.USER_ID, 'A potential match has been found for your lost item: ' || :NEW.ITEM_NAME);
    END LOOP;
END;
/

CREATE OR REPLACE TRIGGER TRG_MATCH_ON_FOUND_INSERT
AFTER INSERT ON FOUND_ITEMS
FOR EACH ROW
DECLARE
    v_lost_id NUMBER;
    v_user_id NUMBER;
    CURSOR c_matches IS
        SELECT LOST_ID, USER_ID, ITEM_NAME FROM LOST_ITEMS
        WHERE CATEGORY = :NEW.CATEGORY AND COLOR = :NEW.COLOR AND STATUS = 'ACTIVE';
BEGIN
    FOR r IN c_matches LOOP
        INSERT INTO MATCHES (LOST_ID, FOUND_ID, MATCH_SCORE)
        VALUES (r.LOST_ID, :NEW.FOUND_ID, 100);
        
        -- Notify the user who lost the item
        INSERT INTO NOTIFICATIONS (USER_ID, MESSAGE)
        VALUES (r.USER_ID, 'A potential match has been found for your lost item: ' || r.ITEM_NAME);
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
