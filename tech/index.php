<?php

require_once("../core/utils.php");

//Utils::begin_session();
session_start();

Utils::website_prevent_non_logged_in_visits();
Utils::prevent_client_visits();

?>

<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="/admin-dashboard/assets/" data-template="vertical-menu-template-free">
<head>
    <?php include "templates/page_head.php"; ?>
    
    <title>Technicien</title>

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
                            <?php if ($notification_count > 0) { ?>
                            Vous avez <span class="fw-bold"><?php echo $notification_count; ?></span> notifications non lues.
                            <?php } ?>
                            <br>
                            <a href="/pTicket/">Visitez le tableau de bord des tickets</a>
                          </p>

                          <a href="/pTicket/tickets" class="btn btn-sm btn-outline-primary">Voir Tickets</a>
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
