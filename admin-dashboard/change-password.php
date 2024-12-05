<?php

require_once("../core/bootstrap.php");

// Utils::begin_session();
session_start();

Utils::prevent_non_logged_in_visits();
Utils::prevent_non_admin_visits();

$database = new Database();
$account = new Account($database);

?>

<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="/admin-dashboard/assets/" data-template="vertical-menu-template-free">
<head>
    <?php include "templates/page_head.php"; ?>
    

    <title>Administration | Mot de passe</title>

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
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Comptes /</span> Mot de passe</h4>

              <div class="row">
                <div class="col-md-12">
                  <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <li class="nav-item">
                      <a class="nav-link" href="profile.php"><i class="bx bx-user me-1"></i> Mon Profile</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link active" href="javascript:void(0);"><i class="bx bxs-key me-1"></i> Mot de pass</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="delete-user.php"><i class="bx bxs-key me-1"></i> Supprimer l'utilisateur</a>
                    </li>
                  </ul>
                  <div class="card mb-4">
                    <h5 class="card-header">Modifier mot de passe</h5>
                    <!-- Account -->
                    
                    <hr class="my-0">
                    <div class="card-body">
                      <form id="formAccountSettings" pt-post="api/update-password.php" pt-target="#result">
                        <div class="row">
                          <div class="col-md-12">
                            <div id="result"></div>
                          </div>
                        
                          <div class="mb-3 col-md-6">
                            <label for="old_password" class="form-label">Mot de passe précédent</label>
                            <input class="form-control" type="password" id="old_password" name="old_password" autofocus="">

                            <label for="new_password" class="form-label">Nouveau mot de passe</label>
                            <input class="form-control" type="password" id="new_password" name="new_password" autofocus="">

                            <label for="new_password2" class="form-label">Confirmer le nouveau mot de passe</label>
                            <input class="form-control" type="password" id="new_password2" name="new_password2" autofocus="">
                          </div>
                        </div>
                        <div class="mt-2">
                          <button type="submit" class="btn btn-primary me-2">Mettre à jour</button>
                          <button type="reset" class="btn btn-outline-secondary">Annuler</button>
                        </div>
                      </form>
                    </div>
                    <!-- /Account -->
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
