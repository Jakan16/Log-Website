<?php 
/* Sandsized CMS - By Guld-berg.dk software technologies
*  Developed by Jørn Guldberg
*  Copyright (C) Jørn Guldberg - Guld-berg.dk All Rights Reserved. 
*/

require_once $_SERVER['DOCUMENT_ROOT']."/core/system_core.php"; // kernefilen
include $_SERVER['DOCUMENT_ROOT']."/".$sidenssti.$overmodule;
// Her tjekkes der om der skal laves  login felter, eller om brugeren er logget ind.
if(isset($_SESSION['login_user'])) {
    $loginFelt = '<form class="navbar-form navbar-right">
            <span style="color: blue;"> Du er logget ind som: '.$_SESSION['login_user'].'</span> 
            <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Min Menu<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="/control/index">Kontrolpanel</a></li>
            <li><a href="/logud.php">Log ud</a></li>
          </ul>
        </li></form>';
    }
else {
    $loginFelt = '
    <form class="navbar-form navbar-right">
            <div class="form-group">
              <input type="text" id="brugernavn" placeholder="Brugernavn" class="form-control">
            </div>
            <div class="form-group">
              <input type="password" id="password" placeholder="Password" class="form-control">
            </div>
            <button data-toggle="popover" data-placement="bottom" title="Fejl i login" data-content="Brugernavn eller password forkert." type="submit" id="denskalvirke" class="btn btn-default">Login</button>
          </form>'; 
}

echo '<!DOCTYPE html>
<html lang="da-DK">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>'.GLOBAL_FIRM_NAME . ' - ' . $web_page_name.'</title>
<meta name="description" content="'.GLOBAL_FIRM_DESCRIPTION.'"/>
<meta name="robots" content="noodp"/>
<link rel="canonical" href="'.GLOBAL_URL.'" />
<meta property="og:locale" content="'.GLOBAL_META_LOCAL.'" />
<meta property="og:type" content="website" />
<meta property="og:title" content="'.GLOBAL_FIRM_NAME.'" />
<meta property="og:description" content="'.GLOBAL_FIRM_DESCRIPTION.'" />
<meta property="og:url" content="'.GLOBAL_URL.'" />
<meta property="og:site_name" content="'.GLOBAL_FIRM_NAME.'" />
<meta property="og:image" content="'.GLOBAL_URL.'" />
<meta name="twitter:card" content="'.GLOBAL_FIRM_DESCRIPTION.'" />
<meta name="twitter:description" content="'.GLOBAL_FIRM_DESCRIPTION.'" />
<meta name="twitter:title" content="'.GLOBAL_FIRM_NAME.'" />
<meta name="twitter:image" content="'.GLOBAL_URL.'" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="/design/style.css">
</head>
<body>';

require_once $_SERVER['DOCUMENT_ROOT']."/core/includes/basicscript.php";

?>