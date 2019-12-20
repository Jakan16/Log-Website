<?php
/** Sandsized CMS - By Guld-berg.dk software technologies
*  Developed by Jørn Guldberg
*  Copyright (C) Jørn Guldberg - Guld-berg.dk All Rights Reserved. 
*  Version 6.1.1: Release of major, not compatiple with earlier realises. 
*  Full release-notes se the git repository
*/

$page_permission = 1; // only admins
require_once $_SERVER['DOCUMENT_ROOT']."/core/system_core.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post_id = clean_input_text($_POST["id"]);
    $post_parent_id = clean_input_text($_POST["parent_id"]);
    $post_page_name = clean_input_text($_POST["page_name"]);
    $post_handel = clean_input_text($_POST["handel"]); // The value of the button preesed
    $post_navi_order = clean_input_text($_POST["navi_order"]);
    $post_link = clean_input_text($_POST["link"]);
    $post_add = clean_input_text($_POST["add"]);
    
    try {
        if ($post_add == '1') {
            /*
                Create a new page and put it in the menu. 
            */
            $new_post_page_name_link = rawurlencode(str_replace(" ", "_",$post_page_name));
            $conn = get_db_connection(MAIN_DB_HOST, MAIN_DB_DATABASE_NAME, MAIN_DB_USER, MAIN_DB_PASS);
            $stmt = $conn->prepare("SELECT @order_id := (1 + max(navi_order)) FROM ".MAIN_DB_PREFIX."navi WHERE place='standart';
                INSERT INTO ".MAIN_DB_PREFIX."navi (link, navi_order, permission, place) VALUES (?, @order_id, 0, 'standart');
                SELECT @parrent := id FROM ".MAIN_DB_PREFIX."navi WHERE link = ?;
                INSERT INTO ".MAIN_DB_PREFIX."navi_name (name, language, parent_id) VALUES (?, 'DK', @parrent);
                INSERT INTO ".MAIN_DB_PREFIX."text (language, parent_id, text, required, content_group) VALUES ('DK', @parrent, ?, 0, 'page');");
            $stmt->execute(array($new_post_page_name_link, $new_post_page_name_link, $post_page_name, $post_page_name));
            $stmt = null;
            $conn = null;
            
        }
        else {
            if ($post_handel == "mv_up") {
                $conn = get_db_connection(MAIN_DB_HOST, MAIN_DB_DATABASE_NAME, MAIN_DB_USER, MAIN_DB_PASS);
                $stmt = $conn->prepare("UPDATE ".MAIN_DB_PREFIX."navi SET navi_order = navi_order + 1 WHERE navi_order = ? AND place ='standart';
                                        UPDATE ".MAIN_DB_PREFIX."navi SET navi_order = navi_order - 1 WHERE link = ? AND place ='standart';");
                $stmt->execute(array(($post_navi_order - 1), $post_link));
                $stmt = null;
                $conn = null;
            }
            else if ($post_handel == "mv_dw") {
                $conn = get_db_connection(MAIN_DB_HOST, MAIN_DB_DATABASE_NAME, MAIN_DB_USER, MAIN_DB_PASS);
                $stmt = $conn->prepare("UPDATE ".MAIN_DB_PREFIX."navi SET navi_order = navi_order - 1  WHERE navi_order = ?;
                                        UPDATE ".MAIN_DB_PREFIX."navi SET navi_order = navi_order + 1 WHERE link = ?;");
                $stmt->execute(array(($post_navi_order + 1), $post_link));
                $stmt = null;
                $conn = null;
            }
            else if ($post_handel == "activate") 
            {
                $conn = get_db_connection(MAIN_DB_HOST, MAIN_DB_DATABASE_NAME, MAIN_DB_USER, MAIN_DB_PASS);
                $stmt = $conn->prepare("UPDATE ".MAIN_DB_PREFIX."navi SET permission = 0 WHERE id = ?;");
                $stmt->execute(array($post_parent_id));
                $stmt = null;
                $conn = null;
            }
            else if ($post_handel == "deactivate") 
            {
                $conn = get_db_connection(MAIN_DB_HOST, MAIN_DB_DATABASE_NAME, MAIN_DB_USER, MAIN_DB_PASS);
                $stmt = $conn->prepare("UPDATE ".MAIN_DB_PREFIX."navi SET permission = 1 WHERE id = ?;");
                $stmt->execute(array($post_parent_id));
                $stmt = null;
                $conn = null;
            }
            else if ($post_handel == "rm") {
                // Check if there is submenus, and place them in the standard menu: 
                $conn_hq = get_db_connection(MAIN_DB_HOST, MAIN_DB_DATABASE_NAME, MAIN_DB_USER, MAIN_DB_PASS);
                $stmt_hq = $conn_hq->prepare("SELECT name FROM ".MAIN_DB_PREFIX."navi_name WHERE parent_id = :id;");
                $stmt_hq->bindParam(':id', $post_parent_id, PDO::PARAM_INT);
                $stmt_hq->execute();
                if ($stmt_hq->rowCount() > 0) {
                  $result_hq = $stmt_hq->setFetchMode(PDO::FETCH_ASSOC);
                  foreach($stmt_hq->fetchAll() as $row_hq) {
                        $stmt_next = $conn_hq->prepare("UPDATE ".MAIN_DB_PREFIX."navi SET place = 'standart' WHERE place = ?;");
                        $stmt_next->execute(array($row_hq['name']));
                        $stmt_next = null;
                    }
                }

                $conn = get_db_connection(MAIN_DB_HOST, MAIN_DB_DATABASE_NAME, MAIN_DB_USER, MAIN_DB_PASS);
                $stmt = $conn->prepare("DELETE FROM ".MAIN_DB_PREFIX."navi WHERE link = ? AND required = 0;
                                        DELETE FROM ".MAIN_DB_PREFIX."text WHERE parent_id = ? AND content_group = 'page';
                                        DELETE FROM ".MAIN_DB_PREFIX."navi_name WHERE parent_id = ?;");
                $stmt->execute(array($post_link, $post_parent_id, $post_parent_id));
                
                $stmt = null;

                $stmt2 = $conn->prepare("SELECT * FROM ".MAIN_DB_PREFIX."images WHERE attached_group = 'page' AND attached_id = ?;");
                $stmt2->execute(array($post_parent_id));
                    // set the resulting array to associative
                if ($stmt2->rowCount() > 0) {
                    $result = $stmt2->setFetchMode(PDO::FETCH_ASSOC);
                    foreach($stmt2->fetchAll() as $row) {
                        unlink($_SERVER['DOCUMENT_ROOT']. '/' .$row['dir']); 
                    }
                } 

                $stmt2 = null;

                $stmt3 = $conn->prepare("DELETE FROM ".MAIN_DB_PREFIX."images WHERE attached_group = 'page' AND attached_id = ?;");
                $stmt3->execute(array($post_parent_id));

                $stmt3 = null;
                $conn = null;
            }
            else if ($post_handel == "edit") {
                $conn = get_db_connection(MAIN_DB_HOST, MAIN_DB_DATABASE_NAME, MAIN_DB_USER, MAIN_DB_PASS);
                $stmt = $conn->prepare("UPDATE ".MAIN_DB_PREFIX."navi SET name = ? WHERE id = ?;");
                $stmt->execute(array($post_page_name, $post_id));
                $stmt = null;
                $conn = null;
            }
        }
        $_SESSION["uploade_feedback"] = '<div class="row">
        <div class="col-sm-12 alert alert-success">
        <strong>SUCCESS</strong> Handlingen er gennemført
        </div>
        </div>';
        header("location: /control/master_control");

    }
    catch(PDOException $e) {
        $_SESSION["uploade_feedback"] = '<div class="row">
        <div class="col-sm-12 alert alert-danger">
        <strong>ERROR</strong> Der skete en fejl '.$e.'
        </div>
        </div>';
        header("location: /control/master_control");
    }
}
else {
    header("location: /");
}
?>
