<?php
$page_permission = 1; // Has to be admin  
require_once $_SERVER['DOCUMENT_ROOT']."/core/system_core.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
    	$post_first_time = clean_input_text($_POST["first_time"]);
        $post_plugin_id = clean_input_text($_POST["plugin_id"]);  
        if (!empty($_POST['check_list'])) {
            $new_permissions = serialize(array_map('intval', $_POST['check_list']));
        }
    	
        $post_user_id = clean_input_text($_POST["user_id"]);  

        $conn = get_db_connection(MAIN_DB_HOST, MAIN_DB_DATABASE_NAME, MAIN_DB_USER, MAIN_DB_PASS);
        if ($post_first_time == "1") {
            $stmt = $conn->prepare("INSERT INTO ".MAIN_DB_PREFIX."plugs_permissions (plugin_id, user_id, permission_list) VALUES (?, ?, ?);");
            $stmt->execute(array($post_plugin_id, $post_user_id, $new_permissions)); 
        }
        else {
            $stmt = $conn->prepare("UPDATE ".MAIN_DB_PREFIX."plugs_permissions SET permission_list = ? WHERE plugin_id = ? AND user_id = ?;");
            $stmt->execute(array($new_permissions, $post_plugin_id, $post_user_id)); 
        }
        $stmt = null;
        $conn = null;

        $_SESSION["uploade_feedback"] = '<div class="row">
        <div class="col-sm-12 alert alert-success">
        <strong>SUCCESS</strong> Handlingen er gennemført
        </div>
        </div>';
        header("location: /control/user_editor?user_id=".$post_user_id);

    }
    catch(PDOException $e) {
        $_SESSION["uploade_feedback"] = '<div class="row">
        <div class="col-sm-12 alert alert-danger">
        <strong>ERROR</strong> Der skete en fejl
        </div>
        </div>';
    	header('Location: /control/user_editor?user_id='.$post_user_id);
    } 
} 
else {
    header('Location: /');
}
?>