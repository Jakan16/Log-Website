<?php
/*
 *  @plugin_name:        Hello plug-in
 *  @plugin_author:      Jørn Guldberg
 *  @plugin_Version:     0.0.2
 *  @plugin_main-core:   5.0.0
 */

/* Load in dependencies 
 * $_SERVER['DOCUMENT_ROOT'] -> I have started to do the pluin
 * with raletive path so that the pluing should work no 
 * mater where it is put. 
 */

require_once "../settings/lang/plugin_DK.php"; // This should be generated to the session langures 

/**
 *  This should always be the function which calls 
 *  the main function of the plug-in
 */
function get_plugin_content() {
    echo LANG_PLUGIN_SETTINGS_HELLO;
}
?>
