<?php
/* Sandsized CMS - By Guld-berg.dk software technologies
*  Developed by Jørn Guldberg
*  Copyright (C) Jørn Guldberg - Guld-berg.dk All Rights Reserved. 
*/
?>

<div class="container GLOBALdesign">
     <h2>Controlpanel</h2>
    <?php echo menu_line($web_page_name);
          echo $_SESSION["uploade_feedback"];
          unset($_SESSION["uploade_feedback"]);?>
    
    <div class="row">
    <nav class="col-sm-2" id="myScrollspy">
      <ul class="nav nav-pills nav-stacked">
        <li><h3>Oversigt</h3></li>
        <li><a href="/control/master_control#user">Tilføj bruger</a></li>
        <li><a href="/control/master_control#members">Medlemsoversigt</a></li>
        <li><a href="/control/master_control#sider">Tilføj/fjern sider</a></li>
        <li><a href="/control/master_control#backup">Backup database</a></li>
        <li><a href="/control/master_control#plugs">Plugin liste</a></li>
      </ul>
    </nav>
    <div class="col-sm-10">
    
    <div id="members">         
        <?php 
            try {
                /* Setup values for the loop
                *  Deffrent options for deffrend kind of user state
                */

                
                $conn = get_db_connection(MAIN_DB_HOST, MAIN_DB_DATABASE_NAME, MAIN_DB_USER, MAIN_DB_PASS);
                $stmt = $conn->prepare("SELECT * FROM ".MAIN_DB_PREFIX."users WHERE id = ?;");
                $stmt->execute(array($GET_edit_user_id));
                if ($stmt->rowCount() == 1) {
                    foreach($stmt->fetchAll() as $row) {
                        $text_user_active = 'Deaktiver';
                        $value_user_activate = 'deactivate';
                        $data_login_permission_list = "";

                        $data_login_id = $row['id'];
                        $data_login_username = $row['username'];
                        $data_login_is_active = $row['active'];
                        $data_login_permission_list = unserialize($row['permission_list']);
                        
                        if ($data_login_is_active == 0) {
                            // $data_login_is_active = 0 is deactivated
                            $page_edit_text = $page_edit_text . '<h3>Deactivated Members</h3>';
                            $text_user_active = 'Activate';
                            $value_user_activate = 'activate';
                        }

                        $page_edit_text = $page_edit_text . '<h2>Rediger bruger: '.$data_login_username.'</h2>
                            <form class="form-inline" onsubmit="return confirmDelete()" action="/control/content/master_control/member_handler" method="post">
                                <div class="form-group">
                        <label for="page_name">'.$edit_page_lang.'</label>
                            <input type="hidden" class="form-control" name="username" id="username" value="'.$data_login_username.'">
                          </div>
                          <input type="hidden" class="form-control" name="id" id="id" value="'.$data_login_id.'">
                          <button type="submit" class="btn btn-default" name="handel" value="'.$value_user_activate.'">'.$text_user_active.'</button>
                          <button type="submit" class="btn btn-danger" name="handel" value="delete">Slet</button>
                          </form>';
                    }
                    $page_edit_text .= "<h3>Rediger rettigheder for brugeren:</h3>
                    <form class='form-inline' onsubmit='return confirmDelete()' action='/control/content/user_editor/update_user_permissions' method='post'><input type='hidden' class='form-control' name='user_id' id='user_id' value='".$data_login_id."'>";
                    $stmt = $conn->prepare("SELECT * FROM ".MAIN_DB_PREFIX."core_rules;");
                    $stmt->execute();
                    if ($stmt->rowCount() > 0) {
                        foreach($stmt->fetchAll() as $row) {
                            $data_permission_id = $row['id'];
                            $data_permission_username = $row['name'];
                            $permission_checked = "";
                            
                            if (in_array($row['id'], $data_login_permission_list)) {
                                $permission_checked = "checked='checked'";
                            }

                            $page_edit_text .= "$data_permission_id - $data_permission_username <input class='form-control' type='checkbox' name='check_list[]' value='".$row['id']."' $permission_checked><br>";
                        }
                    }
                
                }
                else {
                    $page_edit_text .= "Ingen elementer er fundet";
                }
            }
            catch(PDOException $e) {
                $page_edit_text .= "Der er sket en fejl.";
            }
            $stmt = null;
            $conn = null;
            
            echo $page_edit_text . "<button type='submit' class='btn btn-default'>Opdater</button></form>";

            try {
                $plugin_list = "";
                $conn = get_db_connection(MAIN_DB_HOST, MAIN_DB_DATABASE_NAME, MAIN_DB_USER, MAIN_DB_PASS);
                $stmt = $conn->prepare("SELECT * FROM ".MAIN_DB_PREFIX."installed_plugins;");
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    foreach($stmt->fetchAll() as $row) {
                        $first_time = "0";
                        $data_plugin_id = $row['id'];
                        $data_plugin_name = $row['name'];
                        $data_plugin_description = $row['description'];
                        $data_plugin_is_date = $row['date'];
                        $data_plugin_version = $row['version'];
                        
                        $plugin_permission_list = get_permission_list_plugin($data_plugin_id, $data_login_id);

                        if ($plugin_permission_list == "false") {
                            $first_time = "1";
                        }

                        $plugin_list = $plugin_list . "<h3>$data_plugin_name</h3> <b>Id:</b> $data_plugin_id<br><b>version:</b> $data_plugin_version<br>
                        <form class='form-inline' onsubmit='return confirmDelete()' action='/control/content/user_editor/update_user_permissions_plugins' method='post'>
                        <input type='hidden' class='form-control' name='user_id' id='user_id' value='".$data_login_id."'>
                        <input type='hidden' class='form-control' name='plugin_id' id='plugin_id' value='".$data_plugin_id."'>
                        <input type='hidden' class='form-control' name='first_time' id='first_time' value='".$first_time."'>";
                    
                        $stmt2 = $conn->prepare("SELECT * FROM ".MAIN_DB_PREFIX."plugs_rule where plugin_id = ?;");
                        $stmt2->execute(array($data_plugin_id));
                        if ($stmt2->rowCount() > 0) {
                            foreach($stmt2->fetchAll() as $row2) {
                                $data_permission_id = $row2['id'];
                                $data_permission_username = $row2['name'];
                                $permission_checked = "";

                                if ($first_time == "0") {
                                    if (in_array($data_permission_id, $plugin_permission_list)) {
                                        $permission_checked = "checked='checked'";
                                    }    
                                }
                                

                                $plugin_list .= "$data_permission_id - $data_permission_username <input class='form-control' type='checkbox' name='check_list[]' value='".$data_permission_id."' $permission_checked><br>";
                            }
                            $plugin_list .= "<button type='submit' class='btn btn-default'>Opdater</button></form>";
                        }
                    }
                }
                else {
                    $plugin_list = "Ingen elementer er fundet";
                }
            }
            catch(PDOException $e) {
                $plugin_list = "Der er sket en fejl.";
            }
            $stmt = null;
            $conn = null;
                
            echo $plugin_list;
            

            //$permission_list = serialize(array(1,2));
            //echo $permission_list;
        ?>
        <hr />
      </div>
    </div>
  </div>
</div>