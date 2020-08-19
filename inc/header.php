<style>   
    .slideInDown {
        -webkit-animation-name: slideInDown;
        animation-name: slideInDown;
        -webkit-animation-duration: 1s;
        animation-duration: 1s;
        -webkit-animation-fill-mode: both;
        animation-fill-mode: both;
    }
    @-webkit-keyframes slideInDown {
        0% {
        -webkit-transform: translateY(-100%);
        transform: translateY(-100%);
        visibility: visible;
        }

        100% {
        -webkit-transform: translateY(0);
        transform: translateY(0);
        }
    }
    @keyframes slideInDown {
        0% {
        -webkit-transform: translateY(-100%);
        transform: translateY(-100%);
        visibility: visible;
        }

        100% {
        -webkit-transform: translateY(0);
        transform: translateY(0);
        }
    } 

</style>

<header class="container-fluid header">
    <div class="row justify-content-center my-5 pb-3 title">
        <div class="col-xl-12 my-auto text-center slideInDown ">
            <h1 class="font-weight-bold text-uppercase">Générateur de dossiers</h1>
        </div>
    </div>
</header>