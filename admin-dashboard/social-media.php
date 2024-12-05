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
  
    <title>Administration | Réseaux sociaux</title>

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
              <h4 class="fw-bold py-3 mb-4">Réseaux sociaux</h4>

              <!-- Basic Layout & Basic with Icons -->
              <div class="row">
                <!-- Basic with Icons -->
                <div class="col-xxl">
                  <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                      <h5 class="mb-0">Mettre à jour l'URLs de votre réseaux sociaux</h5>
                    </div>
                    <div class="card-body">
                      <form pt-post="api/update-social-media.php" pt-target="#result">
                      <div class="row mb-3">
                        <div id="result"></div>
                      </div>

                        <div class="row mb-3">
                          <div class="col-sm-12">
                            <div class="input-group input-group-merge">
                              <span id="basic-icon-default-fullname2" class="input-group-text"><i class='bx bxl-facebook-square'></i></span>
                              <input type="text" class="form-control" id="social_facebook" name="social_facebook" value="<?php echo $infos["social_facebook"]; ?>" placeholder="Facebook" aria-describedby="social_facebook">
                            </div>
                          </div>
                        </div>

                        <div class="row mb-3">
                          <div class="col-sm-12">
                            <div class="input-group input-group-merge">
                              <span id="basic-icon-default-fullname2" class="input-group-text"><i class='bx bxl-twitter'></i></span>
                              <input type="text" class="form-control" id="social_twitter" name="social_twitter" value="<?php echo $infos["social_twitter"]; ?>" placeholder="Twitter" aria-describedby="social_twitter">
                            </div>
                          </div>
                        </div>

                        <div class="row mb-3">
                          <div class="col-sm-12">
                            <div class="input-group input-group-merge">
                              <span id="basic-icon-default-fullname2" class="input-group-text"><i class='bx bxl-youtube'></i></span>
                              <input type="text" class="form-control" id="social_youtube" name="social_youtube" value="<?php echo $infos["social_youtube"]; ?>" placeholder="Youtube" aria-describedby="social_youtube">
                            </div>
                          </div>
                        </div>

                        <div class="row mb-3">
                          <div class="col-sm-12">
                            <div class="input-group input-group-merge">
                              <span id="basic-icon-default-fullname2" class="input-group-text"><i class='bx bxl-instagram'></i></span>
                              <input type="text" class="form-control" id="social_instagram" name="social_instagram" value="<?php echo $infos["social_instagram"]; ?>" placeholder="Instagram" aria-describedby="social_instagram">
                            </div>
                          </div>
                        </div>

                        <div class="row mb-3">
                          <div class="col-sm-12">
                            <div class="input-group input-group-merge">
                              <span id="basic-icon-default-fullname2" class="input-group-text"><i class='bx bxl-pinterest'></i></span>
                              <input type="text" class="form-control" id="social_pinterest" name="social_pinterest" value="<?php echo $infos["social_pinterest"]; ?>" placeholder="Pinterest" aria-describedby="social_pinterest">
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
</body>
</html>
