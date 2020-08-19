        <style>

            .slideInUp {
                -webkit-animation-name: slideInUp;
                animation-name: slideInUp;
                -webkit-animation-duration: 1s;
                animation-duration: 1s;
                -webkit-animation-fill-mode: both;
                animation-fill-mode: both;
            }

            @-webkit-keyframes slideInUp {
                0% {
                -webkit-transform: translateY(100%);
                transform: translateY(100%);
                visibility: visible;
                }

                100% {
                -webkit-transform: translateY(0);
                transform: translateY(0);
                }
            }
            @keyframes slideInUp {
                0% {
                -webkit-transform: translateY(100%);
                transform: translateY(100%);
                visibility: visible;
                }
                
                100% {
                -webkit-transform: translateY(0);
                transform: translateY(0);
                }
            } 

        </style>
        
        <footer class="footer fixed-bottom">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-xl-2 m-2">
                        <div class="logo mx-auto slideInUp">
                            <img src="img/LOGO CODING & CO - 500.png" alt="logo Aurélie Rodrigues Dutrey - Coding & Co">
                        </div>
                    </div>
                </div>
            </div>
        </footer>



    
        <!-- JQuery -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

        <!-- Bootstrap -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
            
        <!-- script -->
        <script src="js/script.js"></script>
    </body>
</html>

