<?php

require_once("../core/utils.php");

//Utils::begin_session();
session_start();

Utils::prevent_non_logged_in_visits();
Utils::prevent_non_admin_visits();

require_once("../core/bootstrap.php");

$database = new Database();
$account = new Account($database);

?>

<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="/admin-dashboard/assets/" data-template="vertical-menu-template-free">
<head>
    <?php include "templates/page_head.php"; ?>

    <title>Administration | Mon Profil</title>

    <!-- my frontend library -->
    <script src="/pt.js"></script>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <?php include "templates/menu.php"; ?>

        <!-- Layout container -->
        <div class="layout-page">
          <?php 
            include "templates/navbar.php";

            $profile = $my_account; // we already get our account info from the templates/navbar.php
          ?>

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Comptes /</span> Mon Profil</h4>

              <div class="row">
                <div class="col-md-12">
                  <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <li class="nav-item">
                      <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i> Mon Profil</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="change-password.php"><i class="bx bxs-key me-1"></i> Mot de pass</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="delete-user.php"><i class="bx bxs-key me-1"></i> Supprimer l'utilisateur</a>
                    </li>
                  </ul>
                  <div class="card mb-4">
                    <h5 class="card-header">Détails du profil</h5>
                    <!-- Account -->
                    <div class="card-body">
                      <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <!-- <img src="/admin-dashboard/assets/img/avatars/1.png" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar"> -->
                        <img src="<?php echo $my_account_picture; ?>" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar">
                        <div class="button-wrapper">
                          <!-- <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                            <span class="d-none d-sm-block">Télécharger une nouvelle photo</span>
                            <i class="bx bx-upload d-block d-sm-none"></i>
                            <input type="file" id="upload" class="account-file-input" hidden="" accept="image/png, image/jpeg">
                          </label>
                          <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                            <i class="bx bx-reset d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Réinitialiser</span>
                          </button> -->

                          <!-- <p class="text-muted mb-0">JPG, GIF ou PNG autorisés. Taille maximale de 800K</p> -->

                          <a href="https://fr.gravatar.com/" target="_blank" class="btn btn-primary me-2 mb-4">
                            <i class="bx bx-upload d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Modifier votre photo sur Gravatar</span>
                          </a>

                          <p class="text-muted mb-0">Chaque profil Gravatar est associé à une adresse e-mail. Lorsque vous utilisez cette adresse sur Internet, la totalité de votre profil vous suit.</p>
                          <p class="text-muted mb-0">Avec Gravatar, vos données vous appartiennent, à vous et à personne d’autre.</p>
                        </div>
                      </div>
                    </div>
                    <hr class="my-0">
                    <div class="card-body">
                      <form id="formAccountSettings" pt-post="api/update-profile.php" pt-target="#result">
                        <div class="row">
                          <div class="mb-3 col-md-12">
                            <div id="result"></div>
                          </div>
                        
                          <div class="mb-3 col-md-6">
                            <label for="first_name" class="form-label">Prénom</label>
                            <input class="form-control" type="text" id="first_name" name="first_name" value="<?php echo $profile["first_name"]; ?>" autofocus="">
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="last_name" class="form-label">Nom</label>
                            <input class="form-control" type="text" name="last_name" id="last_name" value="<?php echo $profile["last_name"]; ?>">
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="email" class="form-label">E-mail</label>
                            <input class="form-control" type="text" id="email" name="email" value="<?php echo $profile["email"]; ?>" placeholder="john.doe@example.com">
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="user_name" class="form-label">Nom d'utilisateur</label>
                            <input type="text" class="form-control" id="user_name" name="user_name" value="<?php echo $profile["user_name"]; ?>">
                          </div>
                          <div class="mb-3 col-md-6">
                            <label class="form-label" for="phone">Numéro de téléphone</label>
                            <div class="input-group input-group-merge">
                              <span class="input-group-text">TN (+216)</span>
                              <input type="text" id="phone" name="phone" class="form-control" placeholder="20 255 501" value="<?php echo $profile["phone"]; ?>">
                            </div>
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="address" class="form-label">Adresse</label>
                            <input type="text" class="form-control" id="address" name="address" placeholder="Address" value="<?php echo $profile["address"]; ?>">
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="gender" class="form-label">Sexe</label>
                            <select id="gender" name="gender" class="select2 form-select">
                                <option value="">Sélectionnez le sexe</option>
                                <option value="male" <?php echo ($profile["gender"] === "male") ? "selected" : ""; ?>>Homme</option>
                                <option value="female" <?php echo ($profile["gender"] === "female") ? "selected" : ""; ?>>Femme</option>
                            </select>
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="birth_date" class="form-label">Date de naissance</label>
                            <input type="date" class="form-control" id="birth_date" name="birth_date" placeholder="Date de naissance" value="<?php echo $profile["birth_date"]; ?>">
                          </div>
                          
                        </div>
                        <div class="mt-2">
                          <button type="submit" class="btn btn-primary me-2">Sauvegarder</button>
                          <button type="reset" class="btn btn-outline-secondary">Annuler</button>
                        </div>
                      </form>
                    </div>
                    <!-- /Account -->
                  </div>
                  <div class="card">
                    <h5 class="card-header">
                    <?php if ($profile["state"] == "activated") { ?>
                        Supprimer le compte
                    <?php } else if ($profile["state"] == "deactivated") { ?>
                        Activer le compte
                    <?php } ?>
                    </h5>
                    <div class="card-body" id="deactivation_result">
                        <?php if ($profile["state"] == "activated") { ?>
                        
                            <div class="mb-3 col-12 mb-0">
                                <div class="alert alert-warning">
                                <h6 class="alert-heading fw-bold mb-1">Êtes-vous sûr de vouloir supprimer votre compte ?</h6>
                                <p class="mb-0">Une fois votre compte supprimé, vous ne pourrez plus revenir en arrière. Soyez-en sûr, s'il vous plaît.</p>
                                </div>
                            </div>
                            
                            <form pt-post="api/profile-deactivate-account.php" pt-target="#deactivation_result">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="account_activation" id="account_activation">
                                    <label class="form-check-label" for="account_activation">Je confirme la désactivation de mon compte</label>
                                </div>
                                <button type="submit" class="btn btn-danger deactivate-account">Désactiver le compte</button>
                            </form>

                        <?php } else if ($profile["state"] == "deactivated") { ?>

                            <div class="mb-3 col-12 mb-0">
                                <div class="alert alert-info alert-dismissible" role="alert">
                                    Votre compte a été désactivé vous ne pouvez plus accéder à vos fonctionnalités habituelles.<br>
                                    Allez-y et déconnectez-vous.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>
                                
                            <button pt-post="api/profile-activate-account.php" pt-target="#deactivation_result" class="btn btn-success deactivate-account">
                                Activer mon compte
                            </button>

                        <?php } ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- / Content -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <?php include "templates/common_libs.php"; ?>
    <!-- Page JS -->
    <!-- <script src="/admin-dashboard/assets/js/pages-account-settings-account.js"></script> -->
</body>
</html>
