<?php
include $_SERVER['DOCUMENT_ROOT']."/core/system_core.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (strtotime("+ 1 sec") > $_SESSION["contact_send-time"]) {
        $ok = true;
        if (empty($_POST["mail"])) {
            $ok = false;
            $_SESSION['contact_mail_Err'] = "<b>$lang_data_must_be_filled</b>";
        }
        else {
            $_SESSION['contact_mail'] = $data_customer_email = clean_input_text($_POST["mail"]);
            if (strlen($data_customer_email)<64){
                // check if e-mail address is well-formed
                if (!filter_var($data_customer_email, FILTER_VALIDATE_EMAIL)) {
                    $_SESSION['contact_mail'] = $data_customer_email;
                    $_SESSION['contact_mail_Err'] = $lang_data_input_not_valid_mail;
                    $ok = false;
                }
            }
            else {
                $ok = false;
                $_SESSION['contact_mail'] = $data_customer_email;
                $_SESSION['contact_mail_Err'] = "<b>$lang_data_input_to_long 64 </b>";
            }
       }
        if (empty(clean_input_text($_POST["name"]))) {
                $_SESSION["contact_name_Err"] = "<b>$lang_data_must_be_filled</b>";
                $ok = false;
            } 
            else {
                $contact_name = $_SESSION["contact_name"] = clean_input_text($_POST["name"]);
           }
        if (empty(clean_input_text($_POST["comment"]))) {
                $_SESSION["contact_comment_Err"] = "<b>$lang_data_must_be_filled</b>";
                $ok = false;
            } 
            else {
                $contact_comment = $_SESSION["contact_comment"] = clean_input_text($_POST["comment"]);
           }
        if($ok) {
            //Email is sent to info@vinylmusix.com
            $to = $subject = $message = $headers = "";
    
            $to = GLOBAL_CONTACT_EMAIL;
            $subject = "Besked fra kontakt formular på " . GLOBAL_FIRM_NAME; 
            $message = '
            <html>
            <head>
            <title>Besked fra kontakt formular på '.GLOBAL_FIRM_NAME.'</title>
            </head>
            <body style="font-family:Helvetica Neue, Helvetica, Arial, sans-serif;">
            Beskeden er sendt af: '.$contact_name.'<br>
            E-mail: '.$data_customer_email.'
            <br>
            Vedkommende har skrevet: <br>
            '.$contact_comment.'
            </body>
            </html>
            ';
            
            // Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            
            // More headers
            $headers .= 'From: <'.$data_customer_email.'>' . "\r\n";
            mail($to, '=?utf-8?B?'.base64_encode($subject).'?=', $message, $headers); // =?utf-8?B?'.base64_encode($subject) Set the subject to contain utf-8 charset so that the subject can contain the danish æøå
            $_SESSION["contact_send-time"] = strtotime("+ 10 sec");
            $_SESSION["contact_send"] = '<div class="row">
                <div class="col-sm-12 alert alert-success">'.$lang_data_msg_is_sent.'
                </div>
                </div>';
            unset($_SESSION["contact_mail"]);
            unset($_SESSION["contact_name"]);
            unset($_SESSION["contact_comment"]);
        }
    }
    else {
        $_SESSION["contact_mail"] = clean_input_text($_POST["mail"]);
        $_SESSION["contact_name"] = clean_input_text($_POST["name"]);
        $_SESSION["contact_comment"] = clean_input_text($_POST["comment"]);
        $_SESSION["contact_send"] = '<div class="row">
        <div class="col-sm-12 alert alert-danger">'.$lang_data_msg_not_sent.'
        </div>
        </div>';
    }
    header("location: /kontakt");
} 
else {
    header("location: /index");
}
?>