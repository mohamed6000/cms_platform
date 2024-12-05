<?php

require_once("../core/bootstrap.php");

session_start();

Utils::prevent_non_logged_in_visits();
Utils::prevent_non_admin_visits();

$id = false;
if (isset($_GET["id"]) && !empty($_GET["id"])) {
    $id = intval($_GET["id"]);
} else {
    echo '<script> location.replace("/"); </script>';
    exit;
}

$current = false;
if ($id) {
    $database = new Database();
    $order = new Order($database);

    $b = $order->get_order_by_id($id);
} else {
    echo '<script> location.replace("/"); </script>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="/admin-dashboard/assets/" data-template="vertical-menu-template-free">
<head>
    <?php include "templates/page_head.php"; ?>

    <title>Administration | Facture n°<?php echo $id; ?></title>

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
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Boutique /</span> Facture</h4>

              <div class="row">
                <div class="col-md-12">
                  <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h4>#BID_<?php echo $b["id"]; ?> : : <?php echo $b["order_date"]; ?></h4>
                    </div>
                    <hr class="my-0">
                    
                    <div class="text-nowrap p-4">

                    <b>Client:</b> <?php echo $b["first_name"]; ?> <?php echo $b["last_name"]; ?><br>
                    <b>Email:</b> <?php echo $b["email"]; ?> <br>
                    <b>Adresse:</b> <?php echo $b["address"]; ?> <br>
                    <b>Télephone:</b> <?php echo $b["phone"]; ?> <br>
                    <b>Payment:</b> <?php if ($b["pay"] == "pod") {
                                        echo "Paiement à la livraison";
                                    } else if ($b["pay"] == "cc") {
                                        echo "Carte de crédit";
                                    } ?><br>
                    <b>Totale:</b> <?php echo $b["total"]; ?> DT<br>
                    <hr>
                    <div style="padding-left: 35px;"><?php echo $b["content"]; ?></div>
                    <hr>
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
