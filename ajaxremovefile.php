<?php

    /* Remove the Zip after redirection to the homepage */

    // Get the real path of the file
    $zipFile = realpath('zip/file.zip');

    if(file_exists($zipFile)){
        unlink($zipFile);
    }

    /* Delete all uploaded files after redirection to the homepage */

    // Folder path to be cleaned
    $folderFilesPath = 'files';
    // List of files names to be deleted
    $files = glob($folderFilesPath.'/*');  

    // Loop to delete all files
    foreach($files as $file) { 
    
        if(is_file($file))  
        
            // Delete the given file 
            unlink($file);  
    } 

    /* Delete all DB tables' content after redirection to the homepage */

    // Connect to the database
    require_once('inc/connect.php');

    // Delete the content of the table "pages" 
    $sql='DELETE FROM `pages`;';
    $query = $db->query($sql);

    // Delete the content of the table "project"
    $sql='DELETE FROM `project`;';
    $query = $db->query($sql);

    // Disconnect from the DB
    require_once('inc/disconnect.php');