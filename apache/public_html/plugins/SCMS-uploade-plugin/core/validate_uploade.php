<?php
/** Sandsized CMS - By Guld-berg.dk software technologies
*  Developed by Jørn Guldberg
*  Copyright (C) Jørn Guldberg - Guld-berg.dk All Rights Reserved. 
*  Version 6.1.1: Release of major, not compatiple with earlier realises. 
*  Full release-notes se the git repository
*/

$page_permission = 3; // 9 for all users to uplade images.
require_once $_SERVER['DOCUMENT_ROOT']."/core/system_core.php"; // require_once kernell

function img_resize($targett, $newcpy, $w, $h, $extn)
{

    list($w_orig, $h_orig) = getimagesize($targett);
    $scale_ratio = $w_orig / $h_orig;
    if (($w / $h) > $scale_ratio) {
           $w = $h * $scale_ratio;
    } else {
           $h = $w / $scale_ratio;
    }
    
    $img="";
    $extn = strtolower($extn);
    if($extn == "gif" || $extn == "GIF")
    {
        $img = imagecreatefromgif($targett);
    }
    else if($extn == "png" || $extn == "PNG")
    {
        $img = imagecreatefrompng($targett);
    }
    else
    {
        $img = imagecreatefromjpeg($targett);
    }
    $a = imagecreatetruecolor($w, $h);
    
    imagecopyresampled($a,$img,0,0,0,0,$w,$h,$w_orig,$h_orig);
    imagejpeg($a,$newcpy,80);
}

