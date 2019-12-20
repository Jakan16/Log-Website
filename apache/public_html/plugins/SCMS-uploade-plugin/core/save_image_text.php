<?php 
/** Sandsized CMS - By Guld-berg.dk software technologies
*  Developed by Jørn Guldberg
*  Copyright (C) Jørn Guldberg - Guld-berg.dk All Rights Reserved. 
*  Version 6.1.1: Release of major, not compatiple with earlier realises. 
*  Full release-notes se the git repository
*/

$page_permission = 4; // Aloud for both users and admins
                     // Allthough be sure that no one else than the img's owner or an admin
                     // are aloud to remove a img.

require_once $_SERVER['DOCUMENT_ROOT']."/core/system_core.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    $post_image_id = clean_input_text($_POST["set_image_id_input"]);
    $post_img_text = clean_input_text($_POST["image_text_comment"]);



    $conn = get_db_connection(MAIN_DB_HOST, MAIN_DB_DATABASE_NAME, MAIN_DB_USER, MAIN_DB_PASS);
    $stmt = $conn->prepare("SELECT * FROM ".MAIN_DB_PREFIX."images WHERE id = ?;");
    $stmt->execute(array($post_image_id));
    // set the resulting array to associative
    if ($stmt->rowCount() > 0) {
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        foreach($stmt->fetchAll() as $row) 
        {
            $owner_of_img = $row['user_id'];
    
            if (check_permission(4) || LOGIN_ID == $owner_of_img) {
                    
                $conn_2 = get_db_connection(MAIN_DB_HOST, MAIN_DB_DATABASE_NAME, MAIN_DB_USER, MAIN_DB_PASS);
                $stmt_2 = $conn_2->prepare("UPDATE ".MAIN_DB_PREFIX."images SET img_text = :img_text WHERE id = :id;");
                $stmt_2->bindParam(':img_text', $post_img_text);
                $stmt_2->bindParam(':id', $post_image_id, PDO::PARAM_INT);
                $stmt_2->execute();

                $_SESSION["uploade_feedback"] = '<div class="row">
                <div class="col-sm-12 alert alert-success">
                <strong>Success</strong> Billedets teskt er blevet opdateret.
                </div>
                </div>';
                header("location: /control/site_editor");
            }
            else {
                $_SESSION["uploade_feedback"] = '<div class="row">
                <div class="col-sm-12 alert alert-danger">
                <strong>ERROR</strong> Der skete en fejl
                </div>
                </div>';
                header("location: /control/site_editor");
            }
        }
    }

    header("location: /control/site_editor");

}
else {
    header("location: /");
}

?>