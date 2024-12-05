<?php

require_once("../core/utils.php");

//Utils::begin_session();
session_start();

Utils::prevent_non_logged_in_visits();
Utils::prevent_non_admin_visits();

?>

<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="/admin-dashboard/assets/" data-template="vertical-menu-template-free">
<head>
    <?php include "templates/page_head.php"; ?>
    
    <title>Administration</title>

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
          <?php include "templates/navbar.php"; ?>

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="row">
                <div class="col-lg-8 mb-4 order-0">
                  <div class="card">
                    <div class="d-flex align-items-end row">
                      <div class="col-sm-7">
                        <div class="card-body">
                          <h5 class="card-title text-primary">Bienvenu <?php echo empty($my_account["first_name"]) ? $my_account["user_name"] : $my_account["first_name"]; ?>! 🎉</h5>
                          <p class="mb-4">
                            Bienvenue sur le tableau de bord, vous avez un accès complet à la plateforme en tant qu'administrateur
                          </p>

                          <a href="site-settings.php" class="btn btn-sm btn-outline-primary">Paramètres du site</a>
                        </div>
                      </div>
                      <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                          <img
                            src="/admin-dashboard/assets/img/illustrations/man-with-laptop-light.png"
                            height="140"
                            alt="View Badge User"
                            data-app-dark-img="illustrations/man-with-laptop-dark.png"
                            data-app-light-img="illustrations/man-with-laptop-light.png"
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4 col-md-4 order-1">
                      <div class="card">
                        <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                              <img
                                src="/admin-dashboard/assets/img/icons/unicons/chart-success.png"
                                alt="chart success"
                                class="rounded"
                              />
                            </div>
                            <div class="dropdown">
                              <button
                                class="btn p-0"
                                type="button"
                                id="cardOpt3"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"
                              >
                                <i class="bx bx-dots-vertical-rounded"></i>
                              </button>
                              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                <a class="dropdown-item" href="client-list.php">View More</a>
                              </div>
                            </div>
                          </div>
                          <span class="fw-semibold d-block mb-1">En attente</span>
                          <h3 class="card-title mb-2">
                            <?php 
                              $total_pending_clients = $account->get_pending_clients_count();
                              echo $total_pending_clients . " " . (($total_pending_clients == 1) ? "client" : "clients");
                            ?>
                          </h3>
                          <small class="text-success fw-semibold"><i class="bx bx-plus"></i> Nouveau</small>
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
</body>
</html>
