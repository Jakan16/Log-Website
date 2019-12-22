<?php
/* Sandsized CMS - By Guld-berg.dk software technologies
*  Developed by Jørn Guldberg
*  Copyright (C) Jørn Guldberg - Guld-berg.dk All Rights Reserved. 
*/
function menu_line($active){
    $return_string = '<ul class="nav nav-tabs">';
    try {
        $conn = get_db_connection(MAIN_DB_HOST, MAIN_DB_DATABASE_NAME, MAIN_DB_USER, MAIN_DB_PASS);
        $stmt = $conn->prepare("SELECT ".MAIN_DB_PREFIX."navi.link, ".MAIN_DB_PREFIX."navi.permission, ".MAIN_DB_PREFIX."navi_name.name
                                FROM ".MAIN_DB_PREFIX."navi
                                INNER JOIN ".MAIN_DB_PREFIX."navi_name ON ".MAIN_DB_PREFIX."navi.id=".MAIN_DB_PREFIX."navi_name.parent_id 
                                WHERE ".MAIN_DB_PREFIX."navi.place = 'controlpanel'
                                ORDER BY navi_order;");
        $stmt->execute(array($_SESSION['session_language']));
        if ($stmt->rowCount() > 0) {
            foreach($stmt->fetchAll() as $row) {
                if (check_permission($row['permission'])) {
                    if ($row['name'] == $active) {
                        $return_string = $return_string . '<li class="active"><a href="/'.$row['link'].'">'.$row['name'].'</a></li>' ;
                    } else {
                        $return_string = $return_string . '<li><a href="/'.$row['link'].'">'.$row['name'].'</a></li>' ;
                    }    
                }
            }
        }
    }
    catch(PDOException $e) {
            $feedback = "Der er sket en fejl.";
    }
    $stmt = null;
    $conn = null;

    return $return_string = $return_string . '</ul>';
}

?>