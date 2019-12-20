<?php
    $page_permission = 2; // all has access  
    require_once $_SERVER['DOCUMENT_ROOT']."/core/system_core.php";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    {
            $POST_agent_name = clean_input_text($_POST["agent_name"]);

            if (!empty($POST_agent_name))
            {
            
                $request = array("method" => "newagent", "token" => $_SESSION["LOGIN_TOKEN"], "name" => $POST_agent_name);
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
