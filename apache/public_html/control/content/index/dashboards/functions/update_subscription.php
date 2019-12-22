<?php
    $page_permission = 2; // all has access  
    require_once $_SERVER['DOCUMENT_ROOT']."/core/system_core.php";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    {
            $POST_cpu_usage_input = clean_input_text($_POST["cpu_usage_input"]);
            $POST_ram_usage_input = clean_input_text($_POST["ram_usage_input"]);

            if (!empty($POST_cpu_usage_input) && 
                !empty($POST_ram_usage_input))
            {
            
                $request = array("method" => "updatesubscription", "token" => $_SESSION["LOGIN_TOKEN"], "cpu" => $POST_cpu_usage_input, "ram" => $POST_ram_usage_input);
                $request_list = call_authentication_service($request);
                $_SESSION["uploade_feedback"] = '<div class="row">
                    <div class="col-sm-8 alert alert-success">
                    <strong>SUCCESS</strong> Agent is created 
                    </div>
                    <div class="col-sm-4"></div>
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
            header('Location: /control/index?select=subscription');
    } 
    else 
    {
        header('Location: /');
    }
?>
