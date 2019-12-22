<?php
/** Sandsized CMS - By Guld-berg.dk software technologies
*  Developed by Jørn Guldberg
*  Copyright (C) Jørn Guldberg - Guld-berg.dk All Rights Reserved. 
*  Version 6.1.1: Release of major, not compatiple with earlier realises. 
*  Full release-notes se the git repository
*/
function loggetind() {
    $navnbar = '
          <li class="dropdown">
        <a class="dropdown-toggle navi-link" data-toggle="dropdown" href="#">Hi ' . $_SESSION['login_user'] . '
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
        <li style="color: white;"></li>
        <li><a class="navi-link drop_menu_link" href="/control/index">User dashboard</a></li>
          '.get_special_menu_point().'
        <li><a class="navi-link drop_menu_link" href="/logout">Log out</a></li>
        </ul>
      </li>';
    return $navnbar;
}

function loginBoks() {
/*echo '<div class="modal fade" id="myModal" role="dialog" style="z-index: 9999;">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Login</h4>
        </div>
        <div style="color:black;" class="modal-body">
        <form role="form">
         <div class="form-group">
            <label for="brugernavn">Brugernavn:</label>
            <input type="text" class="form-control" id="brugernavn">
         </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password">
        </div>
        <button type="submit" id="loginbutton" class="btn btn-default">Login</button>
        <span class="text-danger" id="loginfeedback"></span>
        </form>
        <a href="/user-recovery">Glemt password?</a>
        
        </div>
      </div>
      
    </div>
  </div>';*/
}
?>

<div class="container" id="navi">
    
    <nav class="navbar navbar-fixed-top navbar-inner" id="navi-inner">
        <div class="container-fluid">
                <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/index"><?php echo GLOBAL_FIRM_NAME; ?></a>
        </div>
        
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right small">
                    <?php
                        try {
                            $conn = get_db_connection(MAIN_DB_HOST, MAIN_DB_DATABASE_NAME, MAIN_DB_USER, MAIN_DB_PASS);
                            $stmt = $conn->prepare("SELECT ".MAIN_DB_PREFIX."navi.link, ".MAIN_DB_PREFIX."navi_name.name, ".MAIN_DB_PREFIX."navi.permission
                                                    FROM ".MAIN_DB_PREFIX."navi
                                                    INNER JOIN ".MAIN_DB_PREFIX."navi_name ON ".MAIN_DB_PREFIX."navi.id=".MAIN_DB_PREFIX."navi_name.parent_id 
                                                    WHERE ".MAIN_DB_PREFIX."navi.place = 'standart'
                                                    ORDER BY navi_order;");
                            $stmt->execute();
                            if ($stmt->rowCount() > 0) {
                                foreach($stmt->fetchAll() as $row) 
                                {  
                                    if(isset($_SESSION['login_user']) && $row['name'] == "Login") { 
                                        continue;
                                    }   
                                    if(check_permission($row['permission'])) 
                                    {
                                        // Check if we have to make a dropdown menu for the menu
                                        $stmt2 = $conn->prepare("SELECT ".MAIN_DB_PREFIX."navi.link, ".MAIN_DB_PREFIX."navi_name.name, ".MAIN_DB_PREFIX."navi.permission
                                                            FROM ".MAIN_DB_PREFIX."navi
                                                            INNER JOIN ".MAIN_DB_PREFIX."navi_name ON ".MAIN_DB_PREFIX."navi.id=".MAIN_DB_PREFIX."navi_name.parent_id 
                                                            WHERE ".MAIN_DB_PREFIX."navi.place = ?
                                                            ORDER BY navi_order;");
                                        $stmt2->execute(array($row['name']));
                                        if ($stmt2->rowCount() > 0) {
                                            $generated_dropdown_menu = '<li class="dropdown">
                                                <a class="dropdown-toggle navi-link" data-toggle="dropdown" href="#">'.$row['name'].'<span class="caret"></span></a>
                                                <ul class="dropdown-menu">';
                                            
                                            foreach($stmt2->fetchAll() as $row2) 
                                            {
                                                if(check_permission($row_2['permission'])) 
                                                {
                                                    $generated_dropdown_menu .= '<li><a class="navi-link drop_menu_link" href="/'.$row2['link'].'">'.$row2['name'].'</a></li>';
                                                }
                                            }
                                            $generated_dropdown_menu .= '</ul><li>';
                                            echo $generated_dropdown_menu;

                                        }
                                        else {
                                            echo '<li><a class="navi-link" href="/'.$row['link'].'">'.$row['name'].'</a></li>';
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
                    ?>
                    <?php
                    if(isset($_SESSION['login_user'])) {
                        // Hvis man er logget ind
                        echo loggetind();
                    }
                    // Her kommer der en besked om at man er logget ud.
                    if($_SESSION["log_out"] == 1) {
                        echo '<div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Du er nu logget ud</strong>
                        </div>';
                        $_SESSION["log_out"] = 0;
                    }
                    ?>
                
            </ul>
        </div>
        </div>
    </nav>
</div>