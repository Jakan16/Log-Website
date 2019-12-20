<?php
/* Sandsized CMS - By Guld-berg.dk software technologies
*  Developed by Jørn Guldberg
*  Copyright (C) Jørn Guldberg - Guld-berg.dk All Rights Reserved. 
*/

include $_SERVER['DOCUMENT_ROOT']."/core/system_core.php"; // kernel
include $_SERVER['DOCUMENT_ROOT']."/core/validation_functions.php"; // validation functions used to validate the input

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $post_pass_new = clean_input_text($_POST["new_pass"]); 
    $post_pass_new_repeated = clean_input_text($_POST["rep_pass"]);
            // Her tjekkes det om der er skrevet noget i brugernavnet og passwordet
    if (!empty($post_pass_new) && !empty($post_pass_new_repeated)) {
        if ($post_pass_new == $post_pass_new_repeated) {
            // Just to be sure that the session mail saved i a vilid mail
            list($ok, $_SESSION["recover_mail"], $_SESSION["recover_mail_Err"]) = validate_email($_SESSION["recover_mail"]);
            if ($ok) {
                $check_username_clean = username_check($_SESSION["recover_username"]);
                $check_password_new = password_crypt($post_pass_new, $check_username_clean);

                $conn = get_db_connection(MAIN_DB_HOST, MAIN_DB_DATABASE_NAME, MAIN_DB_USER, MAIN_DB_PASS);
                // if the user exist and the password is right
                $stmt = $conn->prepare("UPDATE ".MAIN_DB_PREFIX."users SET password = ? WHERE username_clean = ? AND mail = ? AND recoverycode = ?;");
                $stmt->execute(array($check_password_new, $check_username_clean, $_SESSION["recover_mail"], $_SESSION["recover_input_code"]));
                if ($stmt->rowCount() == 1) {
                    $stmt_set = $conn->prepare("UPDATE ".MAIN_DB_PREFIX."users SET recoverycode = '', recoverytime = '' WHERE username_clean = ? AND mail = ? AND recoverycode = ?;");
                    $stmt_set->execute(array($check_username_clean, $_SESSION["recover_mail"], $_SESSION["recover_input_code"]));
                    $stmt_set = null;

                    //Email is sent to global_contact_mail
                    $to = $subject = $message = $headers = "";
            
                    $to = $_SESSION["recover_mail"];
                    $subject = "Dit password er blevet ændret - " . GLOBAL_FIRM_NAME; 
                    $message = '
                    <html>
                    <head>
                    <title>Dit password er blevet ændret- ' . GLOBAL_FIRM_NAME .'</title>
                    </head>
                    <body style="font-family:Helvetica Neue, Helvetica, Arial, sans-serif;">
                        Hej '.$_SESSION["recover_username"].'<br>
                        <br>
                        Dit password på vores side er blevet ændret. <br>
                        Hvis det ikke er dig der har gjort dette, kontakt os staks på <br>
                        '.GLOBAL_CONTACT_EMAIL.'<br>
                        <br>
                        Med Venlig Hilsen<br>
                        '.GLOBAL_FIRM_NAME.'

                    </body>
                    </html>';
                    
                    // Always set content-type when sending HTML email
                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                        
                    // More headers
                    $headers .= 'From: <'.GLOBAL_CONTACT_EMAIL.'>' . "\r\n";
                    mail($to, '=?utf-8?B?'.base64_encode($subject).'?=', $message, $headers); // =?utf-8?B?'.base64_encode($subject) Set the subject to contain utf-8 charset so that the subject can contain the danish æøå
                    $_SESSION["feedback_recover"] = '<div class="row">
                    <div class="col-sm-12 alert alert-success"><b>Password opdateret</b> <br> 
                    Du kan nu logge ind med det nye password
                    </div>
                    </div>';
                    unset($_SESSION["recover_username"]);
                    unset($_SESSION["recover_input_code"]);
                    unset($_SESSION["recover_mail"]);
                    unset($_SESSION["recover_step"]);

                }
                else {
                    $_SESSION["change_password_feedback"] = '<span style="color:red;"><b>Der er sket en fejl, kontakt en adminstrator</b></span>';

                }

                $stmt = null;
                $conn = null;
            }
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
    header("location: /user-recovery");
} 
else {
    header("location: /");
}
?>