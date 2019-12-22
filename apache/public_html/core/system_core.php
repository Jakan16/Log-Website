<?php
/** Sandsized CMS - By Guld-berg.dk software technologies
*  Developed by Jørn Guldberg
*  Copyright (C) Jørn Guldberg - Guld-berg.dk All Rights Reserved. 
*  Version 6.1.1: Release of major, not compatiple with earlier realises. 
*  Full release-notes se the git repository
*/

session_start();

include $_SERVER['DOCUMENT_ROOT']."/user-sec/site_settings.php";

// Her indstilles tidindstillingerne på siden
date_default_timezone_set("Europe/Copenhagen");
define('DATE_AND_TIME', date('Y-m-d H:i:s'));
define('DATE_WITHOUT_TIME', date('Y-m-d'));

if (!isset($_SESSION["initialization"])) 
{
    $_SESSION['session_language'] = 'GB';
    $_SESSION["log_out"] = 0;
}
else
{
    $_SESSION["initialization"] == 1;
}


function get_db_connection($host, $dbname, $user, $pass) {
    $conn = new PDO('mysql:host='.$host.';dbname='.$dbname.';charset=utf8', $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conn;
}

function call_authentication_service($data)
{
    $data_string = json_encode($data);
    $ch = curl_init(SERIVCE_AUTHSERVICE_URL);                          
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                      
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                            
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_string)) 
    );
    $result = curl_exec($ch);
    $json_result = json_decode($result, true);
    return $json_result;
}

function clean_input_text($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   $data = addslashes($data);
   return $data;
}

function username_check($username_check) {
    $username_check = rtrim($username_check, ' ');
    $username_check = stripslashes($username_check);
    $username_check = htmlspecialchars($username_check);
    $username_check = strtolower($username_check);
    $username_check = addslashes($username_check);

    return $username_check;
    
}

function password_crypt($password_crypt, $username_check) {
    // Denne tager passwordet ind og cryptere det, så det kan tjekkes i DB.
    $b1 = "03q2d4qwd%?1234Ejoe324>";
    $b2 = "233244?][qwrqwqeqwew";
    $b3 = "¤SDFWwdfsdgdf.,wrsdv{}2";
    $password_crypt = stripslashes($password_crypt);
    $password_crypt = htmlspecialchars($password_crypt);
    $feedback = hash('sha256', $b2.$username_check.$b3.$password_crypt.$b1);
    
    return $feedback;
}

function check_permission($rule_id) {
    if (($rule_id == 0) || in_array(1, LOGIN_PERMISSIONS) || in_array($rule_id, LOGIN_PERMISSIONS)) 
    {
        return true;
    }
    else {
        return false;
    }    
}

function check_plugin_permission($rule_id, $permission_list) {
    if (($rule_id == 0) || in_array(1, $permission_list) || in_array($rule_id, $permission_list)) {
        return true;
    }
    else {
        return false;
    }    
}

function get_permission_list_plugin($plugin_id, $user_id) {
    $list = "false";
    try {
        $conn = get_db_connection(MAIN_DB_HOST, MAIN_DB_DATABASE_NAME, MAIN_DB_USER, MAIN_DB_PASS);
        $stmt = $conn->prepare("SELECT permission_list FROM ".MAIN_DB_PREFIX."plugs_permissions WHERE plugin_id = ? AND user_id = ?;");
        $stmt->execute(array($plugin_id, $user_id));
                // set the resulting array to associative
        if ($stmt->rowCount() == 1) {
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            foreach($stmt->fetchAll() as $row) {
                $list = unserialize($row['permission_list']);
            }
        }
    
    }
    catch(PDOException $e) {
            return "error";
    }
    $stmt = null;
    $conn = null;   

    return $list;
}

//siden titel
$web_page_title = GLOBAL_FIRM_NAME . " - " . $web_page_name;

//language is set and loaded
if (!$_SESSION['session_language']) {       // if language is not set yet, the deafult language danish is chosen.
    $_SESSION['session_language'] = DEFAULT_LANG;
}

// choose language code: 
if (isset($_GET["lang"])) {
    try {
        $conn = get_db_connection(MAIN_DB_HOST, MAIN_DB_DATABASE_NAME, MAIN_DB_USER, MAIN_DB_PASS);
        $stmt = $conn->prepare("SELECT code FROM ".MAIN_DB_PREFIX."country WHERE code = ? AND active = 1 ");
        $stmt->execute(array(clean_input_text($_GET["lang"])));
                // set the resulting array to associative
        if ($stmt->rowCount() == 1) {
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            foreach($stmt->fetchAll() as $row) {
                $_SESSION['session_language'] = $row['code'];
            }
        }
        else {
            $_SESSION['session_language'] = DEFAULT_LANG;
        }
    }
    catch(PDOException $e) {
        $_SESSION['session_language'] = DEFAULT_LANG;
        header('Location: /');
    }
    $stmt = null;
    $conn = null;
}
/* IMPORTANT..!
*  The lang files is loaded here given the coosen lang. 
*  This is very importent that a activ lang has a lang file in the direktory with the exact 
*  Lang code as in the DB
*/
require_once $_SERVER['DOCUMENT_ROOT']."/core/lang/".$_SESSION['session_language'].".php";

// Her tjekkes det om man er logget ind
if (isset($_SESSION['login_user'])) {
    //Der navn der er gemt i sessionen bliver her skrevet i en variabel der kan tjekkes i mysql
    $login_tjek = username_check($_SESSION['login_user']);
    // Hvis der findes en bruger i systemet med login navnet findes de forskellige oplysninger om brugeren.
    try {
        $conn = get_db_connection(MAIN_DB_HOST, MAIN_DB_DATABASE_NAME, MAIN_DB_USER, MAIN_DB_PASS);
        $stmt = $conn->prepare("SELECT * FROM ".MAIN_DB_PREFIX."users WHERE username_clean = ?;");
        $stmt->execute(array($login_tjek));
                // set the resulting array to associative
        if (($stmt->rowCount() == 1) && ($_SESSION['LOGIN_LAST_ACTIVITY'] > time())) 
        {
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            foreach($stmt->fetchAll() as $row) 
            {
                if ($row['active'] == 1) 
                {
                    define('LOGIN_ID', $row['id']);
                    define('LOGIN_SESSION', $row['username']);
                    define('LOGIN_SESSIONCLEAN', $row['username_clean']);
                    define('LOGIN_MAIL', $row['mail']);
                    define('LOGIN_PERMISSIONS', unserialize($row['permission_list']));
                    $_SESSION['LOGIN_LAST_ACTIVITY'] = (time() + 86400); // 900 sec = 15 minutes - Set a timer for the user, if the user is inactive, the user is logout - is set to 24h
                }
                else {
                    header('Location: /logout');
                }
            }
        }
        else {
            header('Location: /logout');
        }
    }
    catch(PDOException $e) {
            header('Location: /error');
    }
    $stmt = null;
    $conn = null;   
}
else
{
    define('LOGIN_PERMISSIONS', array());
}

if ($page_permission != 0 && !isset($_SESSION['login_user'])) {
    header('Location: /');
}
else if (!check_permission($page_permission)) {
    header('Location: /');
}


include $_SERVER['DOCUMENT_ROOT']."/user-sec/site_special_func.php"; // The special functionality of the specific site

?>
