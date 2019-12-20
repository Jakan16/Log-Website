<?php
    $page_permission = 7; // all has access
    require_once $_SERVER['DOCUMENT_ROOT']."control/content/functions.php";

    $dashboard_content = "";

    if ($_GET["select"] == "alarm") 
    {
    	include $_SERVER['DOCUMENT_ROOT']."control/content/index/dashboards/alarm_dashboard.php";
    	$dashboard_content = "<h1>Alarm management</h1>";
    }
    else if ($_GET["select"] == "log") 
    {
    	include $_SERVER['DOCUMENT_ROOT']."control/content/index/dashboards/log_dashboard.php";
    	$dashboard_content = "<h1>Log management</h1>";
    }
    else if ($_GET["select"] == "investigate") 
    {
    	include $_SERVER['DOCUMENT_ROOT']."control/content/index/dashboards/investigate_dashboard.php";
    	$dashboard_content = "<h1>Investigate - Alarm id: " . clean_input_text($_GET["id"]) ."</h1>";
    }
    else if ($_GET["select"] == "code") 
    {
    	include $_SERVER['DOCUMENT_ROOT']."control/content/index/dashboards/code_dashboard.php";
    	$dashboard_content = "<h1>Code management</h1>";
    }	
    else if ($_GET["select"] == "subscription") 
    {
    	include $_SERVER['DOCUMENT_ROOT']."control/content/index/dashboards/subscription_dashboard.php";
    	$dashboard_content = "<h1>Subscription</h1>";
    }
    else if ($_GET["select"] == "agents") 
    {
    	include $_SERVER['DOCUMENT_ROOT']."control/content/index/dashboards/agents_dashboard.php";
    	$dashboard_content = "<h1>Agents monitoring</h1>";
    }
    else
    {
    	// Default dashboard (General info)
    	include $_SERVER['DOCUMENT_ROOT']."control/content/index/dashboards/general_dashboard.php";
    	$dashboard_content = "<h1>General Dashboard</h1>";
    }
    
    $dashboard_content .= get_dashboard(); 

?>
