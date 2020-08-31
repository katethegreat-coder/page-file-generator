
<?php
    session_start();

    if(isset($_GET['id']) && !empty($_GET['id'])){

        // On a un id, on le récupère
        $projectId = $_GET['id'];

        // Connect to the database
        require_once('inc/connect.php');

        // Build the SQL query
        $sql='SELECT `project`.*, `pages`.`id` as pageid, GROUP_CONCAT(`pages`.`page_name`) as pageNames FROM `project` LEFT JOIN `pages` ON `project`.`id`=`pages`.`project_id` WHERE `project`.`id` =:id GROUP BY `project`.`id`;';

        $query = $db->prepare($sql);
        $query->bindValue(':id', $projectId, PDO::PARAM_INT);
        $query->execute();
        // Fetch data
        $project = $query->fetch(PDO::FETCH_ASSOC);

        // Disconnect from the DB
        require_once('inc/disconnect.php');

    } else {
        $_SESSION['error'] = 'Il n\'y a aucun projet avec cet id';
            header('Location: test.php');
            die;
       
    }

    
    // Get the inc files
    include_once('inc/head.php'); 
    include_once('inc/header.php'); 

?>
<style>
    body {
        background-color: #dfdce3;
    }
</style>

<div class="container project">

    <?php if(isset($_SESSION['error']) && !empty($_SESSION['error'])){ ?>
        <div class="row justify-content-center error_alert">
            <div class="jumbotron text-center py-4">
                <i class="fas fa-exclamation-circle mb-3" style="color: #e64827"></i>
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
        <div class="col-xl-6 p-0"  style="width: 20rem; border: 20px solid #F78733;">
            <div class="card ">
                <div style="width: 12rem;" class="m-auto py-5 h-100">
                    <img src="files/<?= $project['client_logo'] ?>" class="card-img-top w-100 h-auto" alt="Logo">
                </div>
                    <div class="card-body">
                        <h2 class="card-title font-weight-bold text-uppercase text-center mb-5" style="color: #4ABDAC;"><?= $project['client_name'] ?></h2>
                        <p class="card-text ml-4">Couleur du background de l'index</p>
                        <p class="ml-4"><i class="fas fa-chevron-circle-right" style="color: #4ABDAC;"></i> #<?= $project['background_color'] ?></p>
                    </div>
                    <div class="card-body py-1 my-1 offset-2">
                        <p class="">Pages :</p>
                    </div>
                    
                    <!-- Retrieve page names -->
                    <?php
                        $pages=explode(',', $project['pageNames']);
                        foreach($pages as $page): ?>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item offset-3"><i class="fas fa-chevron-circle-right mr-4" style="color: #4ABDAC;"></i><?= $page?></li>
                            </ul>
                    <?php endforeach; ?>

                <div class="card-body d-flex m-auto align-items-center py-5">
                    <form method="post" action="ajax.php">
                        <div style="width: 4rem;" class="mr-5 h-100 ">
                            <div type="submit" class="card-link zip-btn" id='download' value='Download'>
                                <img src="img/zip-format.png" alt="logo zip" class="p-1 w-100 h-auto">
                            </div>
                        </div>
                    </form>
                    <a href="page_generator.php"><button type="button" id="return" class="btn btn-secondary py-2" data-toggle="tooltip" data-placement="right" title="Attention, au retour à l'accueil, les données sont supprimées !">Accueil</button></a>
            </div>
        </div>
    </div>
</div>

<?php

    include_once('inc/footer.php'); 