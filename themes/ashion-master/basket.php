<?php 
$page_title = "Panier";
$use_pt = "";
include "header.php";

Utils::website_prevent_non_logged_in_visits();

$my_products = $store_basket->get_products_by_client($_SESSION["account_id"]);
?>

<!-- Breadcrumb Begin -->
<div class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__links">
                    <a href="/"><i class="fa fa-home"></i></a>
                    <span>Panier</span>
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
                                <th>Produit</th>
                                <th>Prix</th>
                                <th class="text-center">Quantité</th>
                                <th>Total</th>
                                <th>Supprimer</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $total = 0;
                            foreach ($my_products as $p) { 
                                $the_price = ($p["new_price"] > 0) ? $p["new_price"] : $p["original_price"];
                                $total += $the_price * (int)$p["quantity"];
                            ?>
                            <tr id="basket_<?php echo $p["bid"]; ?>">
                                <td class="cart__product__item">
                                    <div class="cart__product__item__title">
                                        <h6><?php echo $p["title"]; ?></h6>
                                    </div>
                                </td>
                                <td class="cart__price">
                                    DT <?php echo number_format($the_price, 2); ?>
                                </td>
                                <td class="cart__quantity">
                                    <div class="text-center">
                                        <?php echo $p["quantity"]; ?>
                                    </div>
                                </td>
                                <td class="cart__total">DT <?php echo number_format($the_price * $p["quantity"], 2); ?></td>
                                <td class="cart__close"><span class="icon_close" pt-post="api/store-remove-from-basket.php?id=<?php echo $p["bid"]; ?>" pt-target="#basket_<?php echo $p["bid"]; ?>"></span></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-6 col-sm-6">
                <div class="cart__btn">
                    <a href="/shop">Continuer vos achats</a>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="cart__total__procced">
                    <h6>Total du panier</h6>
                    <ul>
                        <!-- <li>Subtotal <span>DT <?php echo $total; ?></span></li> -->
                        <li>Total <span>DT <?php echo $total; ?></span></li>
                    </ul>
                    <a href="/checkout" class="primary-btn">Passer à la caisse</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Shop Cart Section End -->

<?php include "footer.php"; ?>