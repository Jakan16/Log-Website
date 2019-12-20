<?php
/** Sandsized CMS - By Guld-berg.dk software technologies
*  Developed by Jørn Guldberg
*  Copyright (C) Jørn Guldberg - Guld-berg.dk All Rights Reserved. 
*  Version 6.1.1: Release of major, not compatiple with earlier realises. 
*  Full release-notes se the git repository
*/

$page_permission = 1; // only admins
require_once $_SERVER['DOCUMENT_ROOT']."/core/system_core.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $zip_file_name = $_SERVER['DOCUMENT_ROOT'] . "/". GLOBAL_BACKUP_FILE_NAME."-" . date("Y-m-d-H-i-s") . '.zip';

        $backup_file = $_SERVER['DOCUMENT_ROOT'] . "/".MAIN_DB_DATABASE_NAME."-". date("Y-m-d-H-i-s") . '.sql';
        $command = "mysqldump --opt -h ".MAIN_DB_HOST." -u ".MAIN_DB_USER." -p".MAIN_DB_PASS." ".MAIN_DB_DATABASE_NAME." | cat > $backup_file";
       
        system($command);

        
        // Get real path for our folder
        $rootPath = $_SERVER['DOCUMENT_ROOT']; 

        // Initialize archive object
        $zip = new ZipArchive();
        $zip->open($zip_file_name, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        // Create recursive directory iterator
        /** @var SplFileInfo[] $files */
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($rootPath),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $name => $file)
        {
            // Skip directories (they would be added automatically)
            if (!$file->isDir())
            {
                // Get real and relative path for current file
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($rootPath) + 1);

                // Add current file to archive
                $zip->addFile($filePath, $relativePath);
            }
        }

        // Zip archive will be created only after closing object
        $zip->close();
        unlink($backup_file);
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($zip_file_name).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($zip_file_name));
            readfile($zip_file_name);
            sleep(2);
        }
        unlink($zip_file_name);

        $_SESSION["uploade_feedback"] = '<div class="row">
        <div class="col-sm-12 alert alert-success">
        <strong>SUCCESS</strong> Handlingen er gennemført
        </div>
        </div>';
        header("location: /control/master_control");
}
else {
    header("location: /");
}
?>
