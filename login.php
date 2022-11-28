<?php
/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

    include('includes/include-info.php');

    include('includes/include-head.php');
?>

<body>

    <main>
        <section class="sign-in-page">
            <div class="container">
                <div class="row justify-content-center align-items-center height-self-center">
                    <div class="col-md-6 col-sm-12 col-12 align-self-center">
                        <div class="sign-user_card ">
                            <div class="d-flex justify-content-center">
                            </div>
                            <div class="sign-in-page-data">
                                <div class="sign-in-from w-100 pt-5 m-auto">
                                    <h1 class="mb-3 text-center">Connexion</h1>
                                    <?php 
                                    if(isset($_GET) && !empty($_GET['err']))
                                    {
                                        echo '<div class="alert alert-danger" role="alert">'.$_GET['err'].'</div>';
                                    }
                                    ?>
                                    
                                    <form class="mt-4" method="POST" action="signin-check.php">
                                        <div class="form-floating mb-3">
                                            <input type="mail" class="form-control" placeholder="Adresse Mail"
                                                name="mailinput">
                                            <label for="floatingInput">Adresse Mail</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control" placeholder="mot de passe"
                                                name="pwdinput">
                                            <label for="floatingInput">mot de passe</label>
                                        </div>
                                        <button type="button" class="btn btn-primary mb-2"                                         data-bs-toggle="modal" data-bs-target="#captcha-modal">Captcha
                                        </button>
                                        <input type="hidden" name="captcha_validation" id="captcha_validation" value="false">
                                        <div class="sign-info">
                                            <button type="ssubmit" name="sign_in_form"
                                                class="btn btn-primary mb-2" value="false" id="check_captcha">Connexion</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="mt-2">
                                <div class="d-flex justify-content-center link">
                                    Pas de compte?&nbsp;<a href="register.php" class="ml-2">S'inscrire</a>
                                </div>
                                <!--  <div class="d-flex justify-content-center links">
                                        <a href="#">Mot de passe oublié ?</a>
                                    </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Modal -->
        <div class="modal fade" id="captcha-modal" tabindex="-1" aria-labelledby="captcha-modal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="captcha-modal">Captcha Puzzle</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="command-detail-content">
                    <?php 
                        include('includes/include-captcha.php');
                    ?>
                    </div>
                </div>
            </div>
        </div>
        
    </main>
    <?php 
        include('includes/include-script.php');
    ?>
    <script src="assets/js/captcha.js"></script>
</body>

</html>