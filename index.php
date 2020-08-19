<?php

    // Get the inc files
    include_once('inc/head.php'); 
       
?>

<div class="modal fade in welcome" data-backdrop="static" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header modal-title d-block pt-5">
                <div class="text-center">
                    <i class="fas fa-info-circle"></i>
                </div>
                <h4 class="modal-title font-weight-bold text-uppercase text-center">Bienvenue</h4>  
            </div>   
            <div class="modal-body px-5 py-4" id="message">
                <div class="d-flex">
                    <i class="fas fa-check mr-3 my-auto"></i>
                    <p>Le générateur de dossiers vous permet d'automatiser la création de dossiers projets.</p> 
                </div>
                <div class="d-flex">
                    <i class="fas fa-check mr-3 my-auto"></i>
                    <p>Remplissez le formulaire avec les informations et les documents requis.</p>
                </div>
                <div class="d-flex">
                    <i class="fas fa-check mr-3 my-auto"></i>
                    <p>Vous pourrez ensuite télécharger un zip avec tous les pages web nécessaires.</p>
                </div>
            </div>
            <div class="modal-footer p-4">
                <div class="mx-auto">
                    <a href="page_generator.php"><div class="btn btn-secondary cta">Débuter</div></a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

    include_once('inc/footer.php'); 