<?php
session_start();
    // Check the form
    if(isset($_POST) && !empty($_POST)){

        // Get the form verification function
        require_once('./inc/lib/checkForm.php');
        // Get the data cleaning function
        require_once('inc/lib/dataCleaning.php');

        
        // Check if the form is complete
        if(checkForm($_POST, ['client', 'color', 'navColor'])){

            // Clean retrieved client data
            $client = dataCleaning($_POST['client']);
            // Check if the client name is at least 2 characters
            if(mb_strlen($client) < 2 ){
                // echo'Le nom du client doit comporter au moins 2 caractères';
                $_SESSION['error'] = 'Le fichier doit être une image png ou jpg';
                header('Location: page_generator.php');
                die;
            }

            // Clean retrieved color data
            $color = dataCleaning($_POST['color']);
            // Remove possible # before the color
            $colorCode= ltrim($color, '#');
            // Check if all of the characters are from 3 to 6 hexadecimal digits. 
            if (!(ctype_xdigit($colorCode) && (strlen($colorCode) == 6 || strlen($colorCode) == 3))) {
                $_SESSION['error'] = 'La couleur doit être au format hexadécimal';
                header('Location: page_generator.php');
                die;
            } 

            // Clean retrieved nav color data
            $navcolor = dataCleaning($_POST['navColor']);
            // Allocate a hexadecimal code for the color
            if ($navcolor == '1') {
                $navcolor='#000000';
            } elseif ($navcolor == '2') {
                $navcolor='#FFFFFF';
            } else {
                $_SESSION['error'] = 'Merci de choisir une couleur de de barre de navigation';
                header('Location: page_generator.php');
                die;
            }

             // Check if the logo was uploaded 
            if(isset($_FILES['logo']) && !empty($_FILES['logo']) && $_FILES['logo']['error'] != 4){

                $logo=$_FILES['logo'];

                // In case of an error
                if($logo['error'] != 0 ){
                    $_SESSION['error'] = 'Une erreur est survenue durant le téléchargement';
                    header('Location: page_generator.php');
                    die;
                }

                // Check the type of the file
                $type1 = ['image/jpeg', 'image/png', 'image/svg'];
                if(!in_array($logo['type'], $type1)){
                    $_SESSION['error'] = 'Le fichier doit être une image png, jpg ou svg';
                    header('Location: page_generator.php');
                    die;
                }

                // Create the logo file with the client name
                $extension_logo = strtolower(pathinfo($logo['name'], PATHINFO_EXTENSION));
                $fileName_logo = 'logo'.'.'.$client. '.' . $extension_logo;
                $completeName_logo = __DIR__ . '/files/' . $fileName_logo;


                if(isset($_POST['itemField']) && !empty($_POST['itemField'])){

                    $total_itemFields = count($_POST['itemField']);
    
                    for($i = 0; $i < $total_itemFields; $i++) {
                        // Clean retrieved client data
                        $pageName= array_map("dataCleaning", $_POST['itemField']);                       
                    }
    
                    // Check files 
                    if(isset($_FILES['userfile']['name'])) {
    
                        // Count the number of uploaded files
                        $total_files = count($_FILES['userfile']['name']);
                        $files=$_FILES['userfile'];
                        
                        // Loop on uploaded files
                        for($i = 0; $i < $total_files; $i++) {
                            
                            // Check if files are uploaded
                            if(isset($_FILES['userfile']['name'][$i]) && $_FILES['userfile']['size'][$i] > 0) {
                            
                                // Set Upload Path
                                $target_dir = 'files/'; 
    
                                // Set the original name of files
                                $original_filename = $_FILES['userfile']['name'][$i];
    
                                // Get file extensions 
                                $extension = pathinfo($original_filename, PATHINFO_EXTENSION); 
    
                                // // Get file names without the extension
                                $filename_without_extension = basename($original_filename, '.'.$extension);
    
                                // Generate new file names // Replace wityh variable to change name
                                $new_filename = str_replace('', '_', $filename_without_extension) . '.' . $extension; 
    
                                // Get files extension
                                $extension = strtolower(pathinfo($_FILES["userfile"]["name"][$i], PATHINFO_EXTENSION));
                                        
                                // Check the file types and then save files
                                if( in_array( $extension, array('jpg', 'jpeg'))) {
                            
                                    for($key = 0; $key < $total_files; $key++) {
                                        $page_title = $_POST['itemField'][$key];
                                        $file_name = $_FILES['userfile']['name'][$key];
    
                                        if (move_uploaded_file($_FILES['userfile']['tmp_name'][$key], $target_dir . $page_title .'.'. $extension)){
                                            $htmlPage= '
                                                <!DOCTYPE html>
                                                <html lang="fr">
                                                <head>
                                                    <meta charset="UTF-8">
                                                    <meta name="viewport" content="width=device-width, initial-scale=1.0">

                                                    <link rel="icon" href="img/favicon/favicon.ico" />
                                                    <title>'.$client.'® | '.$page_title.' | Maquette Site Internet</title>
                                                </head>
                                                <body>
                                                    <img src="'.$page_title.'.'. $extension.'" alt="maquette'. $client.'">
                                                </body>
                                                </html>
                                                ';
    
                                            $open = fopen('files/'.$page_title.'.html','w');
                                            fwrite($open, $htmlPage);
                                            fclose($open);
                                        } 
                                    }

                                    // Copy the file
                                    if (move_uploaded_file($_FILES['userfile']['tmp_name'][$key], $target_dir . $page_title .'.'. $extension)){
                                        $htmlPage= '
                                            <!DOCTYPE html>
                                            <html lang="fr">
                                            <head>
                                                <meta charset="UTF-8">
                                                <meta name="viewport" content="width=device-width, initial-scale=1.0">

                                                <link rel="icon" href="img/favicon/favicon.ico" />
                                                <title>'.$client.'® | '.$page_title.' | Maquette Site Internet</title>
                                            </head>
                                            <body>
                                                <img src="'.$page_title.'.'. $extension.'" alt="maquette'. $client.'">
                                            </body>
                                            </html>
                                            ';

                                        $open = fopen('files/'.$page_title.'.html','w');
                                        fwrite($open, $htmlPage);
                                        fclose($open);
                                    } 

                                    // Copy the file
                                    if((move_uploaded_file($logo['tmp_name'], $completeName_logo))){
                                            
                                        $indexHtmlPage1= '
                                            <!DOCTYPE html>
                                            <html lang="fr">
                                            <head>
                                                <meta charset="UTF-8">
                                                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                                <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
                                                <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
                                                <link rel="icon" href="img/favicon/favicon.ico" />

                                                <title>'.$client.'® | Maquette Site Internet</title>
                                            </head>

                                            <body style="background-color: #'.$colorCode.';">
                                                <div class="container">
                                                    <div class="row justify-content-center mt-5">
                                                        <div class="col-xl-6 mt-5">
                                                            <div class="row logo mx-auto" style="width: 12rem; height: auto;">
                                                                <img src="'.$fileName_logo.'" alt="logo '.$client.'" class="w-100 h-auto">
                                                            </div>
                                                            <div class="row justify-content-center mt-5">
                                                                <ul class="nav justify-content-center font-weight-bold">
                                                                
                                        ';

                                        $fileNames = array_map(
                                            function($filePath) {
                                                return basename($filePath);
                                            },
                                            glob('./files/*.{html}', GLOB_BRACE)
                                        );

                                        $list = '';

                                        foreach($fileNames as $filename) {

                                            $list.='

                                                <li class="nav-item">
                                                    <a class="nav-link" href="'.$filename.'" target="_blank" style="text-transform: capitalize; color: '.$navcolor.';">'. strstr($filename, '.', true).'</a>
                                                </li>

                                            ';
                                        }    

                                        $indexHtmlPage2='
                                                                    
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </body>
                                            </html>
                                        ';

                                        $indexHtmlPage= $indexHtmlPage1.$list.$indexHtmlPage2;

                                        $newFile ='index';
                                        $open = fopen('files/'.$newFile.'.html','w');
                                        fwrite($open, $indexHtmlPage);
                                        fclose($open);

                                        // Connect to the database to save all data into a DB
                                        require_once('inc/connect.php');

                                        // Build the SQL query
                                        $sql= 'INSERT INTO `project`(`client_name`, `client_logo`, `background_color`, `nav_color`) VALUES(:clientName, :clientLogo, :backgroundColor, :navColor);';
                                        
                                        // Prepare the query to avoid SQL injections
                                        $query = $db->prepare($sql);
                                        
                                        // Bind values retrieved from the form and the DB
                                        $query->bindValue(':clientName', dataCleaning ($client), PDO::PARAM_STR);
                                        $query->bindValue(':clientLogo', $fileName_logo, PDO::PARAM_STR);
                                        $query->bindValue(':backgroundColor', dataCleaning ($colorCode), PDO::PARAM_STR);
                                        $query->bindValue(':navColor', dataCleaning ($navcolor), PDO::PARAM_STR);
                                        
                                        // Execute the query
                                        $query->execute();
                                        
                                        // Get the id of the previous entry inserted
                                        $projectId = $db->lastInsertId();
                                       
                                        
                                        // Run through arrays with page names and uploaded files
                                        for($key = 0; $key < $total_files; $key++) {
                                            $page_title = $_POST['itemField'][$key];
                                            $file_name = $_FILES['userfile']['name'][$key];
                                            $mockUp = $page_title .'.'. $extension;

                                            $sql='INSERT INTO `pages`(`page_name`, `mock-up`, `project_id`) VALUES (:pageName, :mockUp, :projectId) ;';
                                            $query = $db->prepare($sql);
                                            $query->bindValue(':pageName', dataCleaning ($page_title), PDO::PARAM_STR);
                                            $query->bindValue(':mockUp', dataCleaning ($mockUp), PDO::PARAM_STR);
                                            $query->bindValue(':projectId', $projectId, PDO::PARAM_INT);
                                            $query->execute();
                                        }
                                        
                                        // Redirection to the project view page
                                        header("Location: project_view.php?id=".$projectId); 

                                    } 
    
                                } else {
                                    $_SESSION['error'] = 'Le fichier doit être une image en jpg';
                                    header('Location: page_generator.php');
                                    die;
                                }
                            } else {
                                $_SESSION['error'] = 'Merci de choisir une maquette en jpg';
                                header('Location: page_generator.php');
                                die;
                            }
                        }
                    }
                }
            } 
            else {
                $_SESSION['error'] = 'Merci de choisir un logo';
                header('Location: page_generator.php');
                die;
            }

        } else {
            $_SESSION['error'] = 'Merci de remplir tous les champs';
            header('Location: page_generator.php');
            die;
        }                   
    } 

    // Disconnect from the DB
    require_once('inc/disconnect.php');

    // Get the inc files
    include_once('inc/head.php'); 
    include_once('inc/header.php');

