<?php
$page_permission = 1; // Has to be admin  
require_once $_SERVER['DOCUMENT_ROOT']."/core/system_core.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
    	$new_permissions = serialize(array_map('intval', $_POST['check_list']));
    	$post_user_id = clean_input_text($_POST["user_id"]);  

        $conn = get_db_connection(MAIN_DB_HOST, MAIN_DB_DATABASE_NAME, MAIN_DB_USER, MAIN_DB_PASS);
        $stmt = $conn->prepare("UPDATE ".MAIN_DB_PREFIX."users SET permission_list = ? WHERE id = ? ;");
        $stmt->execute(array($new_permissions, $post_user_id));
        $stmt = null;
        $conn = null;

        $_SESSION["uploade_feedback"] = '<div class="row">
        <div class="col-sm-12 alert alert-success">
        <strong>SUCCESS</strong> Handlingen er gennemført
        </div>
        </div>';
        header("location: /control/master_control");

    }
    catch(PDOException $e) {
        $_SESSION["uploade_feedback"] = '<div class="row">
        <div class="col-sm-12 alert alert-danger">
        <strong>ERROR</strong> Der skete en fejl
        </div>
        </div>';
    	header('Location: /control/master_control');
    } 
} 
else {
    header('Location: /');
}
?>