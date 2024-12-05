<?php 
$page_title = "Facture";
$use_pt = "";
include "header.php";

Utils::website_prevent_non_logged_in_visits();

$id = false;
if (isset($_GET["id"]) && !empty($_GET["id"])) {
    $id = intval($_GET["id"]);
} else {
    
}

$current = false;
if ($id) {
    $b = $order->get_order_by_id_for_client($id, $_SESSION["account_id"]);
}
?>

<!-- Breadcrumb Begin -->
<div class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__links">
                    <a href="/"><i class="fa fa-home"></i></a>
                    <span>Factures</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Shop Cart Section Begin -->
<section class="shop-cart spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="shop__cart__table">
                    <center>
                        <h4>#BID_<?php echo $b["id"]; ?> : : <?php echo $b["order_date"]; ?></h4>
                        <hr>
                    </center>

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
</section>
<!-- Shop Cart Section End -->

<?php include "footer.php"; ?>