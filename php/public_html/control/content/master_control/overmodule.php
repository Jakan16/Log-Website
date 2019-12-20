<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/control/content/functions.php";
    if (!isset($_SESSION['master_control_edit_lang'])) {
    	$_SESSION['master_control_edit_lang'] = DEFAULT_LANG;
    }
?>
