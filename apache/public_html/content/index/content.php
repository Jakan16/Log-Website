<div class="container-fluid text-center">
    <h1 style="padding-top: 10%; color: white;">LogOps™</h1>
    <h2 style="padding-bottom: 10%; color: white;">A Cloud and Security hybrid system</h2>
</div>

<div class="container-fluid GLOBALdesign">
    <div class="row">
        <div class="col-sm-4 text-center">
            <h1><span class="glyphicon glyphicon-open-file"></span></h1>
            <h1>Upload your code to analyse logs</h1>
        </div>
        <div class="col-sm-4 text-center">
            <h1><span class="glyphicon glyphicon-search"></span></h1>
            <h1>Search in your logs</h1>
        </div>
        <div class="col-sm-4 text-center">
            <h1><span class="glyphicon glyphicon-fire"></span></h1>
            <h1>Get notified when alarm is raised, and handle them in our interface. </h1>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1><span class="glyphicon glyphicon-transfer"></span></h1>
                <h1>Buy a subscibtion rigth away</h1>
                <h2>Download our agent, uploade your code, and you are ready.</h2>
            </div>
            Billede af <a href="https://pixabay.com/da/users/TheDigitalArtist-202249/?utm_source=link-attribution&amp;utm_medium=referral&amp;utm_campaign=image&amp;utm_content=3400789">Pete Linforth</a> fra <a href="https://pixabay.com/da/?utm_source=link-attribution&amp;utm_medium=referral&amp;utm_campaign=image&amp;utm_content=3400789">Pixabay</a>
        </div>
    </div>
</div>

<?php
/*
    $conn = get_db_connection(MAIN_DB_HOST, MAIN_DB_DATABASE_NAME, MAIN_DB_USER, MAIN_DB_PASS);
    $stmt = $conn->prepare("SELECT ".MAIN_DB_PREFIX."navi_name.name, ".MAIN_DB_PREFIX."text.text, ".MAIN_DB_PREFIX."navi.permission
            FROM ".MAIN_DB_PREFIX."navi_name 
            INNER JOIN ".MAIN_DB_PREFIX."text ON ".MAIN_DB_PREFIX."navi_name.parent_id=".MAIN_DB_PREFIX."text.parent_id
            INNER JOIN ".MAIN_DB_PREFIX."navi ON ".MAIN_DB_PREFIX."navi.id=".MAIN_DB_PREFIX."navi_name.parent_id
            WHERE ".MAIN_DB_PREFIX."navi.link = 'index' AND ".MAIN_DB_PREFIX."navi_name.language = ? AND link != place;");
    $stmt->execute(array($_SESSION['session_language']));
            // set the resulting array to associative
    if ($stmt->rowCount() == 1) 
    {
        foreach($stmt->fetchAll() as $row) 
        {
            if (check_permission($row['permission']) )
            {
                echo $row['text'];
            }
            else 
            {
                echo "<h2>Page is under construction</h2>";
            }
        }
    }
    else 
    {
        echo "<h2>Error 404</h2> Siden er ikke fundet";
    }
*/
?>