function domath($ma) {
    if(preg_match('/(\d+)(?:\s*)([\+\-\*\/])(?:\s*)(\d+)/', $ma, $matches) !== FALSE){
        $operator = $matches[2];
    
        switch($operator){
            case '+':
                $p = $matches[1] + $matches[3];
                break;
            case '-':
                $p = $matches[1] - $matches[3];
                break;
            case '*':
                $p = $matches[1] * $matches[3];
                break;
            case '/':
                $p = $matches[1] / $matches[3];
                break;
        }
    
        return $p;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $datomedtid = DATE_AND_TIME;
    $_SESSION['uploade_feedback'] = '';                     // Sørger for at feddbacken er tom.
    $post_attached_id = clean_input_text($_POST["SCMS-uploade-attached_id"]);
    $post_attached_group = clean_input_text($_POST["SCMS-uploade-attached_group"]);

    $total = count($_FILES['SCMS-uploade-upload']['name']);              // Count # of uploaded files in array
    
    // Loop through each file
    for($i=0; $i<$total; $i++) {
    
        $uploadbilledeErr ="";
        
        // Her starter upload scriptet.        
        $target_dir = '/user_content/'.LOGIN_ID.'/';
        $target_file = $target_dir . basename($_FILES["SCMS-uploade-upload"]["name"][$i]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        // Check if image file is a actual image or fake image
        
        $check = getimagesize($_FILES["SCMS-uploade-upload"]["tmp_name"][$i]);
        if($check !== false) {
            //echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            // echo "File is not an image.";
            $uploadbilledeErr = $_FILES["SCMS-uploade-upload"]["name"][$i];
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            $uploadbilledeErr = "Filen eksistere allerede";
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES["SCMS-uploade-upload"]["name"][$i]["size"] > 25000000) {
            $uploadbilledeErr = "Billedet er for stort. Det må maks fylde 25 MB.";
            $uploadOk = 0;
        }
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "JPG" && $imageFileType != "JPEG"
            && $imageFileType != "PNG" && $imageFileType != "png") {
            $uploadbilledeErr = "Det er kun jpg og jpeg filer der er tilladt at uploade";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $_SESSION['uploade_feedback'] = "<div class='row'>
                            <div class='col-sm-12 alert alert-danger'>
                                <h4>Billedet er ikke uploaded.</h4>" .$uploadbilledeErr . "
                                </div>
                                </div>";
        // if everything is ok, try to upload file
        } 
        else {
            $newnamebillede = $_FILES["SCMS-uploade-upload"]["tmp_name"][$i].$datomedtid;
            $newnamebillede = md5($newnamebillede).time();
            $newnamefinish = '/user_content/'.LOGIN_ID."/".$newnamebillede.'.'.$imageFileType;
            
            // Create dir if it does not exist (if user uploade its first image)
            
            if(!file_exists(($_SERVER['DOCUMENT_ROOT'].'/user_content/'.LOGIN_ID))) {
                mkdir(($_SERVER['DOCUMENT_ROOT'].'/user_content/'.LOGIN_ID), 0775, true);
                // Set the gruop write acces. 
                //chmod(($_SERVER['DOCUMENT_ROOT'].'/user_content/'.LOGIN_ID), 0775);
            }

            if (move_uploaded_file($_FILES["SCMS-uploade-upload"]["tmp_name"][$i], $_SERVER['DOCUMENT_ROOT'].$newnamefinish)) {
                $_SESSION['uploade_feedback'] = "<div class='row'>
                            <div class='col-sm-12 alert alert-success'>
                            <h4>Billederne er uploadet</h4>
                            </div>
                            </div>";
                try {
                    $conn = get_db_connection(MAIN_DB_HOST, MAIN_DB_DATABASE_NAME, MAIN_DB_USER, MAIN_DB_PASS);
                    
                    /**
                    *   1 = Normal upload of image
                    *   2 = New profile image
                    *   3 = New background image
                    */

                    if ($_POST["SCMS-uploade-mode"] == 1) {

                        $stmt = $conn->prepare("SELECT @this_show_order := (SELECT max(show_order) FROM ".MAIN_DB_PREFIX."images WHERE (user_id = :user_id) OR (user_id = 0)) + 1;
                                                INSERT INTO ".MAIN_DB_PREFIX."images (user_id, dir, uploaded, show_order)
                                                VALUES (:user_id, :dir, :uploaded, @this_show_order); ");
                        $int_id = LOGIN_ID;
                        $stmt->bindParam(':user_id', $int_id, PDO::PARAM_INT);
                        $stmt->bindParam(':dir', $newnamefinish);
                        $stmt->bindParam(':uploaded', $datomedtid);

                        $stmt->execute();
                    }
                    else if ($_POST["SCMS-uploade-mode"] == 2) {

                        $stmt_check = $conn->prepare("SELECT profile_img FROM ".MAIN_DB_PREFIX."user_info WHERE (id = ?) AND (profile_img != '/design/default_profile_img.png'); ");
                        $stmt_check->execute(array(LOGIN_ID));
                            // set the resulting array to associative
                        if ($stmt_check->rowCount() == 1) {
                            $result = $stmt_check->setFetchMode(PDO::FETCH_ASSOC);
                            foreach($stmt_check->fetchAll() as $row) {
                                unlink($_SERVER['DOCUMENT_ROOT']. $row['profile_img']);
                            }

                        } 
                        $stmt = $conn->prepare("UPDATE ".MAIN_DB_PREFIX."user_info SET profile_img = :dir WHERE id = :user_id; ");
                        $int_id = LOGIN_ID;
                        $stmt->bindParam(':dir', $newnamefinish);
                        $stmt->bindParam(':user_id', $int_id, PDO::PARAM_INT);
                        $stmt->execute();
                    }
                    else if ($_POST["SCMS-uploade-mode"] == 3) {
                        $page_name = $_POST['SCMS-uploade-page_id'];
                        try {
                            $conn = get_db_connection(MAIN_DB_HOST, MAIN_DB_DATABASE_NAME, MAIN_DB_USER, MAIN_DB_PASS);
                            $stmt = $conn->prepare("SELECT bgimg FROM ".MAIN_DB_PREFIX."text WHERE page_name = :page_id;");
                            $stmt->bindParam(':page_id', $page_name);
                            $stmt->execute();
                              // set the resulting array to associative
                            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                            if ($stmt->rowCount() > 0) {
                                foreach($stmt->fetchAll() as $row) {

                                    $stmt_2 = $conn->prepare("SELECT bgimg FROM ".MAIN_DB_PREFIX."text WHERE bgimg = :bgimg;");
                                    $stmt_2->bindParam(':bgimg', $row['bgimg']);
                                    $stmt_2->execute();

                                    $result = $stmt_2->setFetchMode(PDO::FETCH_ASSOC);
                                    if ($stmt_2->rowCount() == 1) {
                                        foreach($stmt_2->fetchAll() as $row_2) {
                                            unlink($_SERVER['DOCUMENT_ROOT']. '/' .$row_2['bgimg']); 
                                        }
                                    }
                                }
                              
                            }
                        }
                        catch(PDOException $e) {
                            $_SESSION["uploade_feedback"] = '<div class="row">
                            <div class="col-sm-12 alert alert-danger">
                            <strong>ERROR</strong> Der skete en fejl '.$e.'
                            </div>
                            </div>';
                        }
                        // uddate background img for at page. 
                        $stmt = $conn->prepare("UPDATE ".MAIN_DB_PREFIX."text SET bgimg = :dir WHERE page_name = :page_id ");
                        $stmt->bindParam(':dir', $newnamefinish);
                        $stmt->bindParam(':page_id', $page_name);
                        $stmt->execute();
                    }
                    else if ($_POST["SCMS-uploade-mode"] == 4) { 
                        // attach image to page or post (or somthing else)
                        $stmt = $conn->prepare("SELECT @this_show_order := (SELECT max(show_order) FROM ".MAIN_DB_PREFIX."images WHERE (user_id = :user_id) OR (user_id = 0)) + 1;
                                                INSERT INTO ".MAIN_DB_PREFIX."images (user_id, dir, uploaded, show_order, attached_group, attached_id)
                                                VALUES (:user_id, :dir, :uploaded, @this_show_order, :post_attached_group, :post_attached_id); ");
                        $int_id = LOGIN_ID;
                        $stmt->bindParam(':user_id', $int_id, PDO::PARAM_INT);
                        $stmt->bindParam(':dir', $newnamefinish);
                        $stmt->bindParam(':uploaded', $datomedtid);
                        $stmt->bindParam(':post_attached_id', $post_attached_id);
                        $stmt->bindParam(':post_attached_group', $post_attached_group);

                        $stmt->execute();
                    }

                    $target = $_SERVER['DOCUMENT_ROOT'].'/'.$newnamefinish;
                    $resize = $_SERVER['DOCUMENT_ROOT'].'/'.$newnamefinish;
                    $max_width = 1920; // maximum width of new file. Change it according to your need
                    $max_height = 1080; // maximum height of new file. Change it according to your need
                    img_resize($target, $resize, $max_width, $max_height, $imageFileType);
                    
                }
                catch(PDOException $e) {
                    $_SESSION["uploade_feedback"] = '<div class="row">
                    <div class="col-sm-8 alert alert-danger">
                    <strong>ERROR</strong> Der er sket en fejl
                    </div>
                    <div class="col-sm-4"></div>
                    </div>';
                }
                $stmt = null;
                $conn = null;
                
            } else {
                $_SESSION['uploade_feedback'] = "<div class='row'>
                            <div class='col-sm-12 alert alert-danger'>
                                <h4>Billedet er ikke uploaded</h4>
                                Der er desværre opstået en fejl. ".basename($_FILES["SCMS-uploade-upload"]["tmp_name"][$i]) ." new: ". $newnamefinish ." 
                            </div>
                            </div>";
                header('Location: /control/index');
            }
        }
    }
    if($_POST["SCMS-uploade-mode"] == 4) {
        header('Location: /control/site_editor?content_type='.$_SESSION["page_content_type"].'&id='.$_SESSION['page_parent_id']);
    }
    else {
        header('Location: /control/index');
    }
}
else {
    header('Location: /');
}
?>

