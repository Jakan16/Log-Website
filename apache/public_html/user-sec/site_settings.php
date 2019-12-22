<?php
/** Sandsized CMS - By Guld-berg.dk software technologies
*  Developed by Jørn Guldberg
*  Copyright (C) Jørn Guldberg - Guld-berg.dk All Rights Reserved. 
*  Version 6.1.1: Release of major, not compatiple with earlier realises. 
*  Full release-notes se the git repository
*/

/*
*  This is the settings for the specific site
*/


define('MAIN_DB_HOST', getenv("MYSQL_ADDR")); // host
define('MAIN_DB_USER', 'my_sql_user'); // user
define('MAIN_DB_PASS', 'my_sql_password'); // pw
define('MAIN_DB_DATABASE_NAME', 'MaincoreDBdev5'); // Database name
define('MAIN_DB_PREFIX', 'ReplaceDB');

/*
*  Constants maybe have to be loaded from the DB 
*/
define('DEFAULT_PROFILE_IMG', '/design/default-profile.png'); // Default lang
define('DEFAULT_LANG', 'DK'); // Default lang
define('GLOBAL_META_LOCAL', 'da-DK'); 
define('GLOBAL_CONTACT_EMAIL', "kontakt@guld-berg.dk");
define('GLOBAL_FIRM_NAME', "LogOps™");
define('GLOBAL_FIRM_DESCRIPTION', "Upload your own code to analyse your logs");
define('GLOBAL_BACKUP_FILE_NAME', "Sandsized_CMS");

define('GLOBAL_FIRM_IMAGE_META', "Sandsized CMS");
define('SERVER_AUTH_KEY', "V%ojaT0pX}w12db3@*M+_cq}xB8s4+");

define('GLOBAL_URL', getenv("GLOBAL_URL"));
define('SERIVCE_LOGSTORE_URL', getenv("LOGSTORE_URL"));
define('SERIVCE_ALARMSERVICE_URL', getenv("ALARMSERVICE_URL"));
define('SERIVCE_JOLIECLOUD_URL', getenv("JOLIECLOUD_URL"));
define('SERIVCE_AUTHSERVICE_URL', getenv("AUTHSERVICE_URL"));


?>
