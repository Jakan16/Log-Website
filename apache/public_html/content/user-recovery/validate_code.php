<?php
/** Sandsized CMS - By Guld-berg.dk software technologies
*  Developed by Jørn Guldberg
*  Copyright (C) Jørn Guldberg - Guld-berg.dk All Rights Reserved. 
*  Version 6.1.1: Release of major, not compatiple with earlier realises. 
*  Full release-notes se the git repository
*/

require_once $_SERVER['DOCUMENT_ROOT']."/core/system_core.php"; // kernel
require_once $_SERVER['DOCUMENT_ROOT']."/core/validation_functions.php"; // validation functions used to validate the input


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (time() > $_SESSION["recovery_try_time"]) {
        $_SESSION["recovery_try_time"] = time() + 3; // ony one request pr 5 second
        $ok = true;
        // Just to be sure that the session mail saved i a vilid mail
        list($ok, $_SESSION["recover_mail"], $_SESSION["recover_mail_Err"]) = validate_email($_SESSION["recover_mail"]);
        
        if($ok) {
            $user_found = true;
            $user_active = true;
            $temp_error = false;
            $recovercode_string = '';
            $contact_name = '';
            $_SESSION["recover_input_code"] = clean_input_text($_POST["recover_code"]);
            try {
                $conn = get_db_connection(MAIN_DB_HOST, MAIN_DB_DATABASE_NAME, MAIN_DB_USER, MAIN_DB_PASS);
                $stmt = $conn->prepare("SELECT id, active, username, recoverytime FROM ".MAIN_DB_PREFIX."users WHERE mail = ? AND recoverycode = ? ; ");
                $stmt->execute(array($_SESSION["recover_mail"], $_SESSION["recover_input_code"]));
                if ($stmt->rowCount() == 1) {
                    foreach($stmt->fetchAll() as $row) {
                        if ($row['active'] == 1) {
                            if ($row['recoverytime'] > time()) {
                                $_SESSION["recover_username"] = $row['username'];
                                $_SESSION["feedback_recover"] = '<div class="row">
                                <div class="col-sm-12 alert alert-success"><b>Koden er godkendt</b> <br> 
                                Du kan nu lave et nyt password.
                                </div>
                                </div>';
                                $_SESSION["recover_step"] = 2;
                                
                            }
                            else {
                                $stmt_set = $conn->prepare("UPDATE ".MAIN_DB_PREFIX."users SET recoverycode = '', recoverytime = '' WHERE id = ? ");
                                $stmt_set->execute(array($row['id']));
                                $stmt_set = null;
                                $_SESSION["feedback_recover"] = '<div class="row">
                                <div class="col-sm-12 alert alert-danger"><b>Din recovery-kode er udløbet</b> <br> 
                                Få en ny ved at indtaste din mail og trykke fortsæt.
                                </div>
                                </div>';
                                // reset the recoverycode and time, so it's no longer possible to use the code
                                $_SESSION["recover_step"] = 1;
                            }
                        }
                        else {
                            $_SESSION["feedback_recover"] = '<div class="row">
                            <div class="col-sm-12 alert alert-danger"><b>Din bruger er deaktiveret</b> <br> 
                            Kontakt en adminstrator på siden.
                            </div>
                            </div>';
                            $_SESSION["recover_step"] = 1;
                        }
                    }
                } 
                else {
                    $_SESSION["feedback_recover"] = '<div class="row">
                    <div class="col-sm-12 alert alert-danger"><b>Den indtastede kode er ikke korrekt</b> <br> 
                    Prøv at indtaste den igen og tryk fortsæt. <br>
                    Ved gentagende fejl, start forfra med at indtaste din mail, eller kontakt en adminstrator på siden. 
                    </div>
                    </div>';
                    $_SESSION["recover_step"] = 1;
                }
            }
            catch(PDOException $e) {
                    $temp_error = true;
            }
            $stmt = null;
            $conn = null;

        }
    }
    else {
        $_SESSION["recover_mail"] = clean_input_text($_POST["mail"]);
        $_SESSION["feedback_recover"] = '<div class="row">
        <div class="col-sm-12 alert alert-danger"> Vent et øjeblik og prøv igen
        </div>
        </div>';
        $_SESSION["recover_step"] = 1;
    }
    header("location: /user-recovery");
} 
else {
    header("location: /");
}
?>