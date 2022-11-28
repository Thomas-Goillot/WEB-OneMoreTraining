<header>
    <div class="container-fluid">
        <nav
            class="navbar p-3 <?php if($actual_page != "index.php"){echo "bg-light";}?> navbar-color navbar-expand-lg fixed-top d-flex flex-wrap align-items-center justify-content-lg-center" id="navbar-bg-light">
            <a href="/"
                class="d-flex align-items-center justify-content-lg-center mb-2 mb-lg-0 text-dark text-decoration-none" width="80" height="50">
                <img src="assets/img/logo_black.png" width="80" height="50" role="img" class="logo-img bi me-2">
            </a>
            <span class="vertical bd-light d-none d-lg-block"></span>

            <button class="navbar-toggler navbar-light border-0" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="/" class="nav-link px-2 link-dark">Accueil</a></li>
                    <li><a href="#" class="nav-link px-2 link-dark">Entrainements</a></li>
                    <li><a href="Shop/shop.php" class="nav-link px-2 link-dark">Boutique</a></li>
                </ul>

                <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
                    <input type="search" class="form-control" placeholder="Search..." aria-label="Search">
                </form>

                <div class="form-check form-switch col-12 col-lg-auto mb-3 mb-lg-0">
                    <input class="form-check-input" type="checkbox" id="lightSwitch" />
                </div>

                <a class="nav-link px-2 link-dark" href=""><i class=" bi bi-bell fs-4"></i></a>

                <div class="dropdown px-5">
                    <a class="link-dark dropdown-toggle text-decoration-none" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        <?= load_avatar($bdd, $_SESSION['id_user'], 50, 50);?>
                        <!-- <img src="assets/img/user/user.png" alt="mdo" width="50" height="50" class="rounded-pill"> -->
                    </a>

                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li><a class="dropdown-item" href="dashboard/profil.php">Profil</a></li>
                        
                        <?php 
                            $req_user_permissions = $bdd->prepare('SELECT permissions_level FROM OMT_USER WHERE id_user = ?');
                            $req_user_permissions->execute(array($_SESSION['id_user']));
                            $user_info = $req_user_permissions->fetch(); 
                        
                            if($user_info['permissions_level'] == 1){
                                echo '<li><a class="dropdown-item" href="dashboard/admin">Administrateur</a></li>';
                            }
                        
                        ?>
                        <li><a class="dropdown-item" href="#">Amis</a></li>
                        <li><a class="dropdown-item" href="#">Groupe</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="/logout.php">Déconnexion</a></li>
                    </ul>
                </div>
                
            </div>
        </nav>
    </div>
</header>