?>

<div class="container pt-perspective">
    <?php if(isset($_SESSION['error']) && !empty($_SESSION['error'])){ ?>
        <div class="row justify-content-center error_alert">
            <div class="jumbotron text-center py-4">
                <i class="fas fa-exclamation-circle mb-3" style="color: #F78733;"></i>
                <h3 class="display-4 mb-3">Erreur</h3>
                <p class="lead mb-5">
                    <?php 

                        echo $_SESSION['error'];
                        unset($_SESSION['error']);

                    ?>
                </p>
                <button class="btn btn-secondary btn-sm btn-error">ok</button>
            </div>
        </div>
    <?php    
    }
    ?>
    <div class="row justify-content-center">
        <form class="form col-xl-6"  method="post" enctype="multipart/form-data">

            <!-- Client name -->
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <button class="btn btn-outline-secondary" type="button" id="client">Client</button>
                </div>
                <input type="text" class="form-control" placeholder="" id="client" name="client" style="color: #e64827">
            </div>
        
            <!-- Client logo -->
            <div class="input-group mb-5">
                <div class="input-group-prepend">
                    <button class="btn btn-outline-secondary" type="button" id="logo" title="à nommer logo">Logo</button>
                </div>
                <div class="custom-file">
                    <input type="file" class="custom-file-input logo_file" id="logo" name="logo" title="à nommer logo">
                    <label class="custom-file-label label_logo" for="logo" data-browse="Parcourir">Choisissez un fichier</label>
                </div>
            </div>

            <!-- Index background color -->
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <button class="btn btn-outline-secondary" type="button" id="color">Couleur</button>
                </div>
                <input type="text" class="form-control" placeholder="Couleur de fond de l'index en format hexadécimal" id="color" name="color" style="color: #e64827">
            </div>

            <!-- Index nav color -->
            <div class="input-group mb-5">
                <div class="input-group-prepend">
                    <button class="btn btn-outline-secondary" type="button">Menu</button>
                </div>
                <select class="custom-select" id="navColor" name="navColor">
                    <option selected>Choisissez la couleur du menu</option>
                    <option value="1">Noir</option>
                    <option value="2">Blanc</option>
                </select>
            </div>

            <!-- Page names -->
            <div class="input-group mb-3" id="newItemForm">
                <div class="input-group-prepend">
                    <button class="btn btn-outline-secondary" type="button">Noms des pages</button>
                </div>
                <div style="width: 19.938rem;">
                    <input type="text" class="form-control itemField" name="itemField"  placeholder="Indiquez le nom des pages" style="color: #e64827">
                </div>
                <div>
                    <button id="add" class="btn input-group-text">Ajouter</button>
                </div>
            </div>
            <div id="newItemFormField">
                <div class="input-group page-name-file">
                    <input class="item-name form-control my-2" type="text" value="accueil" name="itemField[]"/>
                    <div class="custom-file upload_file my-2">
                        <input name="userfile[]" class="custom-file-input item-file form-control" type="file" multiple/>
                        <label class="custom-file-label label_fileName" for="userfile" data-browse="Parcourir">Choisissez un jpg </label>
                    </div>
                    <div class="m-auto pl-2">
                        <button type="button" class="close remove" aria-label="Close" title="Cliquer pour supprimer">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
            <div id="newItemButton">
                <button href="#">go</button>
            </div>

            <!-- Button -->
            <div class="text-center mt-5">
                <button class="btn btn-secondary">Générer</button>
            </div>
            
        </form>
    </div>
</div>

<?php

    include_once('inc/footer.php'); 