<?php

require_once("../core/bootstrap.php");

// Utils::begin_session();
session_start();

Utils::prevent_non_logged_in_visits();
Utils::prevent_non_admin_visits();

$database = new Database();
$store_category = new StoreCategory($database);

$categories = $store_category->get_all();
include "api/render-store-categories.php";
?>

<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="/admin-dashboard/assets/" data-template="vertical-menu-template-free">
<head>
    <?php include "templates/page_head.php"; ?>

    <title>Administration | Catégories</title>

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
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Boutique /</span> Catégories</h4>

              <div class="row">
                <div class="col-md-12">
                  <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <li class="nav-item">
                      <a class="nav-link" href="add-product.php"><i class="bx bxs-cart-add me-1"></i> Ajouter un produit</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="products.php"><i class="bx bxs-shopping-bags me-1"></i> Produits</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link active" href="javascript:void(0);"><i class="bx bxs-category me-1"></i> Catégories</a>
                    </li>
                  </ul>
                  <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                      <h5 class="mb-0">Catégories</h5>
                      <div>
                        <button type="button" class="btn btn-outline-primary btn-sm" title="Sélection" onclick="select_all();">Tous</button>
                        <button type="button" class="btn btn-outline-primary btn-sm" title="Sélection" onclick="unselect_all();">Aucun</button>
                        <button type="button" class="btn btn-danger btn-sm" title="Supprimer" onclick="delete_selected_products();"><i class='bx bx-trash'></i></button>
                      </div>
                    </div>
                    <hr class="my-0">
                    
                    <div class="table-responsive text-nowrap">
                        <div id="result_div"></div>
                        <div id="categories">
                          <?php render_store_categories($categories); ?>
                        </div>
                    </div>

                    <div class="card-body">
                      <form pt-post="api/store-add-category.php" pt-target="#categories">
                          <div class="row">
                              <div class="mb-3 col-md-6">
                                <div class="input-group mb-3">
                                    <input class="form-control" type="text" id="cat_name" name="cat_name" placeholder="Nom du catégorie" autofocus="">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary me-2">Ajouter</button>
                                    </div>
                                </div>
                              </div>
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
<script type="text/javascript">
    function select_all() {
        const checkboxes = document.querySelectorAll('input[type=checkbox]');
        for (var i = 0; i < checkboxes.length; ++i) {
            checkboxes[i].checked = true;
        }
    }

    function unselect_all() {
        const checkboxes = document.querySelectorAll('input[type=checkbox]');
        for (var i = 0; i < checkboxes.length; ++i) {
            checkboxes[i].checked = false;
        }
    }

    function send_http_post_request(uri, data) {
        const xhr = new XMLHttpRequest();

        if (xhr) {
            xhr.open("POST", uri, true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            
            data = new URLSearchParams(data);

            xhr.onreadystatechange = function(e) {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    //console.log(xhr.readyState, xhr.responseText);
                }
            };
            xhr.send(data);
        }
    }

    function delete_selected_products() {
        const checkboxes = document.querySelectorAll('input[type=checkbox]:checked');

        for (var i = 0; i < checkboxes.length; ++i) {
            send_http_post_request("api/store-category-delete.php?id=" + checkboxes[i].value, null);
            checkboxes[i].parentNode.parentNode.style.display = "none";
        }
    }
</script>
</body>
</html>
