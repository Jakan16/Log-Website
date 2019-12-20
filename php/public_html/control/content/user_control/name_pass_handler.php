<?php
/* Sandsized CMS - By Guld-berg.dk software technologies
*  Developed by Jørn Guldberg
*  Copyright (C) Jørn Guldberg - Guld-berg.dk All Rights Reserved. 
*/
$page_permission = 2; // all users are alloud to change their password
require_once $_SERVER['DOCUMENT_ROOT']."/core/system_core.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ok = true;
    $post_id = clean_input_text($_POST["id"]);   
    $post_handel = clean_input_text($_POST["handel"]); // The value of the button preesed
    
    try {
        // switches between the qureies controled by the value of which button is pressed
        switch ($post_handel) {
            case 'name':
                $_SESSION["new_username"] = clean_input_text($_POST["username"]); // The username 
                $post_pass_confirm = clean_input_text($_POST["password"]); // The users old password, to confirm the right user
                        // Her tjekkes det om der er skrevet noget i brugernavnet og passwordet
                if (!empty($_SESSION["new_username"]) && !empty($post_pass_confirm)) {
                    // Hvis der findes en bruger i systemet med login navnet findes de forskellige oplysninger om brugeren.
                    $check_username_confirm = username_check($_SESSION['login_user']);
                    $check_password_confirm = password_crypt($post_pass_confirm, $check_username_confirm);

                    $check_username_new = username_check($_SESSION["new_username"]);
                    $check_password_new = password_crypt($post_pass_confirm, $check_username_new);

                    $conn = get_db_connection(MAIN_DB_HOST, MAIN_DB_DATABASE_NAME, MAIN_DB_USER, MAIN_DB_PASS);

                    $stmt_check = $conn->prepare("SELECT id, active FROM ".MAIN_DB_PREFIX."users WHERE username_clean = ? AND password = ?;");
                    $stmt_check->execute(array($check_username_confirm, $check_password_confirm ));
                    if ($stmt_check->rowCount() == 1) {
                        foreach($stmt_check->fetchAll() as $row) {
                            if ($row['active'] == 1) {
                                // if the user exist and the password is right
                                $stmt = $conn->prepare("UPDATE ".MAIN_DB_PREFIX."users SET username = ?, username_clean = ?, password = ? WHERE id = ?;");
                                $stmt->execute(array($_SESSION["new_username"], $check_username_new, $check_password_new, $row['id']));
                                $_SESSION['login_user'] = $_SESSION["new_username"];
                            }
                            else {
                                $_SESSION["change_username_feedback"] = '<span style="color:red;"><b>Din bruger er deaktiveret </b></span>';
                                $ok = false;
                            }
                        }
                    } 
                    else if ($stmt_check->rowCount() > 1) {
                        throw new Exception('Der er sket en fejl, kontakt straks personen der har sat siden op');
                    }
                    else {
                        $_SESSION["change_username_feedback"] = '<span style="color:red;"><b>Du har skrevet forkert password </b></span>';
                        $ok = false;
                    }

                    $stmt = null;
                    $conn = null;
                }
                else {
                    $_SESSION["change_username_feedback"] = '<span style="color:red;"><b>Du skal udfylde begge felter</b></span>';
                    $ok = false;
                }
                
                break;
            case 'pass':
                $post_pass_confirm = clean_input_text($_POST["password"]); 
                $post_pass_new = clean_input_text($_POST["new_pass"]); 
                $post_pass_new_repeated = clean_input_text($_POST["rep_pass"]);
                        // Her tjekkes det om der er skrevet noget i brugernavnet og passwordet
                if (!empty($post_pass_new) && !empty($post_pass_confirm) && !empty($post_pass_new_repeated)) {
                    if ($post_pass_new == $post_pass_new_repeated) {
                        // Hvis der findes en bruger i systemet med login navnet findes de forskellige oplysninger om brugeren.
                        $check_username_confirm = username_check($_SESSION['login_user']);
                        $check_password_confirm = password_crypt($post_pass_confirm, $check_username_confirm);

                        $check_password_new = password_crypt($post_pass_new, $check_username_confirm);

                        $conn = get_db_connection(MAIN_DB_HOST, MAIN_DB_DATABASE_NAME, MAIN_DB_USER, MAIN_DB_PASS);

                        $stmt_check = $conn->prepare("SELECT id, active FROM ".MAIN_DB_PREFIX."users WHERE username_clean = ? AND password = ?;");
                        $stmt_check->execute(array($check_username_confirm, $check_password_confirm ));
                        if ($stmt_check->rowCount() == 1) {
                            foreach($stmt_check->fetchAll() as $row) {
                                if ($row['active'] == 1) {
                                    // if the user exist and the password is right
                                    $stmt = $conn->prepare("UPDATE ".MAIN_DB_PREFIX."users SET password = ? WHERE id = ?;");
                                    $stmt->execute(array($check_password_new, $row['id']));
                                }
                                else {
                                    $_SESSION["change_password_feedback"] = '<span style="color:red;"><b>Din bruger er deaktiveret </b></span>';
                                    $ok = false;
                                }
                            }
                        } 
                        else if ($stmt_check->rowCount() > 1) {
                            throw new Exception('Der er sket en fejl, kontakt straks personen der har sat siden op');
                        }
                        else {
                            $_SESSION["change_password_feedback"] = '<span style="color:red;"><b>Du har skrevet forkert password </b></span>';
                            $ok = false;
                        }

                        $stmt = null;
                        $conn = null;
                    }
                    else {
                        $_SESSION["change_password_feedback"] = '<span style="color:red;"><b>Passwords er ikke ens</b></span>';
                        $ok = false;
                    }
                }
                else {
                    $_SESSION["change_password_feedback"] = '<span style="color:red;"><b>Du skal udfylde alle felter</b></span>';
                    $ok = false;
                }
                
                break;

            default:
                // code...
                break;
        }
        if ($ok) {
            $_SESSION["uploade_feedback"] = '<div class="row">
            <div class="col-sm-8 alert alert-success">
            <strong>SUCCESS</strong> Handlingen er gennemført
            </div>
            <div class="col-sm-4"></div>
            </div>';
        }

        header("location: /control/user_control");

    }
    catch(PDOException $e) {
        $_SESSION["uploade_feedback"] = '<div class="row">
        <div class="col-sm-8 alert alert-danger">
        <strong>ERROR</strong> Der skete en fejl '.$e.'
        </div>
        <div class="col-sm-4"></div>
        </div>';
        header("location: /control/user_control");
    }
}
else {
    header("location: /");
}

?>
