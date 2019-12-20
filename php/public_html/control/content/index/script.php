<?php
    $dashboard_script = "";

    if ($_GET["select"] == "alarm") 
    {
        require_once $_SERVER['DOCUMENT_ROOT']."control/content/index/dashboards/alarm_dashboard_script.php";
        $dashboard_script = "<script>$(function(){get_content_alarm_dashboard();});</script>";
    }
    else if ($_GET["select"] == "log") 
    {
        require_once $_SERVER['DOCUMENT_ROOT']."control/content/index/dashboards/log_dashboard_script.php";
        $dashboard_script = "<script>$(function(){get_content_log_dashboard();});</script>";
    }
    else if ($_GET["select"] == "investigate") 
    {
        require_once $_SERVER['DOCUMENT_ROOT']."control/content/index/dashboards/investigate_dashboard_script.php";
        $dashboard_script = "<script>$(function(){get_alarm_information(".$_GET['id'].");});</script>";
    }
    else if ($_GET["select"] == "code") 
    {
        include $_SERVER['DOCUMENT_ROOT']."control/content/index/dashboards/code_dashboard_script.php";
        $dashboard_script = "<script>$(function(){get_content_code_dashboard();});</script>";
    }   
    else if ($_GET["select"] == "subscription") 
    {
        include $_SERVER['DOCUMENT_ROOT']."control/content/index/dashboards/subscription_dashboard.php";
        $dashboard_script = "<h1>Subscription</h1>";
    }
    else if ($_GET["select"] == "agents") 
    {
        include $_SERVER['DOCUMENT_ROOT']."control/content/index/dashboards/agents_dashboard.php";
        $dashboard_script = "<h1>Agents monitoring</h1>";
    }
    else
    {
        // Default dashboard (General info)
        require_once $_SERVER['DOCUMENT_ROOT']."control/content/index/dashboards/alarm_dashboard_script.php";
        require_once $_SERVER['DOCUMENT_ROOT']."control/content/index/dashboards/log_dashboard_script.php";
        require_once $_SERVER['DOCUMENT_ROOT']."control/content/index/dashboards/code_dashboard_script.php";
        $dashboard_script .= "<script>$(function(){get_content_alarm_dashboard();get_content_log_dashboard();get_content_code_dashboard();});</script>";
    }
    
    echo $dashboard_script; 

?>
