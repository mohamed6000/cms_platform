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
                    <span>Facture</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Checkout Section Begin -->
<section class="checkout spad">
    <div class="container">
        <form class="checkout__form" pt-post="api/store-register-order.php" pt-target="#result">
            <div class="row">
                <div class="col-lg-8">
                    <h5>Détails de facturation</h5>
                    <div id="result"></div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="checkout__form__input">
                                <p>Prénom <span>*</span></p>
                                <input type="text" name="first_name" value="<?php echo $my_account["first_name"]; ?>">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="checkout__form__input">
                                <p>Nom de famille <span>*</span></p>
                                <input type="text" name="last_name" value="<?php echo $my_account["last_name"]; ?>">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="checkout__form__input">
                                <p>Adresse <span>*</span></p>
                                <input type="text" name="address" value="<?php echo $my_account["address"]; ?>">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="checkout__form__input">
                                <p>Téléphone <span>*</span></p>
                                <input type="text" name="phone" value="<?php echo $my_account["phone"]; ?>">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="checkout__form__input">
                                <p>Email <span>*</span></p>
                                <input type="text" name="email" value="<?php echo $my_account["email"]; ?>">
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="checkout__order">
                            <h5>Votre commande</h5>
                            <div class="checkout__order__product">
                                <ul>
                                    <li>
                                        <span class="top__text">Produit</span>
                                        <span class="top__text__right">Total</span>
                                    </li>
                                    <?php
                                    $total = 0;
                                    foreach ($my_products as $i => $p) {
                                        $the_price = ($p["new_price"] > 0) ? $p["new_price"] : $p["original_price"];
                                        $total += $the_price * (int)$p["quantity"];
                                        if ($p["quantity"] > 1) {
                                            echo '<li>'. ($i + 1) .'. '. $p["title"] .' <span>'. $p["quantity"] . " x " . $the_price .' DT</span></li>';
                                        } else {
                                            echo '<li>'. ($i + 1) .'. '. $p["title"] .' <span>'. $the_price .' DT</span></li>';
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                            <div class="checkout__order__total">
                                <ul>
                                    <li>Total <span><?php echo $total; ?> DT</span></li>
                                </ul>
                            </div>
                            <div class="checkout__order__widget">
                                <label for="pay1">
                                    Paiement à la livraison
                                    <input type="radio" id="pay1" name="pay" value="pod">
                                    <span class="checkmark"></span>
                                </label>
                                <label for="pay2">
                                    Carte de crédit
                                    <input type="radio" id="pay2" name="pay" value="cc">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <button type="submit" class="site-btn">Passer la commande</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- Checkout Section End -->

<?php include "footer.php"; ?>