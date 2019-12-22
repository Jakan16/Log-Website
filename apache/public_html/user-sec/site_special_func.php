<?php
/* Sandsized CMS - By Guld-berg.dk software technologies
*  Developed by Jørn Guldberg
*  Copyright (C) Jørn Guldberg - Guld-berg.dk All Rights Reserved. 
*/

/*
*  IMPLEMENT THE SPECIFIC FUNCTIONALITY HERE
*/
function get_special_menu_point() {
    $menu = "";
    if (check_permission(1)) {
        $menu = '<li><a class="navi-link drop_menu_link" href="/control/master_control">Admin Control</a></li>';
    }
    return $menu;
}
?>