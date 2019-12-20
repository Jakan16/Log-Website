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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post_img_id = clean_input_text($_POST["id"]);
    if ($post_img_id == -1) 
    {
        unset($_SESSION['selected_img_owner']);
        unset($_SESSION['selected_img_id']);
        header("location: /control/site_editor");
    }
    else 
    {
        try {
            $conn = get_db_connection(MAIN_DB_HOST, MAIN_DB_DATABASE_NAME, MAIN_DB_USER, MAIN_DB_PASS);
            $stmt = $conn->prepare("SELECT user_id, dir FROM ".MAIN_DB_PREFIX."images WHERE id = :id;");
            $stmt->bindParam(':id', $post_img_id, PDO::PARAM_INT);
            $stmt->execute();
              // set the resulting array to associative
            if ($stmt->rowCount() > 0) {
              $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
              foreach($stmt->fetchAll() as $row) {
                  $owner_of_img = $row['user_id'];
                  if (check_permission(4) || LOGIN_ID == $owner_of_img) {
                        // Permission 4 is to modify uploads
                        
                        $_SESSION['selected_img_owner'] = $owner_of_img;
                        $_SESSION['selected_img_id'] = $post_img_id;
                        header("location: /control/site_editor#image".$post_img_id);
                    }
                    else {
                        $_SESSION["uploade_feedback"] = '<div class="row">
                        <div class="col-sm-12 alert alert-danger">
                        <strong>ERROR</strong> Der skete en fejl
                        </div>
                        </div>';
                        unset($_SESSION['selected_img_owner']);
                        unset($_SESSION['selected_img_id']);
                        header("location: /control/site_editor");
                    }
                    $stmt = null;
                    $conn = null;
                }
            }
        }
        catch(PDOException $e) {
            $_SESSION["uploade_feedback"] = '<div class="row">
            <div class="col-sm-12 alert alert-danger">
            <strong>ERROR</strong> Der skete en fejl
            </div>
            </div>';
            header("location: /control/site_editor");
        }
    }

}
else {
    header("location: /");
}

?>