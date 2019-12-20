<?php
/* Sandsized CMS - By Guld-berg.dk software technologies
*  Developed by Jørn Guldberg
*  Copyright (C) Jørn Guldberg - Guld-berg.dk All Rights Reserved. 
*/
$page_permission = 1; // Only admins
require_once $_SERVER['DOCUMENT_ROOT']."/core/system_core.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post_id = clean_input_text($_POST["id"]);   
    $post_handel = clean_input_text($_POST["handel"]); // The value of the button preesed
    
    try {
        // switches between the qureies controled by the value of which button is pressed
        switch ($post_handel) {
            case 'admin':
                
                $conn = get_db_connection(MAIN_DB_HOST, MAIN_DB_DATABASE_NAME, MAIN_DB_USER, MAIN_DB_PASS);
                $stmt = $conn->prepare("UPDATE ".MAIN_DB_PREFIX."users SET permission_list = 'a:1:{i:0;i:1;}' WHERE id = ?;");
                $stmt->execute(array($post_id));
                $stmt2 = $conn->prepare("INSERT INTO ".MAIN_DB_PREFIX."admin_info (id, priority) VALUES(?, ?);");  
                $stmt2->execute(array($post_id, $post_id));
                $stmt = null;
                $stmt2 = null;
                $conn = null;
                break;

            case 'noadmin':
                
                $conn = get_db_connection(MAIN_DB_HOST, MAIN_DB_DATABASE_NAME, MAIN_DB_USER, MAIN_DB_PASS);
                $stmt = $conn->prepare("UPDATE ".MAIN_DB_PREFIX."users SET permission_list = 'a:1:{i:0;i:2;}' WHERE id = ? ;");
                $stmt->execute(array($post_id));
                $stmt2 = $conn->prepare("DELETE FROM ".MAIN_DB_PREFIX."admin_info WHERE id = ?;");
                $stmt2->execute(array($post_id));
                $stmt = null;
                $stmt2 = null;
                $conn = null;
                break;

            case 'deactivate':
                
                $conn = get_db_connection(MAIN_DB_HOST, MAIN_DB_DATABASE_NAME, MAIN_DB_USER, MAIN_DB_PASS);
                $stmt = $conn->prepare("UPDATE ".MAIN_DB_PREFIX."users SET active = 0 WHERE id = ? ;");
                $stmt->execute(array($post_id));
                $stmt = null;
                $conn = null;
                break;

            case 'activate':
                
                $conn = get_db_connection(MAIN_DB_HOST, MAIN_DB_DATABASE_NAME, MAIN_DB_USER, MAIN_DB_PASS);
                $stmt = $conn->prepare("UPDATE ".MAIN_DB_PREFIX."users SET active = 1 WHERE id = ? ;");
                $stmt->execute(array($post_id));
                $stmt = null;
                $conn = null;
                break;

            case 'delete':
                
                $conn = get_db_connection(MAIN_DB_HOST, MAIN_DB_DATABASE_NAME, MAIN_DB_USER, MAIN_DB_PASS);
                $stmt = $conn->prepare("DELETE FROM ".MAIN_DB_PREFIX."users WHERE id = ? ;
                                        DELETE FROM ".MAIN_DB_PREFIX."user_info WHERE id = ?;
                                        DELETE FROM ".MAIN_DB_PREFIX."admin_info WHERE id = ?;");
                $stmt->execute(array($post_id, $post_id, $post_id));
                $stmt = null;
                $conn = null;
                break;

            default:
                // code...
                break;
        }

        $_SESSION["uploade_feedback"] = '<div class="row">
        <div class="col-sm-8 alert alert-success">
        <strong>SUCCESS</strong> Handlingen er gennemført
        </div>
        <div class="col-sm-4"></div>
        </div>';
        header("location: /control/master_control");

    }
    catch(PDOException $e) {
        $_SESSION["uploade_feedback"] = '<div class="row">
        <div class="col-sm-8 alert alert-danger">
        <strong>ERROR</strong> Der skete en fejl '.$e.'
        </div>
        <div class="col-sm-4"></div>
        </div>';
        header("location: /control/master_control");
    }
}
else {
    header("location: /");
}
?>
