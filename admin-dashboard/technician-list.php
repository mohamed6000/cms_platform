<?php

require_once("../core/bootstrap.php");

// Utils::begin_session();
session_start();

Utils::prevent_non_logged_in_visits();
Utils::prevent_non_admin_visits();

$database = new Database();
$account = new Account($database);

$technicians = $account->get_technicians();
require_once("api/render-technician-row.php");

?>

<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="/admin-dashboard/assets/" data-template="vertical-menu-template-free">
<head>
    <?php include "templates/page_head.php"; ?>

    <title>Administration | Liste des techniciens</title>

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
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Techniciens /</span> Liste des techniciens</h4>

              <div class="row">
                <div class="col-md-12">
                  <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <li class="nav-item">
                      <a class="nav-link" href="add-technician.php"><i class="bx bx-user-plus me-1"></i> Ajouter un technicien</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link active" href="javascript:void(0);"><i class="bx bxs-briefcase me-1"></i> Profils</a>
                    </li>
                  </ul>
                  <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                      <h5 class="mb-0">Profiles</h5>
                      <!-- <small class="text-muted float-end">fffffffffffff</small> -->
                      <div>
                        <button type="button" class="btn btn-warning" title="Limiter"><i class='bx bx-user-minus'></i></button>
                        <button type="button" class="btn btn-danger" title="Désactiver"><i class='bx bx-user-x'></i></button>
                      </div>
                    </div>
                    <hr class="my-0">
                    
                    <?php if ($technicians) { ?>
                    <div class="table-responsive text-nowrap">
                        <div id="result_ops"></div>

                        <table class="table table-hover">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>Technicien</th>
                              <th>Status</th>
                              <th>Actions</th>
                            </tr>
                          </thead>
                          <tbody class="table-border-bottom-0">
                            <?php foreach ($technicians as $index => $technician) {
                              render_technician_row($technician);
                            } ?>
                          </tbody>
                        </table>
                    </div>
                    <?php } ?>
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
    
</body>
</html>
