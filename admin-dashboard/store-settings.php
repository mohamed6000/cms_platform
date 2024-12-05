<?php

require_once("../core/bootstrap.php");

// Utils::begin_session();
session_start();

Utils::prevent_non_logged_in_visits();
Utils::prevent_non_admin_visits();

$database = new Database();
$site_settings = new SiteSettings($database);

$infos = $site_settings->get_global_infos();

?>

<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="/admin-dashboard/assets/" data-template="vertical-menu-template-free">
<head>
    <?php include "templates/page_head.php"; ?>
  
    <title>Administration | Boutique</title>

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
              <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4">Paramétres de boutique</h4>

              <!-- Basic Layout & Basic with Icons -->
              <div class="row">
                <!-- Basic with Icons -->
                <div class="col-xxl">
                  <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                      <h5 class="mb-0">Paramètres de boutique</h5>
                      <small class="text-muted float-end">Mettre à jour les champs</small>
                    </div>
                    <div class="card-body">
                      <form pt-post="api/update-store-settings.php" pt-target="#result">
                      <div class="row mb-3">
                        <div id="result"></div>
                      </div>

                        <div class="row mb-3 ">
                          <label class="col-sm-4 col-form-label" for="show_store_discount">Afficher la remise</label>
                          <div class="col-sm-8">
                            <div class="form-check form-switch mt-2">
                                <div id="checked_status">
                                    <input pt-post="api/show-store-discount.php" 
                                            pt-include="#show_store_discount"
                                            pt-target="#checked_status" 
                                            class="form-check-input" type="checkbox" id="show_store_discount" name="show_store_discount" role="switch" 
                                            <?php echo ($infos["show_store_discount"] === 1) ? "checked" : ""; ?>>
                                    <?php echo ($infos["show_store_discount"] === 1) ? "Oui" : "Non"; ?>
                                </div>
                            </div>
                          </div>
                        </div>

                        <div class="row mb-3">
                          <label class="col-sm-4 col-form-label" for="store_discount_percent">Pourcentage de remise (%)</label>
                          <div class="col-sm-8">
                            <div class="input-group input-group-merge">
                              <span id="basic-icon-default-fullname2" class="input-group-text"><i class="bx bxs-discount"></i></span>
                              <input type="text" class="form-control" id="store_discount_percent" name="store_discount_percent" value="<?php echo $infos["store_discount_percent"]; ?>" placeholder="My cool website" aria-describedby="store_discount_percent">
                            </div>
                          </div>
                        </div>

                        <div class="row mb-3">
                          <label class="col-sm-4 col-form-label" for="store_discount_event_name">Nom de l'événement</label>
                          <div class="col-sm-8">
                            <div class="input-group input-group-merge">
                              <input type="text" class="form-control" id="store_discount_event_name" name="store_discount_event_name" value="<?php echo $infos["store_discount_event_name"]; ?>" placeholder="My cool website" aria-describedby="store_discount_event_name">
                            </div>
                          </div>
                        </div>

                        <div class="row mb-3">
                          <label class="col-sm-4 col-form-label" for="store_discount_date_limit">Date limite</label>
                          <div class="col-sm-8">
                            <div class="input-group input-group-merge">
                              <input type="date" class="form-control" id="store_discount_date_limit" name="store_discount_date_limit" value="<?php echo $infos["store_discount_date_limit"]; ?>" placeholder="My cool website" aria-describedby="store_discount_date_limit">
                            </div>
                          </div>
                        </div>
                        
                        <div class="row justify-content-end">
                          <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary">Mettre à jour</button>
                          </div>
                        </div>
                      </form>
                    </div>
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
    <script src="/admin-dashboard/assets/js/pages-account-settings-account.js"></script>
</body>
</html>
