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
    $post_post_id = clean_input_text($_POST["id"]);
    $post_handel = clean_input_text($_POST["handel"]);

    if ($post_handel != "edit") {
        try {
            if ($post_handel == "mv_up") {
                $conn = get_db_connection(MAIN_DB_HOST, MAIN_DB_DATABASE_NAME, MAIN_DB_USER, MAIN_DB_PASS);
                $stmt = $conn->prepare("SELECT @target_order := (SELECT orders FROM ".MAIN_DB_PREFIX."post WHERE id = ?);
                                        SELECT @target_order_2 := (SELECT orders FROM ".MAIN_DB_PREFIX."post WHERE orders > @target_order ORDER BY orders LIMIT 1);
                                        SELECT @target_order_2_id := (SELECT id FROM ".MAIN_DB_PREFIX."post WHERE orders > @target_order ORDER BY orders LIMIT 1);
                                        UPDATE ".MAIN_DB_PREFIX."post SET orders = @target_order_2 WHERE id = ?;
                                        UPDATE ".MAIN_DB_PREFIX."post SET orders = @target_order WHERE id = @target_order_2_id;");
                $stmt->execute(array($post_post_id, $post_post_id));
                $stmt = null;
                $conn = null;
            }
            else if ($post_handel == "mv_dw") {
                $conn = get_db_connection(MAIN_DB_HOST, MAIN_DB_DATABASE_NAME, MAIN_DB_USER, MAIN_DB_PASS);
                $stmt = $conn->prepare("SELECT @target_order := (SELECT orders FROM ".MAIN_DB_PREFIX."post WHERE id = ?);
                                        SELECT @target_order_2 := (SELECT orders FROM ".MAIN_DB_PREFIX."post WHERE orders < @target_order ORDER BY orders DESC LIMIT 1);
                                        SELECT @target_order_2_id := (SELECT id FROM ".MAIN_DB_PREFIX."post WHERE orders < @target_order ORDER BY orders DESC LIMIT 1);
                                        UPDATE ".MAIN_DB_PREFIX."post SET orders = @target_order_2 WHERE id = ?;
                                        UPDATE ".MAIN_DB_PREFIX."post SET orders = @target_order WHERE id = @target_order_2_id;");
                $stmt->execute(array($post_post_id, $post_post_id));
                $stmt = null;
                $conn = null;
            }
            else if ($post_handel == "rm") {
                $conn = get_db_connection(MAIN_DB_HOST, MAIN_DB_DATABASE_NAME, MAIN_DB_USER, MAIN_DB_PASS);
                $stmt = $conn->prepare("DELETE FROM ".MAIN_DB_PREFIX."post WHERE id = ?;");
                $stmt->execute(array($post_post_id));

                $stmt2 = $conn->prepare("SELECT * FROM ".MAIN_DB_PREFIX."images WHERE attached_group = 'post' AND attached_id = ?;");
                $stmt2->execute(array($post_post_id));
                    // set the resulting array to associative
                if ($stmt2->rowCount() > 0) {
                    $result = $stmt2->setFetchMode(PDO::FETCH_ASSOC);
                    foreach($stmt2->fetchAll() as $row) {
                        unlink($_SERVER['DOCUMENT_ROOT']. '/' .$row['dir']); 
                    }
                } 

                $stmt3 = $conn->prepare("DELETE FROM ".MAIN_DB_PREFIX."images WHERE attached_group = 'post' AND attached_id = ?;");
                $stmt3->execute(array($post_post_id));
            }

            $_SESSION["uploade_feedback"] = '<div class="row">
            <div class="col-sm-12 alert alert-success">
            <strong>SUCCESS</strong> Handlingen er gennemført
            </div>
            </div>';
            
            header("location: /page");
            
            $stmt = null;
            $stmt2 = null;
            $stmt3 = null;
            $conn = null;
        }
        catch(PDOException $e) {
            $_SESSION["uploade_feedback"] = '<div class="row">
            <div class="col-sm-12 alert alert-danger">
            <strong>ERROR</strong> Der skete en fejl
            </div>
            </div>';
            header("location: /page");
        }
    }
    else {
        header("location: /page");
    }
}
else {
    header("location: /");
}

?>