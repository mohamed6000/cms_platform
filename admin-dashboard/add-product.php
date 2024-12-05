<?php

require_once("../core/bootstrap.php");

// Utils::begin_session();
session_start();

Utils::prevent_non_logged_in_visits();
Utils::prevent_non_admin_visits();

$database = new Database();
$store_category = new StoreCategory($database);
$categories = $store_category->get_all();
?>

<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="/admin-dashboard/assets/" data-template="vertical-menu-template-free">
<head>
    <?php include "templates/page_head.php"; ?>

    <title>Administration | Ajouter un produit</title>

    <!-- my frontend library -->
    <script src="/pt.js"></script>

<style>
    .margin-bottom-20 {
        margin-top: 20px;
    }
    .margin-top-20 {
        margin-top: 20px;
    }
    .box-center {
        margin: 20px auto;
    }
    input[type=file] {
/*        display: block !important;*/
        right: 1px;
        top: 1px;
        height: 34px;
        opacity: 0;
      width: 100%;
        background: none;
        position: absolute;
      overflow: hidden;
      z-index: 2;
    }
    .control-fileupload {
        display: block;
        border: 1px solid #d6d7d6;
        background: #FFF;
        border-radius: 4px;
        width: 100%;
        height: 36px;
        line-height: 36px;
        padding: 0px 10px 2px 10px;
      overflow: hidden;
      position: relative;
      
      &:before, input, label {
        cursor: pointer !important;
      }
      /* File upload button */
      &:before {
        /* inherit from boostrap btn styles */
        padding: 4px 12px;
        margin-bottom: 0;
        font-size: 14px;
        line-height: 20px;
        color: #333333;
        text-align: center;
        text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
        vertical-align: middle;
        cursor: pointer;
        background-color: #f5f5f5;
        background-image: linear-gradient(to bottom, #ffffff, #e6e6e6);
        background-repeat: repeat-x;
        border: 1px solid #cccccc;
        border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
        border-bottom-color: #b3b3b3;
        border-radius: 4px;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
        transition: color 0.2s ease;

        /* add more custom styles*/
        content: 'Browse';
        display: block;
        position: absolute;
        z-index: 1;
        top: 2px;
        right: 2px;
        line-height: 20px;
        text-align: center;
      }
      &:hover, &:focus {
        &:before {
          color: #333333;
          background-color: #e6e6e6;
          color: #333333;
          text-decoration: none;
          background-position: 0 -15px;
          transition: background-position 0.2s ease-out;
        }
      }
        label {
        line-height: 24px;
        color: #999999;
        font-size: 14px;
        font-weight: normal;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        position: relative;
        z-index: 1;
        margin-right: 90px;
        margin-bottom: 0px;
        cursor: text;
      }
    }

    .hidden_input {display: none !important;}
</style>
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
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Boutique /</span> Ajouter un produit</h4>

              <div class="row">
                <div class="col-md-12">
                  <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <li class="nav-item">
                      <a class="nav-link active" href="javascript:void(0);"><i class="bx bxs-cart-add me-1"></i> Ajouter un produit</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="products.php"><i class="bx bxs-shopping-bags me-1"></i> Produits</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="categories.php"><i class="bx bxs-category me-1"></i> Catégories</a>
                    </li>
                  </ul>
                  <div class="card mb-4">
                    <h5 class="card-header">Détails du produit</h5>
                    <hr class="my-0">
                    
                    <div class="card-body">
                      <form id="formAccountSettings" pt-post="api/store-add-product.php" pt-target="#result">
                        <div class="row">
                          <div class="mb-3 col-md-12">
                            <div id="result"></div>
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="title" class="form-label">Nom du produit</label>
                            <input class="form-control" type="text" id="title" name="title" placeholder="Nom du produit" autofocus="">
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="brand" class="form-label">Nom du brand</label>
                            <input type="text" class="form-control" id="brand" name="brand" placeholder="Nom du brand">
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="original_price" class="form-label">Prix original</label>
                            <input type="text" class="form-control" id="original_price" name="original_price" placeholder="Prix original">
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="new_price" class="form-label">Nouveau prix</label>
                            <input type="text" class="form-control" id="new_price" name="new_price" placeholder="Nouveau prix">
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="description" class="form-label">Déscription</label>
                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Déscription"></textarea>
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="specification" class="form-label">Spécification</label>
                            <textarea class="form-control" id="specification" name="specification" rows="3" placeholder="Spécification"></textarea>
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="stock" class="form-label">Quantité en stock</label>
                            <input type="number" min="1" class="form-control" id="stock" name="stock" placeholder="Quantité en stock">
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="category" class="form-label">Catégorie</label>
                            <select name="category" id="category" class="form-control">
                              <option value="">Choisir une catégorie</option>
                            <?php
                            foreach ($categories as $cat) {
                              echo '<option value="'.$cat["id"].'">'.$cat["name"].'</option>';
                            }
                            ?>
                            </select>
                          </div>

                          <div class="mb-3 col-md-12">
                            <b>Téléchargez des fichiers ici</b>

                            <!-- fileuploader view component -->
                            <div class="row" id="attachments_section"></div>
                            <!-- ./fileuploader view component -->

                            <span class="control-fileupload">
                              <label for="attachments" class="text-left">Veuillez choisir un fichier sur votre ordinateur.</label>
                              <input type="file" id="attachments" name="attachments[]" multiple>
                            </span>
                          </div>

                          <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">Ajouter</button>
                            <button type="reset" class="btn btn-outline-secondary">Annuler</button>
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
    (function(){
        const MAX_ATTACHEMENT_COUNT = 4; // 4 images
        var read_url = function(input) {
            if (input.files && (input.files.length <= MAX_ATTACHEMENT_COUNT)) {
                document.querySelector("#attachments_section").innerHTML = "";

                for (var i = 0; i < input.files.length; ++i) {
                    var reader = new FileReader();
                    const current = input.files[i];

                    reader.onload = function (e) {
                        const col = document.createElement("div");
                        col.className = "col-sm-4";
                        
                        if ((current.type === "image/jpeg") || (current.type === "image/bmp") ||
                            (current.type === "image/gif") || (current.type === "image/png") ||
                            (current.type === "image/webp")) {
                            var new_el = document.createElement("img"); 
                            new_el.className = "img-thumbnail img-fluid rounded";
                            new_el.width = "200";
                            new_el.src = e.target.result;
                            col.append(new_el);
                        }
                        
                        document.querySelector("#attachments_section").append(col);
                    }

                    reader.readAsDataURL(current);
                }
            }
        };

        document.querySelector("input[type=file]").onchange = function() {
            var label_text = "Files : ";
            for (var i = 0; i < this.files.length; ++i) {
                var t = this.files[i].name;
                label_text += t + ", ";
            }

            this.parentNode.children[0].innerHTML = label_text;
            read_url(this);
        };
    })();
</script>
</body>
</html>
