<?php
/* Sandsized CMS - By Guld-berg.dk software technologies
*  Developed by Jørn Guldberg
*  Copyright (C) Jørn Guldberg - Guld-berg.dk All Rights Reserved. 
*/
include $_SERVER['DOCUMENT_ROOT']."/core/system_core.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // safty for bruteforce attack
    if ($_SESSION['brute_force_counter'] < strtotime("+ 1 sec")) {
        $_SESSION['brute_force_counter'] = strtotime("+ 2 sec"); // setting up the new time to wait
        // Her laves deb variabel der sendes tilbage. Enten med sucses eller med en fejl medelelse
        $dataDerSendesTilbage = "";

        // Her modtages brugernavn og adgangskode.
        $tjekBrugernavn = clean_input_text($_POST["sendtBrugernavn"]);
        $tjekPassword = clean_input_text($_POST["sendtPassword"]);

        // Her tjekkes det om der er skrevet noget i brugernavnet og passwordet
        if (!empty($tjekBrugernavn) && !empty($tjekPassword)) {
            // Hvis der findes en bruger i systemet med login navnet findes de forskellige oplysninger om brugeren.
            $tjekBrugernavn = username_check($tjekBrugernavn);
            $tjekPassword = password_crypt($tjekPassword, $tjekBrugernavn);
            // Her tjekkes det om oplysningerne findes i systemet.
            try {
                $conn = get_db_connection(MAIN_DB_HOST, MAIN_DB_DATABASE_NAME, MAIN_DB_USER, MAIN_DB_PASS);
                $stmt = $conn->prepare("SELECT id, username, active, company_key FROM ".MAIN_DB_PREFIX."users WHERE username_clean = ? AND password = ? ");
                $stmt->execute(array($tjekBrugernavn, $tjekPassword));
                        // set the resulting array to associative
                $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                if ($stmt->rowCount() == 1) {
                    foreach($stmt->fetchAll() as $row) {
                        if ($row['active'] == 1) {
                            $_SESSION['login_user'] = $row['username'];
                            $_SESSION['LOGIN_LAST_ACTIVITY'] = (time() + 900); // Set a timer for the user, if the user is inactive, the user is logout
                            
                            if ($row['company_key'] != "") 
                            {

                                $data = array("method" => "gettoken", "licensekey" => "NULL", "companykey" => $row['company_key']);
                                $auth_res = call_authentication_service($data);
                                $_SESSION["LOGIN_TOKEN"] = $auth_res["token"]; 
                            }

                            // for safty reason we reset rocoverycode and recoverytime, so that no hanging code can be used. 
                            $stmt_set = $conn->prepare("UPDATE ".MAIN_DB_PREFIX."users SET recoverycode = '', recoverytime = '' WHERE id = ?;");
                            $stmt_set->execute(array($row['id']));
                            $stmt_set = null;
                        
                            
                            $dataDerSendesTilbage = "succes";
                        }
                        else {
                            $dataDerSendesTilbage = "deactive";
                        }
                    }
                } 
                else {
                    $dataDerSendesTilbage = "wrong";
                }
            }
            catch(PDOException $e) {
                    echo "Error: ";
            }
            $stmt = null;
            $conn = null;
        }
        else {
            $dataDerSendesTilbage = "empty";    
        }
    }
    else {
        $dataDerSendesTilbage = 'time';
    }
    echo $dataDerSendesTilbage;
}
else {
    header('Location: /');
}

?>