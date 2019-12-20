<?php
$get_req_string = "";
if (strlen($_GET["req"]) <= 4096) {
    $req_array = explode('/', $_GET["req"]);
}
else {
    $req_array = array("Error");
}

if (count($req_array) == 1) {
    //$get_page_name = rawurlencode((str_replace(".php", "",$req_array[0])));
    $get_req_string = count($req_array);
}
else if (count($req_array) > 1) {
    $get_page_name = rawurlencode($req_array[0]);
    $get_req_string = rawurlencode(str_replace(".php", "",$req_array[1]));
}
else {
    $get_page_name = "error";
}

try {
    $conn = get_db_connection(MAIN_DB_HOST, MAIN_DB_DATABASE_NAME, MAIN_DB_USER, MAIN_DB_PASS);
    $stmt = $conn->prepare("SELECT ".MAIN_DB_PREFIX."navi_name.name, ".MAIN_DB_PREFIX."text.text, ".MAIN_DB_PREFIX."navi.permission
                            FROM ".MAIN_DB_PREFIX."navi_name 
                            INNER JOIN ".MAIN_DB_PREFIX."text ON ".MAIN_DB_PREFIX."navi_name.parent_id=".MAIN_DB_PREFIX."text.parent_id
                            INNER JOIN ".MAIN_DB_PREFIX."navi ON ".MAIN_DB_PREFIX."navi.id=".MAIN_DB_PREFIX."navi_name.parent_id
                            WHERE ".MAIN_DB_PREFIX."navi.link = ? AND ".MAIN_DB_PREFIX."navi_name.language = ? AND link != place;");
    $stmt->execute(array($get_page_name, $_SESSION['session_language']));
    if ($stmt->rowCount() == 1) 
    {
        foreach($stmt->fetchAll() as $row) 
        {
            if (check_permission($row['permission']) )
            {
                $date_from_db_page_name = $row['name'];
                $date_from_db_page_text = $row['text'];
            }
            else 
            {
                $web_page_name = "Siden ikke fundet";
                $date_from_db_page_text = "<h2>Error 404</h2> Siden er ikke fundet";
            }
        }

        $web_page_name = $date_from_db_page_name; // Sidens navn, dette navn afgører hvilken fane i menuen der er aktiv. (Skal være identisk med det i Mysql)
    }
    else {
        $web_page_name = "Siden ikke fundet";
        $date_from_db_page_text = "<h2>Error 404</h2> Siden er ikke fundet" . $get_page_name . "bob";
        //header('Location: /');
    }
}
catch(PDOException $e) {
    $date_from_db_page_text = "Error";
    //header('Location: /');
}
$stmt = null;
$conn = null;
?>