<?php 
$page_title = "Factures";
$use_pt = "";
include "header.php";

Utils::website_prevent_non_logged_in_visits();

$bills = $order->get_orders_by_client($_SESSION["account_id"]);
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
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Payment</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($bills as $b) { ?>
                            <tr>
                                <td class="cart__quantity">
                                    <h6><a href="/bill?id=<?php echo $b["id"]; ?>">#BID_<?php echo $b["id"]; ?></a></h6>
                                </td>
                                <td class="cart__quantity">
                                    <?php echo $b["order_date"]; ?>
                                </td>
                                <td class="cart__price">
                                    DT <?php echo number_format($b["total"], 2); ?>
                                </td>
                                <td class="cart__total">
                                    <?php if ($b["pay"] == "pod") {
                                        echo "Paiement à la livraison";
                                    } else if ($b["pay"] == "cc") {
                                        echo "Carte de crédit";
                                    } ?>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Shop Cart Section End -->

<?php include "footer.php"; ?>