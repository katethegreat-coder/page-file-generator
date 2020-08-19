<?php

  session_start();
  // Create a zip 

  // Get real path of the "files" directory
  $rootPath = realpath('files');

  // Check if the "files" directory exists and is not empty
  if(is_dir($rootPath)) {

    // List folders files
    $filesList = array_diff(scandir($rootPath), array('..', '.'));

    if(empty($filesList)){
        $_SESSION['error'] = 'Le dossier est vide';
          header('Location: test.php');
          die;
        
      
    }else{
  
      // Define the file name
      $filename = "zip/file.zip";
  
      // Initialize an archive object
      $zip = new ZipArchive();
  
      // Define where the zip will be stored
      $zip->open($filename, ZipArchive::CREATE | ZipArchive::OVERWRITE );
      
      // Create "recursive directory iterator" to iterate recursively over filesystem directories, here "files" 
      /** @var SplFileInfo[] $files */
      $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($rootPath), RecursiveIteratorIterator::LEAVES_ONLY);
      
      // Loop on files
      foreach ($files as $name => $file){

        // Skip the directory
        if (!$file->isDir()){

            // Get real and relative path for current files
            $filePath = $file->getRealPath();
            $relativePath = substr($filePath, strlen($rootPath) + 1);
    
            // Add current files to archive
            $zip->addFile($filePath, $relativePath);
        }
      }
      
      // Zip archive will be created only after closing the object
      $zip->close();
      echo $filename;

    }

  } else{
      $_SESSION['error'] = 'Il ne s\'agit pas d\'un dossier';
            header('Location: test.php');
            die;

  }

