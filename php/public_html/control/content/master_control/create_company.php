<?php
$page_permission = 1; // Has to be admin  
require_once $_SERVER['DOCUMENT_ROOT']."/core/system_core.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $POST_company_name = clean_input_text($_POST["company_name"]);
    
    if (!empty($POST_company_name)) 
    {
        try {
            $data = array("name" => $POST_company_name, "method" => "newcompany", "serverkey" => SERVER_AUTH_KEY);                                                                    
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
            
            if ($json_result["response"] == "true") 
            {
                
                $_SESSION["uploade_feedback"] = '<div class="row">
                    <div class="col-sm-12 alert alert-success">
                    <strong>SUCCESS</strong> Company is created
                    </div>
                    </div>';
            }
            else 
            {
                $_SESSION["uploade_feedback"] = '<div class="row">
                    <div class="col-sm-8 alert alert-danger">
                    <strong>ERROR</strong> Error
                    </div>
                    <div class="col-sm-4"></div>
                    </div>';
            }
            header('Location: /control/master_control');
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
            <strong>ERROR</strong> Error - You have to enter a company name
            </div>
            <div class="col-sm-4"></div>
            </div>';        
    }
    header('Location: /control/master_control');
} else {
    header('Location: /');
}
?>
