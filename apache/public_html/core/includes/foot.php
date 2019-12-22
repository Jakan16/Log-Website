<?php
    echo '<footer class="container-fluid text-center">
    <div class="container" style="padding-top:25px;">© Copyright 2019 - '.date('Y').' '.GLOBAL_FIRM_NAME.' | All Rights Reserved </div></footer>'; 
    
    if (!empty($sidenspecialescript)) {
    	include $_SERVER['DOCUMENT_ROOT']. "/" .$sidenssti.$sidenspecialescript;
    }
?>

    </body>
</html>