<?php 
/** Sandsized CMS - By Guld-berg.dk software technologies
*  Developed by Jørn Guldberg
*  Copyright (C) Jørn Guldberg - Guld-berg.dk All Rights Reserved. 
*  Version 6.1.1: Release of major, not compatiple with earlier realises. 
*  Full release-notes se the git repository
*/

$page_permission = 5; // Speciel rule the user have to have a permission for, to acces this. 
$web_page_name = "Rediger side"; // Sidens navn, dette navn afgører hvilken fane i menuen der er aktiv. (Skal være identisk med det i Mysql)
$sidenssti = "/control/content/site_editor"; // Dette er stien til hvor filerne ligger
$overmodule = "/overmodule.php"; // Dette er overmoduleet, det jeg kalder for behandlingsfiler
$content = "/content.php"; // Her er filnavnet på contentet af den pågældene side. 
//$sidenspecialescript = "/forsidescript.php";
// Her hentes skarbelonen til hele siden, og siden bliver printet til skærmen. 
require_once $_SERVER['DOCUMENT_ROOT']. "/core/unite_includes.php"; //
?>