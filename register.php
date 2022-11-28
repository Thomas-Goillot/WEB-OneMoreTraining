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
                    <div class="col-md-6 col-sm-12 col-lg-12 align-self-center">
                        <div class="sign-user_card ">
                            <div class="d-flex justify-content-center">
                            </div>
                            <div class="sign-in-page-data">
                                <div class="sign-in-from w-100 pt-5 m-auto">

                                    <form id="regForm" method="POST" action="../signup-check.php">
                                        <div class="container">

                                            <!-- STEP 1 -->
                                            <div class="tab">
                                                <h1 class="text-center mb-3">Inscrivez-vous et commencez à vous
                                                    entrainer!</h1>
                                                    <?php 
                                                        if(isset($_GET) && !empty($_GET['err']))
                                                        {
                                                            echo '<div class="alert alert-danger" role="alert">'.$_GET['err'].'</div>';
                                                        }
                                                    ?>

                                                <div class="row align-items-center">
                                                    <div class="col-lg-7">

                                                        <div class="row mb-3">
                                                            <div class="form-text mb-2">
                                                                Informations personnelles (Obligatoire)
                                                            </div>
                                                            <div class="col">
                                                                <div class="form-floating mb-3">
                                                                    <input type="text" class="form-control"
                                                                        id="firstnameinput" placeholder="Prénom"
                                                                        name="firstnameinput">
                                                                    <label for="floatingInput">Prénom</label>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="form-floating mb-3">
                                                                    <input type="text" class="form-control"
                                                                        id="lastnameinput" placeholder="Nom"
                                                                        name="lastnameinput">
                                                                    <label for="floatingInput">Nom</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <div class="form-text mb-2">
                                                                Votre date de naissance (Obligatoire)
                                                            </div>
                                                            <div class="col">
                                                                <div class="form-floating mb-3">
                                                                    <input type="number" class="form-control"
                                                                        id="dayinput" placeholder="Jour"
                                                                        name="dayinput">
                                                                    <label for="dayinput">Jour</label>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="form-floating mb-3">
                                                                    <input type="number" class="form-control"
                                                                        id="monthinput" placeholder="01"
                                                                        name="monthinput">
                                                                    <label for="monthinput">Mois</label>
                                                                </div>
                                                                <!-- 
                                                                <label for="exampleDataList" class="form-label">Datalist example</label>
                                                                <input class="form-control" list="datalistOptions" id="exampleDataList" placeholder="Type to search...">
                                                                <datalist id="datalistOptions">
                                                                    <option value="San Francisco">
                                                                    <option value="New York">
                                                                    <option value="Seattle">
                                                                    <option value="Los Angeles">
                                                                    <option value="Chicago">
                                                                </datalist> -->
                                                            </div>
                                                            <div class="col">
                                                                <div class="form-floating mb-3">
                                                                    <input type="number" class="form-control"
                                                                        id="yearinput" placeholder="Année"
                                                                        name="yearinput">
                                                                    <label for="yearinput">Année</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <div class="form-text mb-2">
                                                                Votre adresse mail (Obligatoire)
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-lg-9">
                                                                    <div class="form-floating">
                                                                        <input type="mail" class="form-control"
                                                                            id="mailinput" placeholder="Adresse mail"
                                                                            name="mail1input">
                                                                        <label for="mailinput">Adresse Mail</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-lg-9">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="mail" class="form-control"
                                                                            id="mail2input"
                                                                            placeholder="Confirmez votre adresse mail"
                                                                            name="mail2input">
                                                                        <label for="mailinput">Confirmation adresse
                                                                            mail</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-5 d-none d-lg-block ">
                                                        <img src="/assets/img/logo_black.png" class="img-fluid" alt="">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- STEP 2 -->
                                            <div class="tab">
                                                <h1 class="text-center mb-5">Contact</h1>

                                                <div class="row align-items-center">
                                                    <div class="col-lg-7">

                                                        <div class="row mb-3">
                                                            <div class="form-text mb-2">
                                                                Numéro de téléphone (Facultatif)
                                                            </div>
                                                            <div class="col">
                                                                <div class="form-floating mb-3">
                                                                    <input type="text" class="form-control"
                                                                        id="phoneinput"
                                                                        placeholder="Numéro de téléphone"
                                                                        name="phoneinput">
                                                                    <label for="phoneinput">Numéro de téléphone</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <div class="form-text mb-2">
                                                                Séléctionnez votre genre (Obligatoire)
                                                            </div>
                                                            <div class="col">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        id="type1input" value="Homme" name="typeinput">
                                                                    <label class="form-check-label"
                                                                        for="type1input">Homme</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        id="type2input" value="Femme" name="typeinput">
                                                                    <label class="form-check-label"
                                                                        for="type2input">Femme</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        id="type3input" value="autres" name="typeinput">
                                                                    <label class="form-check-label" for="type3input">
                                                                        Non Renseigné</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <div class="form-text mb-2">
                                                                Mot de passe (Obligatoire)
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col">
                                                                    <div class="form-floating">
                                                                        <input type="password" class="form-control"
                                                                            id="pwdinput" placeholder="Mot de passe"
                                                                            name="pwd1input">
                                                                        <label for="pwdinput">Mot de passe </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="password" class="form-control"
                                                                            id="pwd2input"
                                                                            placeholder="Confirmez votre mot de passe"
                                                                            name="pwd2input">
                                                                        <label for="pwd2input">Confirmation mot de
                                                                            passe</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="col-5 d-none d-lg-block ">
                                                        <img src="/assets/img/logo_black.png" class="img-fluid" alt="">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <div class="mx-auto d-block">
                                                <span class="step bg-secondary"></span>
                                                <span class="step bg-secondary"></span>
                                            </div>
                                            <div class="sign-info">
                                                <button type="button" class="btn btn-secondary mb-3" id="prevBtn"
                                                    onclick="nextPrev(-1)">Retour</button>
                                                <button type="button" class="btn btn-primary" id="nextBtn"
                                                    name="sign_up_form" onclick="nextPrev(1)">Suivant</button>
                                                <!--<button type="button" class="btn btn-primary" id="nextBtn"
                                                name="sign_up_form">Finaliser l'inscription plus tard</button> -->
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <div class="d-flex justify-content-center links">
                                                Déjà un compte?&nbsp;
                                                <a href="login.php" class="ml-2">Se connecter</a>
                                            </div>
                                        </div>
                                    </form>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <script src="/assets/js/multiplestep.js"></script>
    <?php 
        include('includes/include-script.php');
    ?>
</body>

</html>