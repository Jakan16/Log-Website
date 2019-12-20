<?php
/* Sandsized CMS - By Guld-berg.dk software technologies
*  Developed by Jørn Guldberg
*  Copyright (C) Jørn Guldberg - Guld-berg.dk All Rights Reserved. 
*/
?>
<div class="container GLOBALdesign">
    <div class="row">
        <div class="col-sm-3"></div>
    <div class="col-sm-6">
    <?php
        echo $_SESSION["feedback_recover"];
        unset($_SESSION["feedback_recover"]);
    
        echo '<h2>Glemt password</h2>';

    switch ($_SESSION["recover_step"]) {
        case 1:
            unset($_SESSION["recover_input_code"]);
            echo '<p>
                    Indtast den recovery-kode du har modtaget på din email 
                </p>
                <form action="/content/user-recovery/validate_code" id="forgotForm" onsubmit="return validateContactForm()" method="post">
                    <div class="form-group">
                    <label for="mail">Recovery-kode:</label>
                    <input type="text" class="form-control" name="recover_code" id="recover_code" autocomplete="off">
                    <span id="errMail" style="color:red;">'.$_SESSION["recover_code_Err"].'</span>
                    </div>
                    <button type="submit" class="btn btn-success">Fortsæt</button>
                </form>';
                unset($_SESSION["recover_code_Err"]);
            break;
        case 2:
            echo '<p>
                    Indtast dit nye password og tryk på fortsæt, <br>
                </p>
                <h2>Ændre password:</h2>
                <form name="createForm" action="/content/user-recovery/new_pass" onsubmit="return validateContactForm()" method="post">
                    <div class="form-group">
                    <label for="titel">Indtast nyt password:</label>
                    <input type="password" class="form-control" name="new_pass" id="new_pass">
                    <span id="errUser"></span>
                    </div>
                    <div class="form-group">
                    <label for="titel">Gentag nyt password:</label>
                    <input type="password" class="form-control" name="rep_pass" id="rep_pass">
                    <span id="errUser"></span>
                    </div>
                    '.$_SESSION["change_password_feedback"].'
                    <button type="submit" class="btn btn-default" name="handel" value="pass">Opdater</button>
                </form>';
                unset($_SESSION["change_password_feedback"]);
            break;
        default:
            echo '<p>
                    Indtast den e-mail du har opgivet på siden, <br>
                    og du vil modtage en recovery-kode på mail. 
                    Den skal du indtaste bagefter. 
                </p>
                <form action="/content/user-recovery/get_code" id="forgotForm" onsubmit="return validateContactForm()" method="post">
                    <div class="form-group">
                    <label for="mail">'.$lang_data_mail.':</label>
                    <input type="text" class="form-control" name="mail" id="mail" autocomplete="off" value="'.stripslashes($_SESSION["recover_mail"]).'">
                    <span id="errMail" style="color:red;">'.$_SESSION["recover_mail_Err"].'</span>
                    </div>
                    <button type="submit" class="btn btn-success">Fortsæt</button>
                </form>';
                unset($_SESSION["recover_mail"]);
                unset($_SESSION["recover_mail_Err"]);
            break;
    }
    unset($_SESSION["recover_step"]);
    ?>
    </div>
    <div class="col-sm-3"></div>
        </div>
</div>