<?php

require_once("../core/bootstrap.php");

session_start();

Utils::prevent_non_logged_in_visits();
Utils::prevent_non_admin_visits();

$database = new Database();
$order = new Order($database);

if (isset($_GET["page"]) && !empty($_GET["page"])) {
  $current_page = (int)strip_tags($_GET["page"]);
} else {
  $current_page = 1;
}

$result = $order->get_all($current_page, 10);
$bills = $result["bills"];
$pages = $result["pages"];

include "api/render-bill-row.php";
?>

<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="/admin-dashboard/assets/" data-template="vertical-menu-template-free">
<head>
    <?php include "templates/page_head.php"; ?>

    <title>Administration | Factures</title>

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
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Boutique /</span> Factures</h4>

              <div class="row">
                <div class="col-md-12">
                  <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                      <h5 class="mb-0">Factures</h5>
                    </div>
                    <hr class="my-0">
                    
                    <?php if ($bills) { ?>
                    <div class="table-responsive text-nowrap">
                        <div id="result_ops"></div>

                        <table class="table table-hover">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>Client</th>
                              <th>Date</th>
                              <th>Téléphone</th>
                              <th>Totale</th>
                            </tr>
                          </thead>
                          <tbody class="table-border-bottom-0">
                            <?php foreach ($bills as $i => $b) {
                              render_bill_row($i, $b["id"],
                                ($b["first_name"] . " " . $b["last_name"]), 
                                $b["order_date"], 
                                $b["phone"], $b["total"]);
                            }
                            ?>
                          </tbody>
                        </table>
                    </div>
                    <?php } ?>
                    <!-- /Account -->

                    <div class="card-body mx-auto">
                        <div class="btn-toolbar demo-inline-spacing" role="toolbar" aria-label="Toolbar with button groups">
                            <div class="btn-group" role="group" aria-label="Third group">
                              <a href="products.php?page=1" class="btn btn-outline-primary px-2" title="Première page">
                                <i class='bx bx-chevrons-left'></i>
                              </a>
                            </div>

                            <div class="btn-group" role="group" aria-label="Third group">
                              <a href="products.php?page=<?php echo max($current_page-1, 1); ?>" class="btn btn-outline-primary px-2" title="Page précédente">
                                <i class='bx bx-chevron-left'></i>
                              </a>

                              <?php
                              for ($i = 1; $i <= $pages; ++$i) {
                                if ($i == $current_page) {
                                  echo '<button type="button" class="btn btn-outline-primary" title="Dernière page" disabled>
                                          '.$i.'
                                        </button>';
                                } else {
                                  echo '<a href="products.php?page='.$i.'" class="btn btn-outline-primary" title="Dernière page">
                                          '.$i.'
                                        </a>';
                                }
                              }
                              ?>
                              
                              <a href="products.php?page=<?php echo min($current_page+1, $pages); ?>" class="btn btn-outline-primary px-2" title="Page suivante">
                                <i class='bx bx-chevron-right'></i>
                              </a>
                            </div>

                            <div class="btn-group" role="group" aria-label="Third group">
                              <a href="products.php?page=<?php echo $pages; ?>" class="btn btn-outline-primary px-2" title="Dernière page">
                                <i class='bx bx-chevrons-right'></i>
                              </a>
                            </div>
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
            send_http_post_request("api/store-product-delete.php?id=" + checkboxes[i].value, null);
            checkboxes[i].parentNode.parentNode.style.display = "none";
        }
    }
</script>
</body>
</html>
