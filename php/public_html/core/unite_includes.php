<?php 
/** Sandsized CMS - By Guld-berg.dk software technologies
*  Developed by Jørn Guldberg
*  Copyright (C) Jørn Guldberg - Guld-berg.dk All Rights Reserved. 
*  Version 6.1.1: Release of major, not compatiple with earlier realises. 
*  Full release-notes se the git repository
*/

// Herunder hentes toppen af siden. Den includer alle nødvendige filer i header. alt indenfor de to head tegn er her.
require_once $_SERVER['DOCUMENT_ROOT']."/core/includes/head.php";
// body open tag er med i ovenstående fil. 
require_once $_SERVER['DOCUMENT_ROOT']."/core/includes/nav_plus_logo.php";
// Sørger for at jeg hurtigt kan smidde en status besked ind på siden.
require_once $_SERVER['DOCUMENT_ROOT']."/core/includes/status.php";
// Her hentes contentet af siden
require_once $_SERVER['DOCUMENT_ROOT']."/".$sidenssti.$content;
// Her indsættes bunden af siden.
require_once $_SERVER['DOCUMENT_ROOT']."/core/includes/foot.php";
?>