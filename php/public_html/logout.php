<?php
/** Sandsized CMS - By Guld-berg.dk software technologies
*  Developed by Jørn Guldberg
*  Copyright (C) Jørn Guldberg - Guld-berg.dk All Rights Reserved. 
*  Version 6.1.1: Release of major, not compatiple with earlier realises. 
*  Full release-notes se the git repository
*/

require_once ($_SERVER['DOCUMENT_ROOT']."/core/system_core.php"); // kernefilen
if(session_destroy()) // Destroying All Sessions
{
header("Location: /"); // Redirecting To Home Pageø
}
?>