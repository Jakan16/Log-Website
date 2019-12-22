<?php
/** Sandsized CMS - By Guld-berg.dk software technologies
*  Developed by Jørn Guldberg
*  Copyright (C) Jørn Guldberg - Guld-berg.dk All Rights Reserved. 
*  Version 6.1.1: Release of major, not compatiple with earlier realises. 
*  Full release-notes se the git repository
*/

$page_permission = 2; // all users are aloud to use this 
require_once $_SERVER['DOCUMENT_ROOT']."/core/system_core.php";
require_once $_SERVER['DOCUMENT_ROOT']."/core/validation_functions.php"; // validation functions used to validate the input

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ok = true;
    list($ok, $_SESSION["new_user_mail"], $_SESSION["change_mail_feedback"]) = validate_email($_POST["mail"]);
    if ($ok) {
        try {
            $conn = get_db_connection(MAIN_DB_HOST, MAIN_DB_DATABASE_NAME, MAIN_DB_USER, MAIN_DB_PASS);
            $stmt = $conn->prepare("UPDATE ".MAIN_DB_PREFIX."users SET mail = ? WHERE id = ? ;");
            $stmt->execute(array($_SESSION["new_user_mail"], LOGIN_ID));
            $stmt = null;
            $conn = null;

            $_SESSION["uploade_feedback"] = '<div class="row">
            <div class="col-sm-12 alert alert-success">
            <strong>SUCCESS</strong> Handlingen er gennemført
            </div>
            </div>';
            unset($_SESSION["new_user_mail"]);
            unset($_SESSION["change_mail_feedback"]);
            header("location: /control/user_control");

        }
        catch(PDOException $e) {
            $_SESSION["uploade_feedback"] = '<div class="row">
            <div class="col-sm-12 alert alert-danger">
            <strong>ERROR</strong> Der skete en fejl '.$e.'
            </div>
            </div>';
            header("location: /control/user_control");
        } 
    }
    else {
        header("location: /control/user_control");
    }
}
else {
    header("location: /");
}
?>
