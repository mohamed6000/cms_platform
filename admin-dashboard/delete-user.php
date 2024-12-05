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
    

    <title>Administration | Supprimer l'utilisateur</title>

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
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Comptes /</span> Supprimer l'utilisateur</h4>

              <div class="row">
                <div class="col-md-12">
                  <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <li class="nav-item">
                      <a class="nav-link" href="profile.php"><i class="bx bx-user me-1"></i> Mon Profile</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="change-password.php"><i class="bx bxs-key me-1"></i> Mot de pass</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link active" href="javascript:void(0);"><i class="bx bxs-key me-1"></i> Supprimer l'utilisateur</a>
                    </li>
                  </ul>
                  <div class="card mb-4">
                    <h5 class="card-header">Entrer le nom de l'utilisateur à supprimer</h5>
                    <!-- Account -->
                    
                    <hr class="my-0">
                    <div class="card-body">
                        <div id="target_form">
                        <?php include "api/draw-search-delete-user-form.php"; ?>
                        </div>
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
    
    <script>
      function process_selection(e) {
        const rid = e.querySelector('input[name="id"]');
        rid.checked = true;
        const parent = e.parentNode;
        for (var i= 0; i < parent.children.length; ++i) {
            const c = parent.children[i];
            c.classList.remove("table-primary");
        }
        if (rid.checked) {
            e.classList.add("table-primary");
        }
      }
    </script>
</body>
</html>
