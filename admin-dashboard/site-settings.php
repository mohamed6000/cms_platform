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
  
    <title>Administration | Paramètres</title>

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
              <h4 class="fw-bold py-3 mb-4">Paramétres du site</h4>

              <!-- Basic Layout & Basic with Icons -->
              <div class="row">
                <!-- Basic with Icons -->
                <div class="col-xxl">
                  <div class="card mb-4">
                    <div class="card-body">
                      <div id="logo_res"></div>
                      <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img src="<?php echo $infos["logo"]; ?>" alt="website-logo" class="d-block rounded" height="50" id="uploadedAvatar">
                        <form pt-post="api/update-logo.php" pt-target="#logo_res">
                          <div class="button-wrapper">
                            <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                              <span class="d-none d-sm-block">Télécharger un nouveau logo</span>
                              <i class="bx bx-upload d-block d-sm-none"></i>
                              <input type="file" id="upload" name="logo"
                                     class="account-file-input"
                                     hidden="" accept="image/png, image/jpeg">
                            </label>
                            <br>
                            <button type="submit" class="btn btn-success  mb-4">
                              <i class="bx bx-reset d-block d-sm-none"></i>
                              <span class="d-none d-sm-block">Enregistrer</span>
                            </button>
                            <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                              <i class="bx bx-reset d-block d-sm-none"></i>
                              <span class="d-none d-sm-block">Annuler</span>
                            </button>
                          </div>
                        </form>
                      </div>
                    </div>

                    <hr class="my-0">

                    <div class="card-header d-flex align-items-center justify-content-between">
                      <h5 class="mb-0">Paramètres de base</h5>
                      <small class="text-muted float-end">Mettre à jour les champs</small>
                    </div>
                    <div class="card-body">
                      <form pt-post="api/update-site-settings.php" pt-target="#result">
                      <div class="row mb-3">
                        <div id="result"></div>
                      </div>

                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="site_name">Nom du site</label>
                          <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                              <span id="basic-icon-default-fullname2" class="input-group-text"><i class="bx bx-globe"></i></span>
                              <input type="text" class="form-control" id="site_name" name="site_name" value="<?php echo $infos["site_name"]; ?>" placeholder="My cool website" aria-describedby="site_name">
                            </div>
                          </div>
                        </div>
                        
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="base_url">URL de base</label>
                          <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                              <span id="basic-icon-default-company2" class="input-group-text"><i class="bx bx-link-alt"></i></span>
                              <input type="text" id="base_url" name="base_url" value="<?php echo $infos["base_url"]; ?>" class="form-control" placeholder="http://www.mycoolsite.com/" aria-describedby="base_url">
                            </div>
                          </div>
                        </div>
                        
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="email">Email</label>
                          <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                              <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                              <input type="text" id="email" name="email" value="<?php echo $infos["email"]; ?>" class="form-control" placeholder="john.doe@example.com" aria-describedby="email">
                            </div>
                            <div class="form-text">Vous pouvez utiliser des lettres, des chiffres et des points</div>
                          </div>
                        </div>

                        <div class="row mb-3 ">
                          <label class="col-sm-2 col-form-label" for="published">État du site</label>
                          <div class="col-sm-10">
                                  <div class="form-check form-switch mt-2">
                                      <div id="checked_status">
                                          <input pt-post="api/publish_site.php" pt-include="#published"
                                                 pt-target="#checked_status" 
                                                 class="form-check-input" type="checkbox" id="published" name="published" role="switch" 
                                                 <?php echo ($infos["published"] === 1) ? "checked" : ""; ?>>
                                          <?php echo ($infos["published"] === 1) ? "Public" : "Brouillon"; ?>
                                      </div>
                                  </div>
                          </div>
                        </div>

                        <div class="row mb-3">
                          <label class="col-sm-2 form-label" for="phone">Numéro de téléphone</label>
                          <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                              <span id="basic-icon-default-phone2" class="input-group-text"><i class="bx bx-phone"></i></span>
                              <input type="text" id="phone" name="phone" value="<?php echo $infos["phone"]; ?>" class="form-control phone-mask" placeholder="658 799 8941" aria-describedby="phone">
                            </div>
                          </div>
                        </div>

                        <div class="row mb-3">
                          <label class="col-sm-2 form-label" for="timing">Horaire</label>
                          <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                              <span id="timing2" class="input-group-text"><i class="bx bx-time"></i></span>
                              <input type="text" id="timing" name="timing" value="<?php echo $infos["timing"]; ?>" class="form-control" placeholder="Mon - Fri : 9AM - 9PM" aria-describedby="timing">
                            </div>
                          </div>
                        </div>

                        <div class="row mb-3">
                          <label class="col-sm-2 form-label" for="address">Adresse</label>
                          <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                              <span id="address2" class="input-group-text"><i class="bx bx-home"></i></span>
                              <input type="text" id="address" name="address" value="<?php echo $infos["address"]; ?>" class="form-control" placeholder="123 Street, New York, USA" aria-describedby="address">
                            </div>
                          </div>
                        </div>

                        <div class="row mb-3">
                          <label class="col-sm-2 form-label" for="description">Description</label>
                          <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                              <span id="description2" class="input-group-text"><i class="bx bx-info-circle"></i></span>
                              <textarea id="description" name="description" class="form-control" placeholder="Description du site web..." aria-describedby="description"><?php echo $infos["description"]; ?></textarea>
                            </div>
                          </div>
                        </div>

                        <div class="row mb-3">
                          <label class="col-sm-2 form-label" for="keywords">Mots clés</label>
                          <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                              <span id="keywords2" class="input-group-text"><i class="bx bx-purchase-tag"></i></span>
                              <textarea id="keywords" name="keywords" class="form-control" placeholder="Sécurité, surveillance, ..." aria-describedby="keywords"><?php echo $infos["keywords"]; ?></textarea>
                            </div>
                          </div>
                        </div>

                        <div class="row justify-content-end">
                          <div class="col-sm-10">
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
