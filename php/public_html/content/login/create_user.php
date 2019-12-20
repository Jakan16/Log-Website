<?php
$page_permission = 0; // all has access  
require_once $_SERVER['DOCUMENT_ROOT']."/core/system_core.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
        $POST_company_key = clean_input_text($_POST["company_key"]);
        $POST_username = clean_input_text($_POST["username"]);
        $POST_password = clean_input_text($_POST["password"]);
        $POST_repeat_password = clean_input_text($_POST["repeat_password"]);

        if (!empty($POST_username) && 
            !empty($POST_password) &&
            !empty($POST_company_key) &&
            !empty($POST_repeat_password) &&
            ($POST_password == $POST_repeat_password) ) 
        {
        
            $data = array("companykey" => $POST_company_key, "method" => "companykeycheck", "serverkey" => SERVER_AUTH_KEY);                                                                    
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

        try {
            if ($json_result["response"] == "true") 
            {
                $POST_username_clean = username_check($POST_username);
                $POST_password = password_crypt($POST_password, $POST_username_clean);
                
                $conn = get_db_connection(MAIN_DB_HOST, MAIN_DB_DATABASE_NAME, MAIN_DB_USER, MAIN_DB_PASS);
                $stmt = $conn->prepare("INSERT INTO ".MAIN_DB_PREFIX."users (username, username_clean, permission_list, password, active, company_key)
                                        VALUES(?, ?, 'a:2:{i:0;i:2;i:1;i:7;}', ?, 1, ?);"); //  1 for that the user is immediately active
                $stmt->execute(array($POST_username, $POST_username_clean, $POST_password, $POST_company_key));

                $stmt2 = $conn->prepare("INSERT INTO ".MAIN_DB_PREFIX."user_info (id, profile_img, hidden)
                                        VALUES(?, ?, 0);"); 
                $stmt2->execute(array($conn->lastInsertId(), DEFAULT_PROFILE_IMG));
                    

                $_SESSION["uploade_feedback"] = '<div class="row">
                        <div class="col-sm-8 alert alert-success">
                        <strong>SUCCESS</strong> User is created
                        </div>
                        <div class="col-sm-4"></div>
                        </div>';
            }
            else
            {
                throw new PDOException("Error Processing Request", 1);
                
            }
        }
        catch(PDOException $e) {
            $_SESSION["uploade_feedback"] = '<div class="row">
                <div class="col-sm-8 alert alert-danger">
                <strong>ERROR</strong> Error - '.$e.'
                </div>
                <div class="col-sm-4"></div>
                </div>';
        }
        $stmt = null;
        $conn = null;
        }
        else {
            $_SESSION["uploade_feedback"] = '<div class="row">
                <div class="col-sm-8 alert alert-danger">
                <strong>ERROR</strong> Error - You have to enter both username and password
                </div>
                <div class="col-sm-4"></div>
                </div>';        
        }
        header('Location: /login');
} 
else 
{
    header('Location: /bla');
}
?>
